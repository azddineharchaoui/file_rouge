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
    public function index(Request $request)
    {
        $query = JobOffer::with(['company', 'category', 'location']);
        
        // Apply all filters to the query
        $query = $this->applyFilters($query, $request);
        
        $jobOffers = $query->paginate(10)->appends($request->all());
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
        $user = Auth::user();
        
        if (!$user->isCandidate()) {
            return redirect()->route('jobs.show', $job->id)
                ->with('error', 'Seuls les candidats peuvent postuler aux offres.');
        }
        
        $candidateProfile = $user->candidateProfile;
        
        if (!$candidateProfile) {
            return redirect()->route('jobs.show', $job->id)
                ->with('error', 'Vous devez compléter votre profil avant de pouvoir postuler.');
        }
        
        $existingApplication = Application::where('job_offer_id', $job->id)
            ->where('candidate_profile_id', $candidateProfile->id)
            ->first();
        
        if ($existingApplication) {
            return redirect()->route('jobs.show', $job->id)
                ->with('error', 'Vous avez déjà postulé à cette offre.');
        }
        
        
        // $this->authorize('apply', $job);
        
        // Vérifier si le candidat a un CV
        if (!$candidateProfile->cv_path) {
            return redirect()->route('jobs.show', $job->id)
                ->with('error', 'Vous devez télécharger un CV dans votre profil avant de pouvoir postuler.');
        }
        
        // Créer la candidature
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
        
        // Apply all filters to the query
        $query = $this->applyFilters($query, $request);
        
        $jobOffers = $query->paginate(10)->appends($request->all());
        $locations = Location::all();
        $categories = Category::all();
        
        return view('jobs.index', compact('jobOffers', 'locations', 'categories'));
    }

    /**
     * Apply all filters to the job query
     */
    private function applyFilters($query, $request)
    {
        // Filter by keyword or query
        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        } elseif ($request->filled('query')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->query('query') . '%')
                  ->orWhere('description', 'like', '%' . $request->query('query') . '%');
            });
        }
        
        // Filter by location
        if ($request->filled('location')) {
            $query->byLocation($request->location);
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        
        // Filter by employment types (multiple selection)
        if ($request->filled('employment_types')) {
            $query->whereIn('employment_type', $request->employment_types);
        }
        
        // Filter by minimum salary
        if ($request->filled('salary_min')) {
            $query->where('salary', '>=', $request->salary_min);
        }
        
        // Filter by posting date
        if ($request->filled('posted_within')) {
            $daysAgo = $request->posted_within;
            $query->where('created_at', '>=', now()->subDays($daysAgo));
        }
        
        // Sort results
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'salary_desc':
                    $query->orderBy('salary', 'desc');
                    break;
                case 'salary_asc':
                    $query->orderBy('salary', 'asc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }
        
        return $query;
    }
}