<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Postuler - {{ $job->title }} - JobNow</title>
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
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Postuler</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Application Form -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h1 class="text-2xl font-bold text-gray-800 mb-6">Postuler pour: {{ $job->title }}</h1>
                        
                        @if ($errors->any())
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                                <div class="font-bold">Veuillez corriger les erreurs suivantes:</div>
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
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Prénom <span class="text-red-500">*</span></label>
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
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
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
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone <span class="text-red-500">*</span></label>
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
                                <label for="resume" class="block text-sm font-medium text-gray-700 mb-1">CV (PDF, DOC, DOCX) <span class="text-red-500">*</span></label>
                                <input 
                                    type="file" 
                                    id="resume"
                                    name="resume" 
                                    accept=".pdf,.doc,.docx"
                                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                    required
                                >
                                <p class="text-sm text-gray-500 mt-1">Taille maximale: 5 MB</p>
                            </div>
                            
                            <div class="mb-6">
                                <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-1">Lettre de motivation</label>
                                <textarea 
                                    id="cover_letter"
                                    name="cover_letter" 
                                    rows="6"
                                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                >{{ old('cover_letter') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Expliquez pourquoi vous êtes le candidat idéal pour ce poste</p>
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
                                    J'accepte les <a href="{{ route('terms') }}" class="text-emerald-500 hover:underline">conditions d'utilisation</a> et la <a href="{{ route('privacy') }}" class="text-emerald-500 hover:underline">politique de confidentialité</a>
                                </label>
                            </div>
                            
                            <div class="flex justify-end">
                                <a href="{{ route('jobs.show', $job->id) }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-md font-medium hover:bg-gray-300 transition mr-4">
                                    Annuler
                                </a>
                                <button type="submit" class="bg-emerald-500 text-white px-6 py-3 rounded-md font-medium hover:bg-emerald-600 transition">
                                    Soumettre ma candidature
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="w-full lg:w-1/3">
                    <!-- Job Summary -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Résumé du poste</h2>
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
                                <p class="text-gray-600">{{ $job->company->company_name ?? 'Entreprise' }}</p>
                            </div>
                        </div>
                        
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $job->category->name ?? 'Catégorie' }}</span>
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
                  />
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
                                <span>Date limite: {{ $job->application_deadline->format('d/m/Y') }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Tips -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Conseils pour postuler</h2>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="text-emerald-600 font-bold text-sm">1</span>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Personnalisez votre CV</h3>
                                    <p class="text-gray-600 text-sm">Adaptez votre CV pour mettre en avant les compétences pertinentes pour ce poste.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="text-emerald-600 font-bold text-sm">2</span>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Rédigez une lettre de motivation convaincante</h3>
                                    <p class="text-gray-600 text-sm">Expliquez pourquoi vous êtes intéressé par ce poste et cette entreprise en particulier.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="text-emerald-600 font-bold text-sm">3</span>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Vérifiez vos documents</h3>
                                    <p class="text-gray-600 text-sm">Assurez-vous que votre CV et votre lettre de motivation ne contiennent pas de fautes d'orthographe.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="text-emerald-600 font-bold text-sm">4</span>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Préparez-vous pour l'entretien</h3>
                                    <p class="text-gray-600 text-sm">Renseignez-vous sur l'entreprise et préparez des questions pertinentes à poser.</p>
                                </div>
                            </li>
                        </ul>
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