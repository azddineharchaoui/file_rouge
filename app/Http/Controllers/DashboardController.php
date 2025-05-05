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
            
            return view('candidate.dashboard', compact('applications'));
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

            return view('recruiter.dashboard', compact('jobOffers', 'applications'));
        }

        return redirect()->route('home');
    }

    public function updateApplicationStatus(Request $request, Application $application)
    {
        $job = JobOffer::find($application->job_offer_id);
        
        if (!$job || $job->company_id !== Auth::user()->companyProfile->id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier cette candidature.');
        }
        
        $request->validate([
            'status' => 'required|in:pending,reviewed,interview,offered,rejected',
        ]);
        
        $application->status = $request->status;
        $application->save();
        
        return redirect()->back()->with('success', 'Statut de la candidature mis à jour avec succès.');
    }
}