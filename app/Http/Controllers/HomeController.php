<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\JobOffer;
use App\Models\Location;
use App\Models\Application;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $jobOffers = JobOffer::with(['company', 'category', 'location'])
            ->latest()
            ->paginate(5);
        
        $locations = Location::all();
        $categories = Category::all();
        
        // Real statistics
        $stats = [
            'jobs' => JobOffer::count(),
            'companies' => User::where('role', 'recruiter')->where('is_approved', true)->count(),
            'candidates' => User::where('role', 'candidate')->count(),
        ];

        return view('welcome', compact('jobOffers', 'locations', 'categories', 'stats'));
    }
}
