<?php

namespace App\Http\Controllers;

use App\Models\Application;
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
            'interview' => $user->applications()->where('status', 'interview')->count(),
            'offered' => $user->applications()->where('status', 'offered')->count(),
            'rejected' => $user->applications()->where('status', 'rejected')->count(),
        ];
        
        return view('candidate.dashboard', compact('applications', 'interviews', 'applicationStats'));
    }

    public function applications()
    {
        $applications = Auth::user()->applications()
            ->with(['jobOffer', 'jobOffer.company', 'jobOffer.location'])
            ->latest()
            ->paginate(10);
            
        return view('candidate.applications', compact('applications'));
    }
    
    /**
     * Upload a resume
     */
    public function uploadResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);
        
        $user = Auth::user();
        
        if (!$user->candidateProfile) {
            return redirect()->back()->with('error', 'Vous devez d\'abord créer un profil de candidat.');
        }
        
        $file = $request->file('resume');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('resumes', $filename, 'public');
        
        $user->candidateProfile->cv_path = $path;
        $user->candidateProfile->cv_name = $file->getClientOriginalName();
        $user->candidateProfile->save();
        
        return redirect()->route('profile.show')->with('success', 'Resume uploaded successfully!');
    }
    
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
        if ($interview->user_id !== Auth::id()) {
            return abort(403);
        }
        
        if ($interview->status !== 'scheduled') {
            return redirect()->back()->with('error', 'Cet entretien ne peut pas être confirmé dans son état actuel.');
        }
        
        $interview->status = 'confirmed';
        $interview->save();
        
        Mail::to($interview->jobOffer->company->user->email)
            ->send(new InterviewConfirmation($interview));
        
        return redirect()->back()->with('success', 'Entretien confirmé avec succès!');
    }
    
    public function requestReschedule(Request $request, Interview $interview)
    {
        if ($interview->user_id !== Auth::id()) {
            return abort(403);
        }
        
        if (!in_array($interview->status, ['scheduled', 'confirmed'])) {
            return redirect()->back()->with('error', 'Cet entretien ne peut pas être reprogrammé dans son état actuel.');
        }
        
        $request->validate([
            'reschedule_reason' => 'required|string|max:500',
        ]);
        
        $interview->status = 'reschedule_requested';
        $interview->reschedule_reason = $request->reschedule_reason;
        $interview->save();
        
        
        return redirect()->back()->with('success', 'Demande de reprogrammation envoyée avec succès!');
    }
}