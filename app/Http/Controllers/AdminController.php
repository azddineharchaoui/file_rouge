<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobOffer;
use App\Models\Application;
use App\Models\CandidateProfile;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalCandidates' => User::where('role', 'candidate')->count(),
            'totalRecruiters' => User::where('role', 'recruiter')->count(),
            'totalJobOffers' => JobOffer::count(),
            'totalApplications' => Application::count(),
            'pendingRecruiters' => User::where('role', 'recruiter')->where('is_approved', false)->count(),
        ];

        $pendingRecruiters = User::where('role', 'recruiter')
            ->where('is_approved', false)
            ->with('companyProfile')
            ->latest()
            ->take(5)
            ->get();

        $recentJobs = JobOffer::with('company')
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()
            ->take(5)
            ->get();
            
        $userRegistrations = User::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $jobApplications = Application::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'pendingRecruiters', 
            'recentJobs', 
            'recentUsers',
            'userRegistrations',
            'jobApplications'
        ));
    }

    public function pendingRecruiters()
    {
        $recruiters = User::where('role', 'recruiter')
            ->where('is_approved', false)
            ->with('companyProfile')
            ->get();

        return view('admin.recruiters.pending', compact('recruiters'));
    }

    public function approveRecruiter(User $user)
    {
        if ($user->role !== 'recruiter') {
            return redirect()->back()->with('error', 'Cet utilisateur n\'est pas un recruteur.');
        }

        $user->update(['is_approved' => true]);



        return redirect()->route('admin.recruiters.pending')->with('success', 'Compte recruteur approuvé avec succès.');
    }
    
    public function rejectRecruiter(User $user)
    {
        if ($user->role !== 'recruiter') {
            return redirect()->back()->with('error', 'Cet utilisateur n\'est pas un recruteur.');
        }

        if ($user->companyProfile) {
            $user->companyProfile->delete();
        }
        $user->delete();

        return redirect()->route('admin.recruiters.pending')->with('success', 'Compte recruteur rejeté et supprimé avec succès.');
    }
    
    public function jobOffers()
    {
        $jobOffers = JobOffer::with(['company', 'applications'])
            ->latest()
            ->paginate(15);
            
        return view('admin.jobs.index', compact('jobOffers'));
    }
    
    public function deleteJobOffer(JobOffer $jobOffer)
    {

        $jobOffer->applications()->delete();
        

        $jobOffer->delete();
        
        return redirect()->route('admin.jobs')->with('success', 'Offre d\'emploi supprimée avec succès.');
    }
    
    public function users(Request $request)
    {
        $query = User::query();
        
        // Appliquer les filtres
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('is_approved', $request->status === 'active');
        }
        
        $users = $query->latest()->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }
    
    public function toggleUserStatus(User $user)
    {
        $newStatus = !$user->is_active;
        $user->update(['is_active' => $newStatus]);
        
        if (!$newStatus) {
            $user->update(['remember_token' => null]);
            
            DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();
        }
        
        $status = $newStatus ? 'activé' : 'désactivé';
        return redirect()->route('admin.users')->with('success', "Compte utilisateur $status avec succès." . 
            (!$newStatus ? " L'utilisateur a été déconnecté." : ""));
    }
}