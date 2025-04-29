<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Models\CandidateProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    
    // Méthode pour mettre à jour le profil du candidat
    public function updateCandidate(Request $request)
    {
        $this->authorize('update', CandidateProfile::class);
        
        $user = Auth::user();
        $profile = $user->candidateProfile;
        
        if (!$profile) {
            $profile = new CandidateProfile();
            $profile->user_id = $user->id;
        }
        
        $profile->phone = $request->phone;
        $profile->address = $request->address; 
        $profile->bio = $request->bio;
        
        // Assurez-vous que les compétences sont correctement traitées
        // En forçant un tableau même si c'est vide
        $skills = $request->input('skills', []);
        // Si les skills ne sont pas déjà un tableau, créez-en un
        if (!is_array($skills)) {
            $skills = [$skills];
        }
        // Filtrez les valeurs vides
        $skills = array_filter($skills, function($value) {
            return !empty(trim($value));
        });
        
        $profile->skills = $skills;
        
        if ($request->hasFile('cv_path')) {
            if ($profile->cv_path) {
                Storage::disk('public')->delete($profile->cv_path);
            }
            $cvPath = $request->file('cv_path')->store('candidate_cvs', 'public');
            $profile->cv_path = $cvPath;
        }
        
        if ($request->hasFile('profile_picture')) {
            if ($profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }
            $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profile->profile_picture = $imagePath;
        }
        
        $profile->save();
        
        return redirect()->route('profile.show')->with('success', 'Profil mis à jour avec succès');
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