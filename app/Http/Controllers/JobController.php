<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\Category;
use App\Models\Location;
use App\Models\Application;
use App\Models\CandidateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        $jobOffers = JobOffer::with(['company', 'category', 'location'])
            ->latest()
            ->paginate(10);
        
        $locations = Location::all();
        $categories = Category::all();

        return view('jobs.index', compact('jobOffers', 'locations', 'categories'));
    }

    public function create()
    {
        $this->authorize('create', JobOffer::class);
        
        $categories = Category::all();
        $locations = Location::all();
        
        return view('jobs.create', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', JobOffer::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'benefits' => 'nullable|string',
            'salary' => 'required|integer|min:0',
            'employment_type' => 'required|in:Full-time,Part-time,Contract,Temporary,Internship',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'is_remote' => 'boolean',
            'application_deadline' => 'required|date|after:today',
            'experience_level' => 'required|in:Entry,Intermediate,Senior',
        ]);

        JobOffer::create([
            ...$validated,
            'company_id' => Auth::user()->companyProfile->id,
            'is_featured' => $request->boolean('is_featured', false),
        ]);

        return redirect()->route('jobs.index')->with('success', 'Job offer created successfully!');
    }

    public function show(JobOffer $job)
    {
        $job->increment('views');

        $similarJobs = JobOffer::where('categorie_id', $job->categorie_id)
            ->where('id', '!=', $job->id) 
            ->with(['company', 'category', 'location'])
            ->take(3)
            ->latest()
            ->get();
            
        if ($similarJobs->count() < 3) {
            $additionalJobs = JobOffer::where('id', '!=', $job->id)
                ->whereNotIn('id', $similarJobs->pluck('id'))
                ->with(['company', 'category', 'location'])
                ->take(3 - $similarJobs->count())
                ->latest()
                ->get();
                
            $similarJobs = $similarJobs->concat($additionalJobs);
        }

        return view('jobs.show', compact('job', 'similarJobs'));
    }

    public function apply(JobOffer $job)
    {
        $this->authorize('apply', $job);
        
        $user = Auth::user();
        $candidateProfile = $user->candidateProfile;
        
        // Vérifier si le candidat a un CV
        if (!$candidateProfile || !$candidateProfile->cv_path) {
            return redirect()->route('jobs.show', $job->id)
                ->with('error', 'Vous devez télécharger un CV dans votre profil avant de pouvoir postuler.');
        }
        
        // Vérifier si l'utilisateur a déjà postulé à cette offre
        $existingApplication = Application::where('job_offer_id', $job->id)
            ->where('candidate_profile_id', $candidateProfile->id)
            ->first();

        if ($existingApplication) {
            return redirect()->route('jobs.show', $job->id)
                ->with('error', 'Vous avez déjà postulé à cette offre.');
        }


        $application = Application::create([
            'job_offer_id' => $job->id,
            'user_id' => $user->id,
            'candidate_profile_id' => $candidateProfile->id,
            'resume_path' => $candidateProfile->cv_path,
            'cover_letter_path' => $candidateProfile->cover_letter_path,
            'status' => 'pending',
            'cover_note' => 'Candidature soumise automatiquement via le site web',
            'applied_at' => now(),
        ]);
        
        
        return redirect()->route('jobs.show', $job->id)
            ->with('success', 'Votre candidature a été envoyée avec succès! Vous pouvez suivre son statut depuis votre tableau de bord.');
    }

    
    public function byCategory(Category $category)
    {
        $jobOffers = JobOffer::byCategory($category->id)
            ->with(['company', 'category', 'location'])
            ->latest()
            ->paginate(10);

        $locations = Location::all();
        $categories = Category::all();

        return view('jobs.index', compact('jobOffers', 'locations', 'categories', 'category'));
    }

    public function search(Request $request)
    {
        $query = JobOffer::with(['company', 'category', 'location']);

        if ($request->filled('query')) {
            $query->search($request->input('query'));
        }

        if ($request->filled('location')) {
            $query->byLocation($request->input('location'));
        }

        if ($request->filled('category')) {
            $query->byCategory($request->input('category'));
        }

        if ($request->filled('employment_type')) {
            $query->byEmploymentType($request->input('employment_type'));
        }

        $jobOffers = $query->latest()->paginate(10);
        $locations = Location::all();
        $categories = Category::all();

        return view('jobs.index', compact('jobOffers', 'locations', 'categories'));
    }
}