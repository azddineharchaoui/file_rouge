<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;

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

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');

Route::post('/contact', function() {
    session()->flash('success', 'Votre message a été envoyé avec succès!');
    return redirect()->back();
})->name('contact.send');

Route::post('/newsletter/subscribe', function () {
    return redirect()->route('home')->with('success', 'Subscribed successfully!');
})->name('newsletter.subscribe');

// Authentication Routes
Auth::routes();


// Custom Registration Routes
Route::get('/register/candidate', [RegisterController::class, 'showCandidateRegistrationForm'])
    ->name('register.candidate');
Route::get('/register/recruiter', [RegisterController::class, 'showRecruiterRegistrationForm'])
    ->name('register.recruiter');
Route::post('/register/candidate', [RegisterController::class, 'registerCandidate']);
Route::post('/register/recruiter', [RegisterController::class, 'registerRecruiter']);


// Candidate Routes
Route::middleware(['auth', 'candidate'])->prefix('candidate')->group(function () {
    Route::get('/dashboard', [CandidateController::class, 'dashboard'])->name('candidate.dashboard');
    Route::get('/applications', [CandidateController::class, 'applications'])->name('candidate.applications');
    Route::post('/resume/upload', [CandidateController::class, 'uploadResume'])->name('candidate.uploadResume');
    
    // Job Alert System
    Route::get('/job-alerts', [CandidateController::class, 'jobAlerts'])->name('candidate.jobAlerts');
    Route::post('/job-alerts', [CandidateController::class, 'saveJobAlerts'])->name('candidate.saveJobAlerts');
    Route::delete('/job-alerts/{alert}', [CandidateController::class, 'deleteJobAlert'])->name('candidate.deleteJobAlert');
    
    // Calendar and interviews
    Route::get('/interviews', [CandidateController::class, 'interviews'])->name('candidate.interviews');
    Route::post('/interviews/{interview}/confirm', [CandidateController::class, 'confirmInterview'])->name('candidate.confirmInterview');
    Route::post('/interviews/{interview}/reschedule', [CandidateController::class, 'requestReschedule'])->name('candidate.requestReschedule');
});

// Company Routes
Route::middleware(['auth', 'recruiter'])->prefix('recruiter')->group(function () {
    Route::get('/dashboard', [CompanyController::class, 'dashboard'])->name('recruiter.dashboard');
    Route::get('/jobs', [CompanyController::class, 'jobs'])->name('recruiter.jobs');
    Route::get('/jobs/create', [CompanyController::class, 'createJob'])->name('recruiter.jobs.create');
    Route::post('/jobs', [CompanyController::class, 'storeJob'])->name('recruiter.jobs.store');
    Route::get('/jobs/{job}/edit', [CompanyController::class, 'editJob'])->name('recruiter.jobs.edit');
    Route::put('/jobs/{job}', [CompanyController::class, 'updateJob'])->name('recruiter.jobs.update');
    Route::delete('/jobs/{job}', [CompanyController::class, 'destroyJob'])->name('recruiter.jobs.destroy');
    Route::get('/jobs/{job}/applications', [CompanyController::class, 'viewApplications'])->name('recruiter.jobs.applications');
    
    // Analytics
    Route::get('/statistics', [CompanyController::class, 'statistics'])->name('recruiter.statistics');
    
    // Interview Scheduling 
    Route::get('/interviews', [CompanyController::class, 'interviews'])->name('recruiter.interviews');
    Route::post('/interviews', [CompanyController::class, 'scheduleInterview'])->name('recruiter.scheduleInterview');
    Route::put('/interviews/{interview}', [CompanyController::class, 'updateInterview'])->name('recruiter.updateInterview');
});

// Profile and Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    
    Route::get('/profile/candidate', [ProfileController::class, 'show'])->name('profile.candidate');
    Route::put('/profile/candidate', [ProfileController::class, 'updateCandidate'])->name('profile.updateCandidate');
    
    Route::get('/profile/company', [ProfileController::class, 'show'])->name('profile.company');
    Route::put('/profile/company', [ProfileController::class, 'updateCompany'])->name('profile.updateCompany');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'candidate') {
            return redirect()->route('candidate.dashboard');
        } elseif ($user->role === 'recruiter') {
            return redirect()->route('recruiter.dashboard');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');
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