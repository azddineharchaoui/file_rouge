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
                        placeholder="Rechercher un emploi..." 
                        class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-800"
                    >
                </div>
                <div class="flex-1">
                    <select name="location" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-500">
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
            
            <div class="space-y-5">
                @forelse($jobOffers as $job)
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div class="flex gap-4">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                    @if($job->company && $job->company->logo)
                                        <img src="{{ Storage::url($job->company->logo) }}" alt="{{ $job->company->company_name }}" class="w-12 h-12 object-contain">
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ $job->location->name ?? 'Lieu non spécifié' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 ml-auto">
                                <span class="text-sm text-emerald-500 whitespace-nowrap">{{ $job->created_at->diffForHumans() }}</span>
                                <a href="{{ route('jobs.show', $job->id) }}" class="bg-emerald-500 text-white px-5 py-2 rounded-md text-sm font-medium hover:bg-emerald-600 transition whitespace-nowrap">Voir détails</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-white rounded-lg border">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-500 text-lg">Aucune offre d'emploi disponible pour le moment.</p>
                        <p class="text-gray-400 mt-2">Revenez bientôt pour de nouvelles opportunités!</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $jobOffers->links() }}
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-emerald-600 mb-2">{{ number_format($stats['jobs']) }}+</h3>
                    <p class="font-bold text-gray-800 mb-2">Offres d'emploi</p>
                    <p class="text-gray-600 text-sm">
                        Opportunités d'emploi diverses dans de nombreux secteurs et localisations.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-8 text-center hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-emerald-600 mb-2">{{ number_format($stats['companies']) }}+</h3>
                    <p class="font-bold text-gray-800 mb-2">Entreprises</p>
                    <p class="text-gray-600 text-sm">
                        Recruteurs de confiance recherchant activement des talents sur notre plateforme.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-8 text-center hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-emerald-600 mb-2">{{ number_format($stats['candidates']) }}+</h3>
                    <p class="font-bold text-gray-800 mb-2">Candidats</p>
                    <p class="text-gray-600 text-sm">
                        Professionnels qualifiés à la recherche de nouvelles opportunités de carrière.
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
