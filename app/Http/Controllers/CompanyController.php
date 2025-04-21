<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function dashboard()
    {
        $company = Auth::user()->company;
        $jobs = $company->jobs()->withCount('applications')->get();
        $recentApplications = Application::whereIn('job_id', $jobs->pluck('id'))
            ->with(['job', 'user'])
            ->latest()
            ->take(5)
            ->get();
            
        return view('company.dashboard', compact('company', 'jobs', 'recentApplications'));
    }
    
    public function jobs()
    {
        $jobs = Auth::user()->company->jobs()->withCount('applications')->latest()->paginate(10);
        return view('company.jobs.index', compact('jobs'));
    }
    
    public function createJob()
    {
        return view('company.jobs.create');
    }
    
    public function storeJob(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|string',
            'salary_range' => 'nullable|string',
            'requirements' => 'required',
            'closing_date' => 'required|date|after:today',
        ]);
        
        Auth::user()->company->jobs()->create($request->all());
        
        return redirect()->route('company.jobs')->with('success', 'Job created successfully!');
    }
    
    public function viewApplications($jobId)
    {
        $job = Job::findOrFail($jobId);
        $applications = $job->applications()->with('user')->paginate(15);
        
        return view('company.applications', compact('job', 'applications'));
    }
}