<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
Route::get('/jobs/{job}/apply', [JobController::class, 'apply'])->name('jobs.apply');
Route::post('/jobs/{job}/apply', [JobController::class, 'submitApplication'])->name('jobs.submitApplication');
Route::get('/jobs/category/{category}', [JobController::class, 'byCategory'])->name('jobs.byCategory');
Route::get('/jobs/search', [JobController::class, 'search'])->name('jobs.search');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::post('/newsletter/subscribe', function () {
    return redirect()->route('home')->with('success', 'Subscribed successfully!');
})->name('newsletter.subscribe');

// Authentication Routes
Auth::routes();

// Candidate Routes
Route::middleware(['auth', 'candidate'])->prefix('candidate')->group(function () {
    Route::get('/applications', [CandidateController::class, 'applications'])->name('candidate.applications');
    Route::post('/resume/upload', [CandidateController::class, 'uploadResume'])->name('candidate.uploadResume');
    Route::get('/job-alerts', [CandidateController::class, 'jobAlerts'])->name('candidate.jobAlerts');
    Route::post('/job-alerts', [CandidateController::class, 'saveJobAlerts'])->name('candidate.saveJobAlerts');
});

// Company Routes
Route::middleware(['auth', 'recruiter'])->prefix('company')->group(function () {
    Route::get('/dashboard', [CompanyController::class, 'dashboard'])->name('company.dashboard');
    Route::get('/jobs', [CompanyController::class, 'jobs'])->name('company.jobs');
    Route::get('/jobs/create', [CompanyController::class, 'createJob'])->name('company.jobs.create');
    Route::post('/jobs', [CompanyController::class, 'storeJob'])->name('company.jobs.store');
    Route::get('/jobs/{job}/edit', [CompanyController::class, 'editJob'])->name('company.jobs.edit');
    Route::put('/jobs/{job}', [CompanyController::class, 'updateJob'])->name('company.jobs.update');
    Route::delete('/jobs/{job}', [CompanyController::class, 'destroyJob'])->name('company.jobs.destroy');
    Route::get('/jobs/{job}/applications', [CompanyController::class, 'viewApplications'])->name('company.jobs.applications');
    Route::get('/interviews', [CompanyController::class, 'interviews'])->name('company.interviews');
    Route::post('/interviews', [CompanyController::class, 'scheduleInterview'])->name('company.scheduleInterview');
});

// Profile and Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/candidate', [ProfileController::class, 'updateCandidate'])->name('profile.updateCandidate');
    Route::put('/profile/company', [ProfileController::class, 'updateCompany'])->name('profile.updateCompany');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/applications/{application}', [DashboardController::class, 'updateApplicationStatus'])->name('applications.updateStatus');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/recruiters/pending', [AdminController::class, 'pendingRecruiters'])->name('admin.recruiters.pending');
    Route::patch('/recruiters/{user}/approve', [AdminController::class, 'approveRecruiter'])->name('admin.recruiters.approve');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/jobs', [AdminController::class, 'jobs'])->name('admin.jobs');
    Route::delete('/jobs/{job}', [AdminController::class, 'destroyJob'])->name('admin.jobs.destroy');
});