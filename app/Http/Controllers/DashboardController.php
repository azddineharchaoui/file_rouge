<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isCandidate()) {
            $applications = Application::where('candidate_profile_id', $user->candidateProfile->id)
                ->with('jobOffer.company')
                ->latest()
                ->paginate(10);
            
            return view('dashboard.candidate', compact('applications'));
        }

        if ($user->isRecruiter()) {
            $jobOffers = JobOffer::where('company_id', $user->companyProfile->id)
                ->withCount('applications')
                ->latest()
                ->paginate(10);
            
            $applications = Application::whereHas('jobOffer', fn($q) => 
                $q->where('company_id', $user->companyProfile->id)
            )
                ->with(['jobOffer', 'candidateProfile.user'])
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.recruiter', compact('jobOffers', 'applications'));
        }

        return redirect()->route('home');
    }

    public function updateApplicationStatus(Request $request, Application $application)
    {
        $this->authorize('update', $application);

        $validated = $request->validate([
            'status' => 'required|in:submitted,under_review,interview_scheduled,rejected,accepted',
            'recruiter_notes' => 'nullable|string|max:1000',
        ]);

        $application->update($validated);

        return redirect()->route('dashboard')->with('success', 'Application status updated!');
    }
}