<footer class="bg-gray-100 pt-12 pb-6 mt-auto">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <h3 class="font-bold mb-4">JobNow</h3>
                <p class="text-gray-500 text-sm">
                    Connecting talent with opportunity since {{ date('Y') }}.
                </p>
            </div>
            
            <div>
                <h3 class="font-bold mb-4">About</h3>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li><a href="{{ route('about') }}" class="hover:text-emerald-500">Who We Are</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-emerald-500">Contact</a></li>
                    <li><a href="{{ route('jobs.index') }}" class="hover:text-emerald-500">All Jobs</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="font-bold mb-4">For Candidates</h3>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li><a href="{{ route('jobs.index') }}" class="hover:text-emerald-500">Find a Job</a></li>
                    <li><a href="{{ route('register.candidate') }}" class="hover:text-emerald-500">Create an Account</a></li>
                    @auth
                        @if(auth()->user()->isCandidate())
                            <li><a href="{{ route('candidate.applications') }}" class="hover:text-emerald-500">My Applications</a></li>
                        @endif
                    @endauth
                </ul>
            </div>
            
            <div>
                <h3 class="font-bold mb-4">For Recruiters</h3>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li><a href="{{ route('register.recruiter') }}" class="hover:text-emerald-500">Post a Job</a></li>
                    @auth
                        @if(auth()->user()->isRecruiter())
                            <li><a href="{{ route('recruiter.jobs') }}" class="hover:text-emerald-500">Manage My Jobs</a></li>
                        @endif
                    @endauth
                    <li><a href="{{ route('contact') }}" class="hover:text-emerald-500">Contact Us</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t pt-6 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-500 text-sm">© {{ date('Y') }} JobNow. All rights reserved.</p>
        </div>
    </div>
</footer>