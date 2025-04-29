<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post a Job - JobNow</title>
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
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Post a Job</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Post a New Job</h1>
                
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

                <form action="{{ route('jobs.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Job Title <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                id="title"
                                name="title" 
                                value="{{ old('title') }}"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required
                            >
                        </div>
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                            <select 
                                id="category_id"
                                name="category_id" 
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required
                            >
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="location_id" class="block text-sm font-medium text-gray-700 mb-1">Location <span class="text-red-500">*</span></label>
                            <select 
                                id="location_id"
                                name="location_id" 
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required
                            >
                                <option value="">Select a location</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->city }}, {{ $location->country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="employment_type" class="block text-sm font-medium text-gray-700 mb-1">Employment Type <span class="text-red-500">*</span></label>
                            <select 
                                id="employment_type"
                                name="employment_type" 
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required
                            >
                                <option value="">Select a type</option>
                                <option value="full-time" {{ old('employment_type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part-time" {{ old('employment_type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                                <option value="temporary" {{ old('employment_type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">Salary (€) <span class="text-red-500">*</span></label>
                            <input 
                                type="number" 
                                id="salary"
                                name="salary" 
                                value="{{ old('salary') }}"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required
                            >
                        </div>
                        <div>
                            <label for="experience_level" class="block text-sm font-medium text-gray-700 mb-1">Experience Level <span class="text-red-500">*</span></label>
                            <select 
                                id="experience_level"
                                name="experience_level" 
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required
                            >
                                <option value="">Select a level</option>
                                <option value="Entry Level" {{ old('experience_level') == 'Entry Level' ? 'selected' : '' }}>Entry Level</option>
                                <option value="Mid Level" {{ old('experience_level') == 'Mid Level' ? 'selected' : '' }}>Mid Level</option>
                                <option value="Senior Level" {{ old('experience_level') == 'Senior Level' ? 'selected' : '' }}>Senior Level</option>
                                <option value="Manager" {{ old('experience_level') == 'Manager' ? 'selected' : '' }}>Manager</option>
                                <option value="Executive" {{ old('experience_level') == 'Executive' ? 'selected' : '' }}>Executive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="application_deadline" class="block text-sm font-medium text-gray-700 mb-1">Application Deadline <span class="text-red-500">*</span></label>
                        <input 
                            type="date" 
                            id="application_deadline"
                            name="application_deadline" 
                            value="{{ old('application_deadline') }}"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required
                        >
                    </div>
                    
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Job Description <span class="text-red-500">*</span></label>
                        <textarea 
                            id="description"
                            name="description" 
                            rows="6"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required
                        >{{ old('description') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Describe the job, company, and work context</p>
                    </div>
                    
                    <div class="mb-6">
                        <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">Requirements <span class="text-red-500">*</span></label>
                        <textarea 
                            id="requirements"
                            name="requirements" 
                            rows="6"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required
                        >{{ old('requirements') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">List required skills, qualifications and experience</p>
                    </div>
                    
                    <div class="mb-6">
                        <label for="responsibilities" class="block text-sm font-medium text-gray-700 mb-1">Responsibilities <span class="text-red-500">*</span></label>
                        <textarea 
                            id="responsibilities"
                            name="responsibilities" 
                            rows="6"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required
                        >{{ old('responsibilities') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Describe the main tasks and responsibilities of the job</p>
                    </div>
                    
                    <div class="mb-6">
                        <label for="benefits" class="block text-sm font-medium text-gray-700 mb-1">Benefits</label>
                        <textarea 
                            id="benefits"
                            name="benefits" 
                            rows="6"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >{{ old('benefits') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">List the benefits offered (optional)</p>
                    </div>
                    
                    <div class="flex items-center mb-6">
                        <input 
                            type="checkbox" 
                            id="is_remote"
                            name="is_remote" 
                            value="1"
                            class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                            {{ old('is_remote') ? 'checked' : '' }}
                        >
                        <label for="is_remote" class="ml-2 block text-sm text-gray-700">
                            This position can be performed remotely
                        </label>
                    </div>
                    
                    <div class="flex items-center mb-6">
                        <input 
                            type="checkbox" 
                            id="is_featured"
                            name="is_featured" 
                            value="1"
                            class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                            {{ old('is_featured') ? 'checked' : '' }}
                        >
                        <label for="is_featured" class="ml-2 block text-sm text-gray-700">
                            Feature this job (additional fees may apply)
                        </label>
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="{{ route('jobs.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-md font-medium hover:bg-gray-300 transition mr-4">
                            Cancel
                        </a>
                        <button type="submit" class="bg-emerald-500 text-white px-6 py-3 rounded-md font-medium hover:bg-emerald-600 transition">
                            Post Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <x-footer />
    
</body>
</html>