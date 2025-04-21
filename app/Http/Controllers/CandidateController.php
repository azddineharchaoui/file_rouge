<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    public function applications()
    {
        $applications = Auth::user()->applications()
            ->with('job', 'job.company')
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
        
        // Resume upload logic
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
}