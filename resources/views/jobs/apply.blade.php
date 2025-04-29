<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apply - {{ $job->title }} - JobNow</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen">
    <!-- Navigation Bar -->
    <header class="bg-emerald-900 text-white p-4">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="bg-white rounded p-1">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 7H4V19H20V7Z" fill="black" />
                        <path d="M15 3H9V7H15V3Z" fill="black" />
                    </svg>
                </div>
                <span class="font-bold text-xl">JobNow</span>
            </div>
            
            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-white hover:text-emerald-200">Home</a>
                <a href="{{ route('jobs.index') }}" class="text-white hover:text-emerald-200">Jobs</a>
                <a href="{{ route('about') }}" class="text-white hover:text-emerald-200">About</a>
                <a href="{{ route('contact') }}" class="text-white hover:text-emerald-200">Contact</a>
            </nav>
            
            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}" class="text-white hover:text-emerald-200">Login</a>
                    <a href="{{ route('register') }}" class="bg-emerald-500 text-white px-4 py-2 rounded-md text-sm hover:bg-emerald-600 transition">Register</a>
                @else
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-white">
                            <img src="{{ auth()->user()->profile_photo_url ?? '/placeholder.svg?height=32&width=32' }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full border">
                            <span>{{ auth()->user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block z-10">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50">Profile</a>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <main class="flex-1 bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <!-- Breadcrumbs -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <a href="{{ route('jobs.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-emerald-500 md:ml-2">Jobs</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <a href="{{ route('jobs.show', $job->id) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-emerald-500 md:ml-2">{{ $job->title }}</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Apply</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Application Form -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h1 class="text-2xl font-bold text-gray-800 mb-6">Apply for: {{ $job->title }}</h1>
                        
                        @if ($errors->any())
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                                <div class="font-bold">Please correct the following errors:</div>
                                <ul class="list-disc ml-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('jobs.submitApplication', $job->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                                    <input 
                                        type="text" 
                                        id="first_name"
                                        name="first_name" 
                                        value="{{ old('first_name', auth()->user()->candidateProfile->first_name ?? '') }}"
                                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        required
                                    >
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                                    <input 
                                        type="text" 
                                        id="last_name"
                                        name="last_name" 
                                        value="{{ old('last_name', auth()->user()->candidateProfile->last_name ?? '') }}"
                                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        required
                                    >
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                                    <input 
                                        type="email" 
                                        id="email"
                                        name="email" 
                                        value="{{ old('email', auth()->user()->email ?? '') }}"
                                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        required
                                    >
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label>
                                    <input 
                                        type="tel" 
                                        id="phone"
                                        name="phone" 
                                        value="{{ old('phone', auth()->user()->candidateProfile->phone ?? '') }}"
                                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        required
                                    >
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label for="resume" class="block text-sm font-medium text-gray-700 mb-1">Resume (PDF, DOC, DOCX) <span class="text-red-500">*</span></label>
                                <input 
                                    type="file" 
                                    id="resume"
                                    name="resume" 
                                    accept=".pdf,.doc,.docx"
                                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                    required
                                >
                                <p class="text-sm text-gray-500 mt-1">Maximum size: 5MB</p>
                            </div>
                            
                            <div class="mb-6">
                                <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-1">Cover Letter</label>
                                <textarea 
                                    id="cover_letter"
                                    name="cover_letter" 
                                    rows="6"
                                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                >{{ old('cover_letter') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Explain why you're the ideal candidate for this position</p>
                            </div>
                            
                            <div class="flex items-center mb-6">
                                <input 
                                    type="checkbox" 
                                    id="terms"
                                    name="terms" 
                                    class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                                    required
                                >
                                <label for="terms" class="ml-2 block text-sm text-gray-700">
                                    I accept the <a href="{{ route('terms') }}" class="text-emerald-500 hover:underline">terms of service</a> and <a href="{{ route('privacy') }}" class="text-emerald-500 hover:underline">privacy policy</a>
                                </label>
                            </div>
                            
                            <div class="flex justify-end">
                                <a href="{{ route('jobs.show', $job->id) }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-md font-medium hover:bg-gray-300 transition mr-4">
                                    Cancel
                                </a>
                                <button type="submit" class="bg-emerald-500 text-white px-6 py-3 rounded-md font-medium hover:bg-emerald-600 transition">
                                    Submit Application
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="w-full lg:w-1/3">
                    <!-- Job Summary -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Job Summary</h2>
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                @if($job->company && $job->company->logo)
                                    <img src="{{ $job->company->logo }}" alt="{{ $job->company->company_name }}" class="w-8 h-8 object-contain">
                                @else
                                    <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 font-bold text-lg">
                                        {{ substr($job->company->company_name ?? 'J', 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">{{ $job->title }}</h3>
                                <p class="text-gray-600">{{ $job->company->company_name ?? 'Company' }}</p>
                            </div>
                        </div>
                        
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $job->category->name ?? 'Category' }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $job->location->city ?? '' }}, {{ $job->location->country ?? '' }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $job->employment_type }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ number_format($job->salary) }} €</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Deadline: {{ $job->application_deadline->format('d/m/Y') }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Tips -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Application Tips</h2>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="text-emerald-600 font-bold text-sm">1</span>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Customize your resume</h3>
                                    <p class="text-gray-600 text-sm">Tailor your resume to highlight skills relevant to this position.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="text-emerald-600 font-bold text-sm">2</span>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Write a compelling cover letter</h3>
                                    <p class="text-gray-600 text-sm">Explain why you're interested in this position and company specifically.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="text-emerald-600 font-bold text-sm">3</span>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Check your documents</h3>
                                    <p class="text-gray-600 text-sm">Make sure your resume and cover letter are free of spelling errors.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="text-emerald-600 font-bold text-sm">4</span>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Prepare for the interview</h3>
                                    <p class="text-gray-600 text-sm">Research the company and prepare relevant questions to ask.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <x-footer />
    
</body>
</html>