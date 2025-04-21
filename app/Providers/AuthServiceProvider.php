<?php

namespace App\Providers;

use App\Models\User;
use App\Models\JobOffer;
use App\Models\Application;
use App\Policies\JobPolicy;
use App\Policies\UserPolicy;
use App\Models\CompanyProfile;
use App\Models\CandidateProfile;
use App\Policies\ApplicationPolicy;
use App\Policies\CompanyProfilePolicy;
use App\Policies\CandidateProfilePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        JobOffer::class => JobPolicy::class,
        Application::class => ApplicationPolicy::class,
        CandidateProfile::class => CandidateProfilePolicy::class,
        CompanyProfile::class => CompanyProfilePolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        //
    }
}