<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JobNow - Parcourir les offres d'emploi</title>
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
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Parcourir les offres d'emploi</h1>
                <p class="text-gray-600">Trouvez l'emploi qui correspond à vos compétences et à vos aspirations</p>
            </div>
            
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar -->
                <aside class="w-full lg:w-1/4">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                        <form action="{{ route('jobs.search') }}" method="GET">
                            <!-- Search by Title -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Recherche par titre</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input 
                                        type="text" 
                                        name="query"
                                        placeholder="Titre du poste ou entreprise" 
                                        class="w-full pl-10 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        value="{{ request('query') }}"
                                    >
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Lieu</label>
                                <select name="location" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-gray-700">
                                    <option value="">Choisir une ville</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>
                                            {{ $location->city }}, {{ $location->country }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Category -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                                <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                                    @foreach($categories as $category)
                                        <div class="flex items-center">
                                            <input 
                                                type="checkbox" 
                                                id="category-{{ $category->id }}"
                                                name="category[]" 
                                                value="{{ $category->id }}" 
                                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded" 
                                                {{ in_array($category->id, (array) request('category')) ? 'checked' : '' }}
                                            >
                                            <label for="category-{{ $category->id }}" class="ml-2 text-sm text-gray-700">
                                                {{ $category->name }} <span class="text-gray-500">({{ $category->jobOffers->count() }})</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Job Type -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Type d'emploi</label>
                                <div class="space-y-2">
                                    @foreach(['Full Time', 'Part Time', 'Freelance', 'Seasonal', 'Fixed-Price'] as $type)
                                        <div class="flex items-center">
                                            <input 
                                                type="checkbox" 
                                                id="type-{{ $type }}"
                                                name="employment_type[]" 
                                                value="{{ $type }}" 
                                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded" 
                                                {{ in_array($type, (array) request('employment_type')) ? 'checked' : '' }}
                                            >
                                            <label for="type-{{ $type }}" class="ml-2 text-sm text-gray-700">{{ $type }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Remote Only -->
                            <div class="mb-6">
                                <div class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        id="remote"
                                        name="is_remote" 
                                        value="1" 
                                        class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded" 
                                        {{ request('is_remote') ? 'checked' : '' }}
                                    >
                                    <label for="remote" class="ml-2 text-sm text-gray-700">Télétravail uniquement</label>
                                </div>
                            </div>

                            <!-- Salary Range -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fourchette de salaire</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <input 
                                            type="number" 
                                            name="min_salary"
                                            placeholder="Min" 
                                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                            value="{{ request('min_salary') }}"
                                        >
                                    </div>
                                    <div>
                                        <input 
                                            type="number" 
                                            name="max_salary"
                                            placeholder="Max" 
                                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                            value="{{ request('max_salary') }}"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Apply Button -->
                            <button type="submit" class="w-full bg-emerald-500 text-white px-4 py-3 rounded-md font-medium hover:bg-emerald-600 transition flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                                Filtrer les résultats
                            </button>
                        </form>
                    </div>
                </aside>

                <!-- Job Listings -->
                <div class="w-full lg:w-3/4">
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <p class="text-gray-600">
                                Affichage de <span class="font-medium">{{ $jobOffers->firstItem() ?? 0 }}</span> à 
                                <span class="font-medium">{{ $jobOffers->lastItem() ?? 0 }}</span> sur 
                                <span class="font-medium">{{ $jobOffers->total() }}</span> offres d'emploi
                            </p>
                            <div class="flex items-center gap-2">
                                <label class="text-sm text-gray-700">Trier par</label>
                                <select class="border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option>Plus récent</option>
                                    <option>Salaire (Haut à Bas)</option>
                                    <option>Salaire (Bas à Haut)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @forelse($jobOffers as $job)
                            <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow border-l-4 border-emerald-500">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                    <div class="flex gap-4">
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                            @if($job->company && $job->company->logo)
                                                <img src="{{ $job->company->logo }}" alt="{{ $job->company->company_name }}" class="w-12 h-12 object-contain">
                                            @else
                                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 font-bold text-xl">
                                                    {{ substr($job->company->company_name ?? 'J', 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-xl text-gray-800">{{ $job->title }}</h3>
                                            <p class="text-gray-600">{{ $job->company->company_name ?? 'Entreprise' }}</p>
                                            <div class="flex flex-wrap gap-4 mt-3">
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-3 ml-auto">
                                        <span class="text-sm text-emerald-500 whitespace-nowrap">{{ $job->created_at->diffForHumans() }}</span>
                                        <a href="{{ route('jobs.show', $job->id) }}" class="bg-emerald-500 text-white px-5 py-2 rounded-md text-sm font-medium hover:bg-emerald-600 transition whitespace-nowrap text-center">Voir détails</a>
                                        <a href="{{ route('jobs.apply', $job->id) }}" class="border border-emerald-500 text-emerald-500 px-5 py-2 rounded-md text-sm font-medium hover:bg-emerald-50 transition whitespace-nowrap text-center">Postuler</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-xl font-bold text-gray-700 mb-2">Aucune offre d'emploi trouvée</h3>
                                <p class="text-gray-500 mb-6">Aucune offre d'emploi ne correspond à vos critères de recherche.</p>
                                <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 bg-emerald-500 text-white px-5 py-2 rounded-md font-medium hover:bg-emerald-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                    </svg>
                                    Réinitialiser les filtres
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $jobOffers->links() }}
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
                <div class="flex gap-6 text-sm mt️ {{ date('Y') }} JobNow. Tous droits réservés.</p>
                <div class="flex gap-6 text-sm mt-4 md:mt-0">
                    <a href="{{ route('privacy') }}" class="text-gray-500 hover:text-emerald-500 transition">Politique de confidentialité</a>
                    <a href="{{ route('terms') }}" class="text-gray-500 hover:text-emerald-500 transition">Conditions d'utilisation</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>