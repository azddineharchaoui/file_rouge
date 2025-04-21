<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Publier une offre d'emploi - JobNow</title>
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
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Publier une offre</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Publier une nouvelle offre d'emploi</h1>
                
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

                <form action="{{ route('jobs.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre du poste <span class="text-red-500">*</span></label>
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
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Catégorie <span class="text-red-500">*</span></label>
                            <select 
                                id="category_id"
                                name="category_id" 
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required
                            >
                                <option value="">Sélectionner une catégorie</option>
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
                            <label for="location_id" class="block text-sm font-medium text-gray-700 mb-1">Lieu <span class="text-red-500">*</span></label>
                            <select 
                                id="location_id"
                                name="location_id" 
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required
                            >
                                <option value="">Sélectionner un lieu</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->city }}, {{ $location->country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="employment_type" class="block text-sm font-medium text-gray-700 mb-1">Type d'emploi <span class="text-red-500">*</span></label>
                            <select 
                                id="employment_type"
                                name="employment_type" 
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required
                            >
                                <option value="">Sélectionner un type</option>
                                <option value="Full Time" {{ old('employment_type') == 'Full Time' ? 'selected' : '' }}>Temps plein</option>
                                <option value="Part Time" {{ old('employment_type') == 'Part Time' ? 'selected' : '' }}>Temps partiel</option>
                                <option value="Freelance" {{ old('employment_type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                <option value="Seasonal" {{ old('employment_type') == 'Seasonal' ? 'selected' : '' }}>Saisonnier</option>
                                <option value="Fixed-Price" {{ old('employment_type') == 'Fixed-Price' ? 'selected' : '' }}>Prix fixe</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">Salaire (€) <span class="text-red-500">*</span></label>
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
                            <label for="experience_level" class="block text-sm font-medium text-gray-700 mb-1">Niveau d'expérience <span class="text-red-500">*</span></label>
                            <select 
                                id="experience_level"
                                name="experience_level" 
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required
                            >
                                <option value="">Sélectionner un niveau</option>
                                <option value="Entry Level" {{ old('experience_level') == 'Entry Level' ? 'selected' : '' }}>Débutant</option>
                                <option value="Mid Level" {{ old('experience_level') == 'Mid Level' ? 'selected' : '' }}>Intermédiaire</option>
                                <option value="Senior Level" {{ old('experience_level') == 'Senior Level' ? 'selected' : '' }}>Confirmé</option>
                                <option value="Manager" {{ old('experience_level') == 'Manager' ? 'selected' : '' }}>Manager</option>
                                <option value="Executive" {{ old('experience_level') == 'Executive' ? 'selected' : '' }}>Cadre supérieur</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="application_deadline" class="block text-sm font-medium text-gray-700 mb-1">Date limite de candidature <span class="text-red-500">*</span></label>
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
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description du poste <span class="text-red-500">*</span></label>
                        <textarea 
                            id="description"
                            name="description" 
                            rows="6"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required
                        >{{ old('description') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Décrivez le poste, l'entreprise et le contexte de travail</p>
                    </div>
                    
                    <div class="mb-6">
                        <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">Exigences <span class="text-red-500">*</span></label>
                        <textarea 
                            id="requirements"
                            name="requirements" 
                            rows="6"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required
                        >{{ old('requirements') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Listez les compétences, qualifications et expériences requises</p>
                    </div>
                    
                    <div class="mb-6">
                        <label for="responsibilities" class="block text-sm font-medium text-gray-700 mb-1">Responsabilités <span class="text-red-500">*</span></label>
                        <textarea 
                            id="responsibilities"
                            name="responsibilities" 
                            rows="6"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required
                        >{{ old('responsibilities') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Décrivez les tâches et responsabilités principales du poste</p>
                    </div>
                    
                    <div class="mb-6">
                        <label for="benefits" class="block text-sm font-medium text-gray-700 mb-1">Avantages</label>
                        <textarea 
                            id="benefits"
                            name="benefits" 
                            rows="6"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >{{ old('benefits') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Listez les avantages offerts (optionnel)</p>
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
                            Ce poste peut être effectué en télétravail
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
                            Mettre cette offre en avant (des frais supplémentaires peuvent s'appliquer)
                        </label>
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="{{ route('jobs.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-md font-medium hover:bg-gray-300 transition mr-4">
                            Annuler
                        </a>
                        <button type="submit" class="bg-emerald-500 text-white px-6 py-3 rounded-md font-medium hover:bg-emerald-600 transition">
                            Publier l'offre
                        </button>
                    </div>
                </form>
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