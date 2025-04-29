<footer class="bg-gray-100 pt-12 pb-6 mt-auto">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <h3 class="font-bold mb-4">JobNow</h3>
                <p class="text-gray-500 text-sm">
                    Connecting talent with opportunity since {{ date('Y') }}.
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-400 hover:text-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                        </svg>
                    </a>
                </div>
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