<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobOffer;
use App\Models\Location;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $jobOffers = JobOffer::with(['company', 'category', 'location'])
            ->latest()
            ->take(5)
            ->get();
        
        $locations = Location::all();
        $categories = Category::all();
        
        $stats = [
            'clients' => 12000,
            'resumes' => 20000,
            'companies' => 18000,
        ];

        $footerCategories = Category::take(5)->get();

        return view('job-search', compact('jobOffers', 'locations', 'categories', 'stats', 'footerCategories'));
    }
}