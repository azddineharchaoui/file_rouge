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

// Job routes
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/search', [JobController::class, 'search'])->name('jobs.search');
Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
Route::post('/jobs/{job}/apply', [JobController::class, 'apply'])->name('jobs.apply')->middleware(['auth', 'verified']);
Route::get('/jobs/category/{category}', [JobController::class, 'byCategory'])->name('jobs.byCategory');

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');


Route::post('/contact', function() {
    session()->flash('success', 'Votre message a été envoyé avec succès!');
    return redirect()->back();
})->name('contact.send');

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
    
    // interviews
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
    Route::put('/applications/{application}/status', [CompanyController::class, 'updateApplicationStatus'])->name('recruiter.application.updateStatus');
    // Analytics
    Route::get('/statistics', [CompanyController::class, 'statistics'])->name('recruiter.statistics');
    
    // Interview Scheduling 
    Route::get('/interviews', [CompanyController::class, 'interviews'])->name('recruiter.interviews');
    Route::put('/interviews/{interview}', [CompanyController::class, 'updateInterview'])->name('recruiter.updateInterview');
    Route::put('/interviews/{interview}/status', [CompanyController::class, 'updateInterviewStatus'])->name('recruiter.interviews.status');
    Route::post('/interviews/schedule', [CompanyController::class, 'scheduleInterview'])->name('recruiter.scheduleInterview');
    
    // Resume Access
    Route::get('/applications/{application}/resume', [CompanyController::class, 'viewResume'])->name('recruiter.view.resume');
    Route::get('/applications/resume-by-user/{userId}', [CompanyController::class, 'viewResumeByUser'])->name('recruiter.view.resume.by.user');
    Route::get('/applications/check-resume/{userId}', [CompanyController::class, 'checkResumeAvailability'])->name('recruiter.check.resume');
    Route::get('/applications/candidate-skills/{userId}', [CompanyController::class, 'getCandidateSkills'])->name('recruiter.getCandidateSkills');
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
// Routes pour l'administration
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestion des recruteurs
    Route::get('/recruiters/pending', [AdminController::class, 'pendingRecruiters'])->name('recruiters.pending');
    Route::post('/recruiters/{user}/approve', [AdminController::class, 'approveRecruiter'])->name('recruiters.approve');
    Route::delete('/recruiters/{user}/reject', [AdminController::class, 'rejectRecruiter'])->name('recruiters.reject');
    
    // Gestion des offres d'emploi
    Route::get('/jobs', [AdminController::class, 'jobOffers'])->name('jobs');
    Route::delete('/jobs/{jobOffer}', [AdminController::class, 'deleteJobOffer'])->name('jobs.delete');
    
    // Gestion des utilisateurs
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
});