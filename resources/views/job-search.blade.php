<x-app-layout>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-emerald-900 to-emerald-700 text-white py-16">
        <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('/images/hero-bg.jpg')"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Trouvez votre emploi de rêve aujourd'hui!</h1>
                <p class="text-lg">Connecter les talents avec les opportunités: Votre passerelle vers le succès professionnel</p>
            </div>
            
            <form action="{{ route('jobs.search') }}" method="GET" class="bg-white rounded-lg p-4 flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="query"
                        placeholder="Titre du poste ou entreprise" 
                        class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-800"
                    >
                </div>
                <div class="flex-1">
                    <select name="location" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-800">
                        <option value="">Sélectionner un lieu</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <select name="category" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-500">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-emerald-500 text-white px-6 py-3 rounded-md flex items-center gap-2 hover:bg-emerald-600 transition w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        <span>Rechercher</span>
                    </button>
                </div>
            </form>
            
            @guest
                <div class="flex flex-col md:flex-row justify-center gap-4 mt-6">
                    <a href="{{ route('register.candidate') }}" class="bg-white text-emerald-600 font-bold px-6 py-3 rounded-md hover:bg-gray-100 transition text-center">
                        S'inscrire comme candidat
                    </a>
                    <a href="{{ route('register.recruiter') }}" class="bg-emerald-600 text-white font-bold px-6 py-3 rounded-md hover:bg-emerald-700 transition text-center">
                        S'inscrire comme recruteur
                    </a>
                </div>
            @endguest
        </div>
    </section>

    <!-- Recent Jobs -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Offres d'emploi récentes</h2>
                <a href="{{ route('jobs.index') }}" class="text-emerald-500 hover:underline font-medium">Voir tout</a>
            </div>
            <p class="text-gray-600 mb-10 max-w-2xl">Découvrez les dernières opportunités d'emploi disponibles sur notre plateforme.</p>
            
            <div class="grid gap-6">
            @forelse($jobOffers as $job)
                <x-job-card :job="$job" />
            @empty
                <div class="text-center py-12 bg-white rounded-lg border">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-500 text-lg">Aucune offre d'emploi disponible pour le moment.</p>
                    <p class="text-gray-400 mt-2">Revenez bientôt pour de nouvelles opportunités!</p>
                </div>
            @endforelse
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Pourquoi nous choisir?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Notre plateforme connecte les meilleurs talents avec les meilleures opportunités professionnelles.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 rounded-lg p-8 text-center hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-emerald-600 mb-2">{{ number_format($stats['clients'] ?? 1000) }}+</h3>
                    <p class="font-bold text-gray-800 mb-2">Clients dans le monde</p>
                    <p class="text-gray-600 text-sm">
                        Des milliers de professionnels font confiance à notre plateforme pour leur recherche d'emploi.
                    </p>
                </div>
                <!-- Autres statistiques... -->
            </div>
        </div>
    </section>
</x-app-layout>
