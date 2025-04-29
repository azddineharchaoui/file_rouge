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
            $companyProfile->company_name = 'Entreprise de ' . $user->name; // Nom par défaut
            $companyProfile->industry = 'Non spécifié';
            $companyProfile->size = 'Non spécifié';
            $companyProfile->description = 'Veuillez compléter votre profil d\'entreprise';
            $companyProfile->save();
            
            $user = $user->fresh();
        }
        
        $jobs = JobOffer::where('company_id', $user->companyProfile->id)
                    ->withCount('applications')
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
    
        // Afficher le formulaire de création d'offre d'emploi
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
                'benefits' => 'nullable|string',
                'responsibilities' => 'nullable|string',
                // 'application_deadline' => 'nullable|date|after_or_equal:today',
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
            $jobOffer->responsibilities = $request->responsibilities;
            $jobOffer->benefits = $request->benefits;
            // $jobOffer->application_deadline = $request->application_deadline;  // Nom complet de la colonne
            $jobOffer->experience_level = $request->experience_level;
            $jobOffer->is_remote = $request->is_remote ? true : false;
            $jobOffer->is_featured = false;  
            $jobOffer->save();
            
            return redirect()->route('recruiter.jobs')->with('success', 'Offre d\'emploi créée avec succès!');
        }
        
        // Afficher la liste des offres d'emploi du recruteur
        public function jobs()
        {
            $company = Auth::user()->companyProfile;
            $jobOffers = JobOffer::where('company_id', $company->id)
                    ->withCount('applications')
                    ->latest()
                    ->paginate(10);
                    
            return view('recruiter.jobs.index', compact('jobOffers'));
        }
    
        public function editJob(JobOffer $job)
        {
            // Verifier que l'offre appartient bien à l'entreprise du recruteur connecté
            if ($job->company_id !== Auth::user()->companyProfile->id) {
                return redirect()->route('recruiter.jobs')->with('error', 'Vous n\'êtes pas autorisé à modifier cette offre.');
            }
            
            $categories = Category::all();
            $locations = Location::all();

            
            return view('recruiter.jobs.edit', compact('job', 'categories', 'locations'));
        }
        public function updateJob(Request $request, JobOffer $job)
        {
            // Vérifier que l'offre appartient bien à l'entreprise du recruteur connecté
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
                'benefits' => 'nullable|string',
            ]);
            
            if ($job->company_id !== Auth::user()->companyProfile->id) {
                return redirect()->route('recruiter.jobs')->with('error', 'Vous n\'êtes pas autorisé à modifier cette offre.');
            }

            $job->title = $request->title;
            $job->description = $request->description;
            $job->categorie_id = $request->categorie_id;
            $job->location_id = $request->location_id;
            $job->salary = $request->salary;
            $job->employment_type = $request->employment_type;
            $job->requirements = $request->requirements;
            $job->benefits = $request->benefits;
            // $job->is_active = $request->has('is_active') ? true : false;
            
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
        
        // Correction pour utiliser la bonne colonne
        $jobs = JobOffer::where('company_id', $company->id)->pluck('id');
        
        $interviews = Interview::whereIn('job_offer_id', $jobs)
            ->with(['jobOffer', 'user'])  // Corriger 'job' à 'jobOffer' si nécessaire
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
        // Vérifier que la candidature est liée à une offre de l'entreprise du recruteur
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
        
        // Si le statut est changé à "interview", mettre à jour toute planification d'entretien existante
        if ($request->status === 'interview') {
            // Optionnel : logique pour mettre à jour entretien existant ou envoyer notification
        }
        
        return redirect()->back()->with('success', 'Statut de la candidature mis à jour avec succès.');
    }
    public function scheduleInterview(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',  
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:240',
            'interview_type' => 'required|in:video,phone,in-person',
            'meeting_link' => 'required_if:interview_type,video|nullable|url',
            'location' => 'required_if:interview_type,in-person|nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        $jobOffer = JobOffer::findOrFail($request->job_offer_id);
        
        if ($jobOffer->company_id !== Auth::user()->companyProfile->id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à planifier un entretien pour cette offre.');
        }
        
        $application = Application::where('job_offer_id', $request->job_offer_id)
            ->where('user_id', $request->user_id)
            ->first();
        
        if ($application) {
            $application->status = 'interview';
            $application->save();
        }
        
        $interview = new Interview();
        $interview->job_offer_id = $request->job_offer_id;
        $interview->user_id = $request->user_id;
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
     * Affiche le CV d'une candidature
     */
    public function viewResume(Application $application)
    {
        // Vérifier que l'utilisateur est autorisé à voir ce CV
        $job = JobOffer::find($application->job_offer_id);
        
        if (!$job || $job->company_id !== Auth::user()->companyProfile->id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à voir ce CV.');
        }
        
        // Si le chemin du CV est stocké dans l'application
        if (!$application->resume_path) {
            return redirect()->back()->with('error', 'Aucun CV n\'est disponible pour cette candidature.');
        }
        
        // Construire le chemin du fichier
        $filePath = storage_path('app/' . $application->resume_path);
        
        // Vérifier si le fichier existe
        if (!file_exists($filePath)) {
            // Essayer de trouver le CV dans le profil du candidat
            $user = $application->user;
            if ($user && $user->candidateProfile && $user->candidateProfile->cv_path) {
                $candidateFilePath = storage_path('app/' . $user->candidateProfile->cv_path);
                if (file_exists($candidateFilePath)) {
                    return response()->file($candidateFilePath);
                }
            }
            
            return redirect()->back()->with('error', 'Le fichier CV n\'a pas été trouvé dans le système. Veuillez contacter le candidat pour obtenir une copie à jour.');
        }
        
        // Retourner le fichier à partir du stockage
        return response()->file($filePath);
    }

    /**
     * Affiche le CV d'un candidat par son ID utilisateur
     */
    public function viewResumeByUser($userId)
    {
        $user = User::find($userId);
        
        if (!$user || !$user->candidateProfile) {
            return redirect()->back()->with('error', 'Profil du candidat non trouvé.');
        }
        
        if (!$user->candidateProfile->cv_path) {
            return redirect()->back()->with('error', 'Aucun CV n\'est disponible pour ce candidat.');
        }
        
        // Vérifier que l'utilisateur a postulé à l'une des offres de l'entreprise
        $companyId = Auth::user()->companyProfile->id;
        $hasApplied = Application::whereHas('jobOffer', function($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->where('user_id', $userId)
            ->exists();
        
        if (!$hasApplied) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à voir ce CV.');
        }
        
        // Construire le chemin du fichier
        $filePath = storage_path('app/' . $user->candidateProfile->cv_path);
        
        // Vérifier si le fichier existe
        if (!file_exists($filePath)) {
            // Essayer de trouver le CV dans les candidatures récentes
            $application = Application::whereHas('jobOffer', function($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                })
                ->where('user_id', $userId)
                ->whereNotNull('resume_path')
                ->latest()
                ->first();
                
            if ($application && $application->resume_path) {
                $applicationFilePath = storage_path('app/' . $application->resume_path);
                if (file_exists($applicationFilePath)) {
                    return response()->file($applicationFilePath);
                }
            }
            
            return redirect()->back()->with('error', 'Le fichier CV n\'a pas été trouvé dans le système. Le candidat n\'a peut-être pas encore téléchargé son CV.');
        }
        
        // Retourner le fichier à partir du stockage
        return response()->file($filePath);
    }

    /**
     * Vérifie si un CV est disponible pour un utilisateur
     */
    public function checkResumeAvailability($userId)
    {
        $user = User::find($userId);
        $resumeExists = false;
        
        if ($user && $user->candidateProfile && $user->candidateProfile->cv_path) {
            $filePath = storage_path('app/' . $user->candidateProfile->cv_path);
            $resumeExists = file_exists($filePath);
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
                $applicationFilePath = storage_path('app/' . $application->resume_path);
                $resumeExists = file_exists($applicationFilePath);
            }
        }
        
        return response()->json(['resumeExists' => $resumeExists]);
    }
}