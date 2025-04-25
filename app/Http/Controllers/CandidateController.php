<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobAlert;
use App\Models\Resume;
use App\Models\Category;
use App\Models\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\InterviewConfirmation;

class CandidateController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $applications = $user->applications()
            ->with(['jobOffer', 'jobOffer.company', 'jobOffer.location'])
            ->latest()
            ->take(5)
            ->get();

        $interviews = Interview::where('user_id', $user->id)
            ->with(['jobOffer', 'jobOffer.company'])
            ->orderBy('scheduled_at')
            ->take(3)
            ->get();

        $applicationStats = [
            'total' => $user->applications()->count(),
            'pending' => $user->applications()->where('status', 'pending')->count(),
            'reviewed' => $user->applications()->where('status', 'reviewed')->count(),
            'interviewed' => $user->applications()->where('status', 'interview')->count(),
            'offered' => $user->applications()->where('status', 'offered')->count(),
            'rejected' => $user->applications()->where('status', 'rejected')->count(),
        ];

        $successRate = $user->applications()->count() > 0 
            ? round(($user->applications()->whereIn('status', ['interviewed', 'offered', 'hired'])->count() / $user->applications()->count()) * 100) 
            : 0;

        return view('candidate.dashboard', compact('applications', 'interviews', 'applicationStats', 'successRate'));
    }
    
    public function applications()
    {
        $candidateProfile = Auth::user()->candidateProfile;
        
        $applications = $candidateProfile->applications()
            ->with(['jobOffer', 'jobOffer.company', 'jobOffer.location'])
            ->latest()
            ->paginate(10);
        
        return view('candidate.applications', compact('applications'));
    }
    
    public function uploadResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ]);
        
        $path = $request->file('resume')->store('resumes');
        $coverPath = null;
        
        if ($request->hasFile('cover_letter')) {
            $coverPath = $request->file('cover_letter')->store('cover_letters');
        }
        
        Resume::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'resume_path' => $path,
                'cover_letter_path' => $coverPath,
            ]
        );
        
        return redirect()->route('profile.show')->with('success', 'Resume uploaded successfully!');
    }
    
    // Job Alert Methods
    public function jobAlerts()
    {
        $alerts = Auth::user()->jobAlerts;
        $categories = Category::all();
        
        return view('candidate.job-alerts', compact('alerts', 'categories'));
    }
    
    public function saveJobAlerts(Request $request)
    {
        $request->validate([
            'keywords' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|in:full-time,part-time,contract,internship,remote',
            'category_id' => 'nullable|exists:categories,id',
            'frequency' => 'required|in:daily,weekly',
        ]);
        
        JobAlert::create([
            'user_id' => Auth::id(),
            'keywords' => $request->keywords,
            'location' => $request->location,
            'job_type' => $request->job_type,
            'category_id' => $request->category_id,
            'frequency' => $request->frequency,
        ]);
        
        return redirect()->route('candidate.jobAlerts')->with('success', 'Job alert created successfully!');
    }
    
    public function deleteJobAlert(JobAlert $alert)
    {
        // Authorization check
        if ($alert->user_id !== Auth::id()) {
            return abort(403);
        }
        
        $alert->delete();
        
        return redirect()->route('candidate.jobAlerts')->with('success', 'Job alert deleted successfully!');
    }
    
    // Interview Methods
    public function interviews()
    {
        $interviews = Interview::where('user_id', Auth::id())
            ->with('jobOffer', 'jobOffer.company')
            ->orderBy('scheduled_at')
            ->paginate(10);
            
        return view('candidate.interviews', compact('interviews'));
    }
    
    public function confirmInterview(Interview $interview)
    {
        // Authorization check
        if ($interview->user_id !== Auth::id()) {
            return abort(403);
        }
        
        $interview->update(['status' => 'confirmed']);
        
        // Send confirmation email to recruiter
        Mail::to($interview->job->company->user->email)
            ->send(new InterviewConfirmation($interview, true));
        
        return redirect()->route('candidate.interviews')->with('success', 'Interview confirmed successfully!');
    }
    
    public function requestReschedule(Request $request, Interview $interview)
    {
        // Authorization check
        if ($interview->user_id !== Auth::id()) {
            return abort(403);
        }
        
        $request->validate([
            'reschedule_reason' => 'required|string|max:500',
        ]);
        
        $interview->update([
            'status' => 'reschedule_requested',
            'notes' => $request->reschedule_reason,
        ]);
        
        // Send reschedule notification to recruiter
        Mail::to($interview->job->company->user->email)
            ->send(new InterviewConfirmation($interview, false));
        
        return redirect()->route('candidate.interviews')->with('success', 'Reschedule request sent successfully!');
    }
}