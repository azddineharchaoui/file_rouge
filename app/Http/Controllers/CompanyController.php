<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\JobOffer;
use App\Models\Location;
use App\Models\Interview;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Mail\InterviewInvitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        if (!$user->companyProfile) {
            $companyProfile = new CompanyProfile();
            $companyProfile->user_id = $user->id;
            $companyProfile->company_name = 'Entreprise de ' . $user->name; 
            $companyProfile->industry = 'Non spécifié';
            $companyProfile->size = 'Non spécifié';
            $companyProfile->description = 'Veuillez compléter votre profil d\'entreprise';
            $companyProfile->save();
            
            $user = $user->fresh();
        }
        
        $jobs = JobOffer::where('company_id', $user->companyProfile->id)
                    ->withCount('applications')
                    ->latest()
                    ->get();
        
        $recentApplications = [];
        if ($jobs->count() > 0) {
            $recentApplications = Application::whereIn('job_offer_id', $jobs->pluck('id'))
                            ->with(['candidateProfile.user', 'jobOffer']) 
                            ->latest()
                            ->take(5)
                            ->get();

            $upcomingInterviews = Interview::whereIn('job_offer_id', $jobs->pluck('id'))
                            ->with(['user', 'jobOffer'])
                            ->where('scheduled_at', '>=', now())
                            ->orderBy('scheduled_at')
                            ->take(5)
                            ->get();
        } else {
            $recentApplications = collect(); 
            $upcomingInterviews = collect();
        }
        
        return view('recruiter.dashboard', compact('jobs', 'recentApplications', 'upcomingInterviews'));
    }
    
    public function createJob()
    {
        $categories = Category::all();
        $locations = Location::all();
        
        return view('recruiter.jobs.create', compact('categories', 'locations'));
    }
    
    public function storeJob(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'categorie_id' => 'required|exists:categories,id',  
            'location_id' => 'required|exists:locations,id',
            'salary' => 'required|numeric',
            'employment_type' => 'required|string',
            'requirements' => 'nullable|string',
            'experience_level' => 'nullable|string',
            'is_remote' => 'nullable|boolean',
        ]);
        
        $jobOffer = new JobOffer();
        $jobOffer->title = $request->title;
        $jobOffer->description = $request->description;
        $jobOffer->categorie_id = $request->categorie_id;
        $jobOffer->company_id = Auth::user()->companyProfile->id;
        $jobOffer->location_id = $request->location_id;
        $jobOffer->salary = $request->salary;
        $jobOffer->employment_type = $request->employment_type;
        $jobOffer->requirements = $request->requirements;
        $jobOffer->experience_level = $request->experience_level;
        $jobOffer->is_remote = $request->is_remote ? true : false;
        $jobOffer->is_featured = false;
        $jobOffer->save();
        
        return redirect()->route('recruiter.jobs')->with('success', 'Offre d\'emploi créée avec succès!');
    }
    
    public function jobs()
    {
        $company = Auth::user()->companyProfile;
        $jobOffers = JobOffer::where('company_id', $company->id)
                ->withCount('applications')
                ->latest()
                ->get();
                
        return view('recruiter.jobs.index', compact('jobOffers'));
    }

    public function editJob(JobOffer $job)
    {
        if ($job->company_id !== Auth::user()->companyProfile->id) {
            return redirect()->route('recruiter.jobs')->with('error', 'Vous n\'êtes pas autorisé à modifier cette offre.');
        }
        
        $categories = Category::all();
        $locations = Location::all();
        
        return view('recruiter.jobs.edit', compact('job', 'categories', 'locations'));
    }
    
    public function updateJob(Request $request, JobOffer $job)
    {
        if ($job->company_id !== Auth::user()->companyProfile->id) {
            return redirect()->route('recruiter.jobs')->with('error', 'Vous n\'êtes pas autorisé à modifier cette offre.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'categorie_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'salary' => 'required|numeric',
            'employment_type' => 'required|string',
            'requirements' => 'nullable|string',
        ]);

        $job->title = $request->title;
        $job->description = $request->description;
        $job->categorie_id = $request->categorie_id;
        $job->location_id = $request->location_id;
        $job->salary = $request->salary;
        $job->employment_type = $request->employment_type;
        $job->requirements = $request->requirements;
        
        $job->save();
        
        return redirect()->route('recruiter.jobs')->with('success', 'Offre d\'emploi mise à jour avec succès!');
    }

    /**
     * Supprime une offre d'emploi
     */
    public function destroyJob(JobOffer $job)
    {
        if ($job->company_id !== Auth::user()->companyProfile->id) {
            return redirect()->route('recruiter.jobs')->with('error', 'Vous n\'êtes pas autorisé à supprimer cette offre.');
        }
        
        $job->applications()->delete();
        
        $job->delete();
        
        return redirect()->route('recruiter.jobs')->with('success', 'Offre d\'emploi supprimée avec succès!');
    }

    /**
     * Affiche les candidatures pour une offre d'emploi
     */
    public function viewApplications(JobOffer $job)
    {
        if ($job->company_id !== Auth::user()->companyProfile->id) {
            return redirect()->route('recruiter.jobs')->with('error', 'Vous n\'êtes pas autorisé à voir ces candidatures.');
        }
        
        $applications = $job->applications()->with(['user', 'user.candidateProfile'])->latest()->paginate(10);
        
        return view('recruiter.jobs.applications', compact('job', 'applications'));
    }
    
    public function statistics()
    {
        $company = Auth::user()->companyProfile;
        $jobs = JobOffer::where('company_id', $company->id)
            ->withCount('applications')
            ->get();
        
        $applicationsByJob = [];
        foreach ($jobs as $job) {
            $applicationsByJob[$job->title] = $job->applications_count;
        }
        
        $applicationStatuses = Application::whereIn('job_offer_id', $jobs->pluck('id'))
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
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
    
    public function interviews()
    {
        $company = Auth::user()->companyProfile;
        
        $jobs = JobOffer::where('company_id', $company->id)->pluck('id');
        
        $expiredInterviews = Interview::whereIn('job_offer_id', $jobs)
            ->where('status', 'scheduled')
            ->where('scheduled_at', '<', now())
            ->get();
            
        $expiredCount = $expiredInterviews->count();
        
        if ($expiredCount > 0) {
            foreach ($expiredInterviews as $interview) {
                $interview->status = 'canceled';
                $interview->notes = ($interview->notes ? $interview->notes . "\n\n" : '') . 
                    "Annulé automatiquement: L'entretien n'a pas été confirmé avant la date prévue.";
                $interview->save();
            }
            session()->flash('info', "Attention : {$expiredCount} entretien(s) non confirmé(s) et dépassé(s) ont été annulés automatiquement.");
        }
        
        $interviews = Interview::whereIn('job_offer_id', $jobs)
            ->with(['jobOffer', 'user'])
            ->orderBy('scheduled_at')
            ->paginate(10);
            
        $candidates = Application::whereIn('job_offer_id', $jobs)
            ->with('user')
            ->get()
            ->pluck('user')
            ->unique('id');
            
        return view('recruiter.interviews', compact('interviews', 'candidates'));
    }
    
    /**
     * Met à jour le statut d'une candidature
     */
    public function updateApplicationStatus(Request $request, Application $application)
    {
        $job = JobOffer::find($application->job_offer_id);
        
        if (!$job || $job->company_id !== Auth::user()->companyProfile->id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier cette candidature.');
        }
        
        $request->validate([
            'status' => 'required|in:pending,reviewed,interview,offered,rejected',
            'recruiter_notes' => 'nullable|string',
        ]);
        
        $application->status = $request->status;
        
        if ($request->filled('recruiter_notes')) {
            $application->recruiter_notes = $request->recruiter_notes;
        }
        
        $application->save();
        
      
        
        return redirect()->back()->with('success', 'Statut de la candidature mis à jour avec succès.');
    }
    
    public function scheduleInterview(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:240',
            'interview_type' => 'required|in:video,phone,in-person',
            'meeting_link' => 'required_if:interview_type,video|nullable|url',
            'location' => 'required_if:interview_type,in-person|nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        $application = Application::findOrFail($request->application_id);
        
        $jobOffer = JobOffer::findOrFail($application->job_offer_id);
        
        if ($jobOffer->company_id !== Auth::user()->companyProfile->id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à planifier un entretien pour cette offre.');
        }
        
        $application->status = 'interview';
        $application->save();
        
        $interview = new Interview();
        $interview->job_offer_id = $application->job_offer_id;
        $interview->user_id = $application->user_id;
        $interview->application_id = $application->id;
        $interview->scheduled_at = $request->scheduled_at;
        $interview->duration_minutes = $request->duration_minutes;
        $interview->interview_type = $request->interview_type;
        $interview->meeting_link = $request->interview_type === 'video' ? $request->meeting_link : null;
        $interview->location = $request->interview_type === 'in-person' ? $request->location : null;
        $interview->notes = $request->notes;
        $interview->status = 'scheduled';
        $interview->save();
        
        
        
        return redirect()->back()->with('success', 'Entretien planifié avec succès et candidat notifié.');
    }
    
    /**
     * Met à jour le statut d'un entretien
     */
    public function updateInterviewStatus(Request $request, Interview $interview)
    {
        $jobOffer = JobOffer::find($interview->job_offer_id);
        
        if (!$jobOffer || $jobOffer->company_id !== Auth::user()->companyProfile->id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier cet entretien.');
        }
        
        $request->validate([
            'status' => 'required|in:scheduled,confirmed,completed,no-show,canceled',
        ]);
        
        $interview->status = $request->status;
        
        if ($request->filled('notes')) {
            $interview->notes = $request->notes;
        }
        
        if ($request->filled('scheduled_at')) {
            $request->validate([
                'scheduled_at' => 'required|date|after:now',
            ]);
            
            $interview->scheduled_at = $request->scheduled_at;
            $interview->status = 'scheduled'; 
        }
        
        $interview->save();
        
        $statusMessages = [
            'scheduled' => 'L\'entretien a été reprogrammé avec succès.',
            'confirmed' => 'Le statut de l\'entretien a été mis à jour avec succès.',
            'completed' => 'L\'entretien a été marqué comme terminé.',
            'no-show' => 'L\'entretien a été marqué comme absence du candidat.',
            'canceled' => 'L\'entretien a été annulé avec succès.',
        ];
        
        return redirect()->back()->with('success', $statusMessages[$request->status] ?? 'Le statut de l\'entretien a été mis à jour.');
    }
    
    /**
     * Affiche le CV d'une candidature
     */
    public function viewResume(Application $application)
    {
        $job = JobOffer::find($application->job_offer_id);
        
        if (!$job || $job->company_id !== Auth::user()->companyProfile->id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à voir ce CV.');
        }
        
        if ($application->resume_path) {
            $filePath = storage_path('app/public/' . $application->resume_path);
            $regularPath = storage_path('app/' . $application->resume_path);
            
            if (file_exists($filePath)) {
                return response()->file($filePath);
            } elseif (file_exists($regularPath)) {
                return response()->file($regularPath);
            }
        }
        
        $user = $application->user;
        if ($user && $user->candidateProfile && $user->candidateProfile->cv_path) {
            $candidateFilePath = storage_path('app/public/' . $user->candidateProfile->cv_path);
            $regularCandidatePath = storage_path('app/' . $user->candidateProfile->cv_path);
            
            if (file_exists($candidateFilePath)) {
                return response()->file($candidateFilePath);
            } elseif (file_exists($regularCandidatePath)) {
                return response()->file($regularCandidatePath);
            }
        }
        
        $recentApplicationWithCV = Application::where('user_id', $application->user_id)
            ->whereNotNull('resume_path')
            ->where('id', '!=', $application->id)
            ->latest()
            ->first();
        
        if ($recentApplicationWithCV && $recentApplicationWithCV->resume_path) {
            $recentPath = storage_path('app/public/' . $recentApplicationWithCV->resume_path);
            $regularRecentPath = storage_path('app/' . $recentApplicationWithCV->resume_path);
            
            if (file_exists($recentPath)) {
                return response()->file($recentPath);
            } elseif (file_exists($regularRecentPath)) {
                return response()->file($regularRecentPath);
            }
        }
        
        return redirect()->back()->with('error', 'Le fichier CV n\'a pas été trouvé. Veuillez demander au candidat de mettre à jour son CV.');
    }

    /**
     * Affiche le CV d'un candidat par son ID utilisateur
     */
    public function viewResumeByUser($userId)
    {
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }
        
        $companyId = Auth::user()->companyProfile->id;
        $hasApplied = Application::whereHas('jobOffer', function($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->where('user_id', $userId)
            ->exists();
        
        if (!$hasApplied) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à voir ce CV.');
        }
        
        if ($user->candidateProfile && $user->candidateProfile->cv_path) {
            $publicPath = storage_path('app/public/' . $user->candidateProfile->cv_path);
            $regularPath = storage_path('app/' . $user->candidateProfile->cv_path);
            
            if (file_exists($publicPath)) {
                return response()->file($publicPath);
            } elseif (file_exists($regularPath)) {
                return response()->file($regularPath);
            }
        }
        
        $application = Application::whereHas('jobOffer', function($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->where('user_id', $userId)
            ->whereNotNull('resume_path')
            ->latest()
            ->first();
        
        if ($application && $application->resume_path) {
            $publicPath = storage_path('app/public/' . $application->resume_path);
            $regularPath = storage_path('app/' . $application->resume_path);
            
            if (file_exists($publicPath)) {
                return response()->file($publicPath);
            } elseif (file_exists($regularPath)) {
                return response()->file($regularPath);
            }
        }
        
        return redirect()->back()->with('error', 'Aucun CV trouvé pour ce candidat. Veuillez lui demander de télécharger son CV.');
    }
    
    /**
     * Vérifie si un CV est disponible pour un utilisateur
     */
    public function checkResumeAvailability($userId)
    {
        $user = User::find($userId);
        $resumeExists = false;
        
        if ($user && $user->candidateProfile && $user->candidateProfile->cv_path) {
            $publicPath = storage_path('app/public/' . $user->candidateProfile->cv_path);
            $regularPath = storage_path('app/' . $user->candidateProfile->cv_path);
            
            if (file_exists($publicPath) || file_exists($regularPath)) {
                $resumeExists = true;
            }
        }
        
        if (!$resumeExists) {
            $companyId = Auth::user()->companyProfile->id;
            $application = Application::whereHas('jobOffer', function($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                })
                ->where('user_id', $userId)
                ->whereNotNull('resume_path')
                ->latest()
                ->first();
                
            if ($application && $application->resume_path) {
                $publicPath = storage_path('app/public/' . $application->resume_path);
                $regularPath = storage_path('app/' . $application->resume_path);
                
                if (file_exists($publicPath) || file_exists($regularPath)) {
                    $resumeExists = true;
                }
            }
        }
        
        return response()->json(['resumeExists' => $resumeExists]);
    }
}