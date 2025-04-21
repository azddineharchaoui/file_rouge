<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\CompanyProfile;
use App\Models\Application;
use App\Models\Interview;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\InterviewInvitation;

class CompanyController extends Controller
{
    public function dashboard()
    {
        $company = Auth::user()->companyProfile;
        $jobs = $company->jobOffers()->withCount('applications')->get();
        
        $recentApplications = Application::whereIn('job_offer_id', $jobs->pluck('id'))
            ->with(['jobOffer', 'candidateProfile'])
            ->latest()
            ->take(5)
            ->get();
            
        $upcomingInterviews = Interview::whereIn('job_offer_id', $jobs->pluck('id'))
            ->with(['jobOffer', 'candidateProfile'])
            ->where('scheduled_at', '>', Carbon::now())
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();
            
        // Analytics data
        $applicationsByDate = Application::whereIn('job_offerid', $jobs->pluck('id'))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
            
        $jobViews = $jobs->sum('views');
        
        return view('recruiter.dashboard', compact(
            'company', 
            'jobs', 
            'recentApplications', 
            'upcomingInterviews',
            'applicationsByDate',
            'jobViews'
        ));
    }
    
    // Statistics page
    public function statistics()
    {
        $company = Auth::user()->companyProfile;
        $jobs = $company->jobs()->withCount('applications')->get();
        
        // Applications by job
        $applicationsByJob = [];
        foreach ($jobs as $job) {
            $applicationsByJob[$job->title] = $job->applications_count;
        }
        
        // Conversion rates
        $applicationStatuses = Application::whereIn('job_offer_id', $jobs->pluck('id'))
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        // Views to applications ratio
        $jobsWithData = $jobs->map(function ($job) {
            $applicationRate = $job->views > 0 ? ($job->applications_count / $job->views) * 100 : 0;
            return [
                'title' => $job->title,
                'views' => $job->views,
                'applications' => $job->applications_count,
                'application_rate' => round($applicationRate, 2),
            ];
        });
        
        return view('recruiter.statistics', compact(
            'company', 
            'applicationsByJob',
            'applicationStatuses',
            'jobsWithData'
        ));
    }
    
    // Interview methods
    public function interviews()
    {
        $company = Auth::user()->companyProfile;
        $jobs = $company->jobs()->pluck('id');
        
        $interviews = Interview::whereIn('job_offer_id', $jobs)
            ->with(['job', 'user'])
            ->orderBy('scheduled_at')
            ->paginate(10);
            
        $candidates = Application::whereIn('job_offer_id', $jobs)
            ->with('user')
            ->get()
            ->pluck('user')
            ->unique('id');
            
        return view('recruiter.interviews', compact('interviews', 'candidates'));
    }
    
    public function scheduleInterview(Request $request)
    {
        $request->validate([
            'job_offer_id' => 'required|exists:jobs,id',
            'user_id' => 'required|exists:users,id',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:180',
            'interview_type' => 'required|in:in-person,video,phone',
            'location' => 'required_if:interview_type,in-person',
            'meeting_link' => 'required_if:interview_type,video|nullable|url',
            'notes' => 'nullable|string',
        ]);
        
        // Verify the job belongs to this company
        $job = Job::findOrFail($request->job_offer_id);
        if ($job->company_id !== Auth::user()->company->id) {
            return back()->with('error', 'Unauthorized action.');
        }
        
        // Create the interview
        $interview = Interview::create([
            'job_offer_id' => $request->job_offer_id,
            'user_id' => $request->user_id,
            'scheduled_at' => $request->scheduled_at,
            'duration_minutes' => $request->duration_minutes,
            'interview_type' => $request->interview_type,
            'location' => $request->location,
            'meeting_link' => $request->meeting_link,
            'status' => 'scheduled',
            'notes' => $request->notes,
        ]);
        
        // Update application status
        Application::where('job_offer_id', $request->job_offer_id)
            ->where('user_id', $request->user_id)
            ->update(['status' => 'interview']);
        
        // Send email notification
        $candidate = User::find($request->user_id);
        Mail::to($candidate->email)->send(new InterviewInvitation($interview));
        
        return redirect()->route('recruiter.interviews')->with('success', 'Interview scheduled successfully!');
    }
}