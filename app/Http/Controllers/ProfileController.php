<?php

namespace App\Http\Controllers;

use App\Models\CandidateProfile;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        if ($user->isCandidate()) {
            $profile = $user->candidateProfile ?? new CandidateProfile();
            return view('profile.candidate', compact('profile'));
        }
        
        if ($user->isRecruiter()) {
            $profile = $user->companyProfile ?? new CompanyProfile();
            return view('profile.company', compact('profile'));
        }

        return redirect()->route('home');
    }

    public function updateCandidate(Request $request)
    {
        $user = Auth::user();
        $this->authorize('update', CandidateProfile::class);

        $validated = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'skills' => 'nullable|array',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'cv_path' => 'nullable|file|mimes:pdf|max:2048',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $profile = $user->candidateProfile ?? new CandidateProfile(['user_id' => $user->id]);

        if ($request->hasFile('cv_path')) {
            $validated['cv_path'] = $request->file('cv_path')->store('cvs', 'public');
        }

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        $profile->fill($validated)->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function updateCompany(Request $request)
    {
        $user = Auth::user();
        $this->authorize('update', CompanyProfile::class);

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'industry' => 'nullable|string|max:100',
            'size' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $profile = $user->companyProfile ?? new CompanyProfile(['user_id' => $user->id]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $profile->fill($validated)->save();

        return redirect()->route('profile.show')->with('success', 'Company profile updated successfully!');
    }
}