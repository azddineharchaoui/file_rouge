<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $job->title }} - JobNow</title>
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
                <a href="{{ route('home') }}" class="text-white hover:text-emerald-200">Accueil</a>
                <a href="{{ route('jobs.index') }}" class="text-white hover:text-emerald-200">Emplois</a>
                <a href="{{ route('about') }}" class="text-white hover:text-emerald-200">À propos</a>
                <a href="{{ route('contact') }}" class="text-white hover:text-emerald-200">Contact</a>
            </nav>
            
            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}" class="text-white hover:text-emerald-200">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-emerald-500 text-white px-4 py-2 rounded-md text-sm hover:bg-emerald-600 transition">S'inscrire</a>
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
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50">Profil</a>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50">Tableau de bord</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50">
                                    Déconnexion
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
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Breadcrumbs -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Accueil
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <a href="{{ route('jobs.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-emerald-500 md:ml-2">Emplois</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $job->title }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Main Content -->
                <div class="w-full lg:w-2/3">
                    <!-- Job Header -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                @if($job->company && $job->company->logo)
                                    <img src="{{ $job->company->logo }}" alt="{{ $job->company->company_name }}" class="w-16 h-16 object-contain">
                                @else
                                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 font-bold text-2xl">
                                        {{ substr($job->company->company_name ?? 'J', 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $job->title }}</h1>
                                <p class="text-gray-600 mb-4">{{ $job->company->company_name ?? 'Entreprise' }}</p>
                                <div class="flex flex-wrap gap-4">
                                    <div class="flex items-center gap-1 text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $job->category->name ?? 'Catégorie' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $job->employment_type }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ number_format($job->salary) }} €</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ $job->location->city ?? '' }}, {{ $job->location->country ?? '' }}</span>
                                    </div>
                                    @if($job->is_remote)
                                        <div class="flex items-center gap-1 text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            <span>Télétravail</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Description du poste</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    <!-- Job Requirements -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Exigences</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    </div>

                    <!-- Job Responsibilities -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Responsabilités</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($job->responsibilities)) !!}
                        </div>
                    </div>

                    <!-- Job Benefits -->
                    @if($job->benefits)
                        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-4">Avantages</h2>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($job->benefits)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Company Info -->
                    @if($job->company)
                        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-4">À propos de l'entreprise</h2>
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                    @if($job->company->logo)
                                        <img src="{{ $job->company->logo }}" alt="{{ $job->company->company_name }}" class="w-16 h-16 object-contain">
                                    @else
                                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 font-bold text-2xl">
                                            {{ substr($job->company->company_name ?? 'J', 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $job->company->company_name }}</h3>
                                    <p class="text-gray-600 mb-4">{{ $job->company->industry }}</p>
                                    <div class="prose max-w-none text-gray-700">
                                        {!! nl2br(e($job->company->description)) !!}
                                    </div>
                                    @if($job->company->website)
                                        <a href="{{ $job->company->website }}" target="_blank" class="inline-flex items-center gap-2 text-emerald-500 hover:text-emerald-600 mt-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                            </svg>
                                            Visiter le site web
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="w-full lg:w-1/3">
                    <!-- Apply Now -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Postuler maintenant</h2>
                        <p class="text-gray-600 mb-4">Date limite de candidature: <span class="font-medium">{{ $job->application_deadline->format('d/m/Y') }}</span></p>
                        <a href="{{ route('jobs.apply', $job->id) }}" class="block w-full bg-emerald-500 text-white text-center px-4 py-3 rounded-md font-medium hover:bg-emerald-600 transition">
                            Postuler maintenant
                        </a>
                        <div class="mt-4 flex justify-center gap-4">
                            <button class="flex items-center gap-2 text-gray-600 hover:text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                Sauvegarder
                            </button>
                            <button class="flex items-center gap-2 text-gray-600 hover:text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                Partager
                            </button>
                        </div>
                    </div>

                    <!-- Job Overview -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Aperçu du poste</h2>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Catégorie</h3>
                                    <p class="text-gray-600">{{ $job->category->name ?? 'Non spécifié' }}</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Lieu</h3>
                                    <p class="text-gray-600">{{ $job->location->city ?? '' }}, {{ $job->location->country ?? 'Non spécifié' }}</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Type d'emploi</h3>
                                    <p class="text-gray-600">{{ $job->employment_type }}</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Salaire</h3>
                                    <p class="text-gray-600">{{ number_format($job->salary) }} € par an</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Date de publication</h3>
                                    <p class="text-gray-600">{{ $job->created_at->format('d/m/Y') }}</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Niveau d'expérience</h3>
                                    <p class="text-gray-600">{{ $job->experience_level }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Similar Jobs -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Emplois similaires</h2>
                        <div class="space-y-4">
                            @forelse($similarJobs as $similarJob)
                                <div class="border-b pb-4 last:border-b-0 last:pb-0">
                                    <h3 class="font-bold text-gray-800 hover:text-emerald-500">
                                        <a href="{{ route('jobs.show', $similarJob->id) }}">{{ $similarJob->title }}</a>
                                    </h3>
                                    <p class="text-gray-600 text-sm">{{ $similarJob->company->company_name ?? 'Entreprise' }}</p>
                                    <div class="flex flex-wrap gap-4 mt-2">
                                        <div class="flex items-center gap-1 text-gray-600 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ $similarJob->location->city ?? '' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1 text-gray-600 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ number_format($similarJob->salary) }} €</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">Aucun emploi similaire trouvé.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 pt-16 pb-6 mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="bg-emerald-500 rounded p-1">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 7H4V19H20V7Z" fill="white" />
                                <path d="M15 3H9V7H15V3Z" fill="white" />
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-gray-800">JobNow</span>
                    </div>
                    <p class="text-gray-600 text-sm">
                        Connecter les talents avec les opportunités depuis {{ date('Y') }}.
                    </p>
                    <div class="flex gap-4 mt-4">
                        <a href="#" class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white hover:bg-emerald-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white hover:bg-emerald-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white hover:bg-emerald-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-4">Entreprise</h3>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li><a href="{{ route('about') }}" class="hover:text-emerald-500 transition">À propos de nous</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-emerald-500 transition">Contact</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition">Carrières</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-4">Catégories d'emploi</h3>
                    <ul class="space-y-3 text-sm text-gray-600">
                        @foreach($footerCategories as $category)
                            <li><a href="{{ route('jobs.byCategory', $category->id) }}" class="hover:text-emerald-500 transition">{{ $category->name }}</a></li>
                        @endforeach
                        <li><a href="{{ route('jobs.index') }}" class="text-emerald-500 font-medium">Voir toutes les catégories</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-4">Newsletter</h3>
                    <p class="text-gray-600 text-sm mb-4">Abonnez-vous à notre newsletter pour recevoir les dernières offres d'emploi</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex">
                        @csrf
                        <input 
                            type="email" 
                            name="email"
                            placeholder="Adresse email" 
                            class="flex-1 p-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            required
                        >
                        <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded-r-md hover:bg-emerald-600 transition">
                            S'abonner
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-t pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm">© {{ date('Y') }} JobNow. Tous droits réservés.</p>
                <div class="flex gap-6 text-sm mt-4 md:mt-0">
                    <a href="{{ route('privacy') }}" class="text-gray-500 hover:text-emerald-500 transition">Politique de confidentialité</a>
                    <a href="{{ route('terms') }}" class="text-gray-500 hover:text-emerald-500 transition">Conditions d'utilisation</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>