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
        
        // Vérifier si le profil d'entreprise existe, sinon le créer
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
        
        // Correction ici - utilisation de la requête directe avec le bon nom de colonne
        $jobs = JobOffer::where('company_id', $user->companyProfile->id)
                    ->withCount('applications')
                    ->get();
        
        // Récupérer les candidatures récentes
        $recentApplications = [];
        if ($jobs->count() > 0) {
            $recentApplications = Application::whereIn('job_offer_id', $jobs->pluck('id'))
                                ->with(['user', 'jobOffer'])
                                ->latest()
                                ->take(5)
                                ->get();
        } else {
            $recentApplications = collect(); 
        }
        
        return view('recruiter.dashboard', compact('jobs', 'recentApplications'));
    }
    
        // Afficher le formulaire de création d'offre d'emploi
        public function createJob()
        {
            // Récupération des catégories pour le formulaire
            $categories = Category::all();
            $locations = Location::all();
            
            return view('recruiter.jobs.create', compact('categories', 'locations'));
        }
        
        // Traiter la soumission du formulaire de création d'offre
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
        'application_deadline' => 'nullable|date|after_or_equal:today',
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
    $jobOffer->application_deadline = $request->application_deadline;  // Nom complet de la colonne
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
            $locations = Location::all();
            $categories = Category::all();
            $jobOffers = JobOffer::where('company_id', $company->id)
                    ->withCount('applications')
                    ->latest()
                    ->paginate(10);
                    
            return view('jobs.index', compact('jobOffers', 'locations', 'categories'));
        }
    
        public function editJob(JobOffer $job)
        {
            // Vérifier que l'offre appartient bien à l'entreprise du recruteur connecté
            if ($job->company_id !== Auth::user()->companyProfile->id) {
                return redirect()->route('recruiter.jobs')->with('error', 'Vous n\'êtes pas autorisé à modifier cette offre.');
            }
            
            $categories = Category::all();
            
            return view('recruiter.jobs.edit', compact('job', 'categories'));
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
        'employment_type' => 'required|string|in:full-time,part-time,contract,internship,temporary',
        'requirements' => 'nullable|string',
        'benefits' => 'nullable|string',
        'deadline' => 'nullable|date|after_or_equal:today',
    ]);
    
    $job->title = $request->title;
    $job->description = $request->description;
    $job->categorie_id = $request->categorie_id;
    $job->location_id = $request->location_id;
    $job->salary = $request->salary;
    $job->employment_type = $request->employment_type;
    $job->requirements = $request->requirements;
    $job->benefits = $request->benefits;
    $job->deadline = $request->deadline;
    $job->is_active = $request->has('is_active') ? true : false;
    
    $job->save();
    
    return redirect()->route('recruiter.jobs')->with('success', 'Offre d\'emploi mise à jour avec succès!');
}

/**
 * Supprime une offre d'emploi
 */
public function destroyJob(JobOffer $job)
{
    // Vérifier que l'offre appartient bien à l'entreprise du recruteur connecté
    if ($job->company_id !== Auth::user()->companyProfile->id) {
        return redirect()->route('recruiter.jobs')->with('error', 'Vous n\'êtes pas autorisé à supprimer cette offre.');
    }
    
    // Supprimer d'abord les candidatures liées
    $job->applications()->delete();
    
    // Puis supprimer l'offre
    $job->delete();
    
    return redirect()->route('recruiter.jobs')->with('success', 'Offre d\'emploi supprimée avec succès!');
}

/**
 * Affiche les candidatures pour une offre d'emploi
 */
public function viewApplications(JobOffer $job)
{
    // Vérifier que l'offre appartient bien à l'entreprise du recruteur connecté
    if ($job->company_id !== Auth::user()->companyProfile->id) {
        return redirect()->route('recruiter.jobs')->with('error', 'Vous n\'êtes pas autorisé à voir ces candidatures.');
    }
    
    $applications = $job->applications()->with(['user', 'user.candidateProfile'])->latest()->paginate(10);
    
    return view('recruiter.jobs.applications', compact('job', 'applications'));
}
    // Statistics page
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