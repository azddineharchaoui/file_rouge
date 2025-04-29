<x-app-layout>
    <div class="bg-gray-50 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar filtres -->
                <div class="w-full lg:w-1/4">
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-semibold mb-6">Filtrer les offres</h2>
                        <form action="{{ route('jobs.index') }}" method="GET">
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mot-clé</label>
                                    <input 
                                        type="text" 
                                        name="keyword" 
                                        value="{{ request('keyword') }}" 
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        placeholder="Rechercher par titre, compétence..."
                                    >
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Localisation</label>
                                    <select name="location" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                        <option value="">Toutes les localisations</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                                    <select name="category" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                        <option value="">Toutes les catégories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Type de contrat</label>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input 
                                                type="checkbox" 
                                                name="employment_types[]" 
                                                value="full-time" 
                                                id="type_full_time"
                                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                                                {{ in_array('full-time', request('employment_types', [])) ? 'checked' : '' }}
                                            >
                                            <label for="type_full_time" class="ml-2 text-sm text-gray-700">CDI / Temps plein</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input 
                                                type="checkbox" 
                                                name="employment_types[]" 
                                                value="part-time" 
                                                id="type_part_time"
                                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                                                {{ in_array('part-time', request('employment_types', [])) ? 'checked' : '' }}
                                            >
                                            <label for="type_part_time" class="ml-2 text-sm text-gray-700">Temps partiel</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input 
                                                type="checkbox" 
                                                name="employment_types[]" 
                                                value="contract" 
                                                id="type_contract"
                                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                                                {{ in_array('contract', request('employment_types', [])) ? 'checked' : '' }}
                                            >
                                            <label for="type_contract" class="ml-2 text-sm text-gray-700">CDD / Contrat</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input 
                                                type="checkbox" 
                                                name="employment_types[]" 
                                                value="internship" 
                                                id="type_internship"
                                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                                                {{ in_array('internship', request('employment_types', [])) ? 'checked' : '' }}
                                            >
                                            <label for="type_internship" class="ml-2 text-sm text-gray-700">Stage</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input 
                                                type="checkbox" 
                                                name="employment_types[]" 
                                                value="temporary" 
                                                id="type_temporary"
                                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                                                {{ in_array('temporary', request('employment_types', [])) ? 'checked' : '' }}
                                            >
                                            <label for="type_temporary" class="ml-2 text-sm text-gray-700">Intérim</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Salaire minimum</label>
                                    <select name="salary_min" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                        <option value="">Tous les salaires</option>
                                        <option value="30000" {{ request('salary_min') == '30000' ? 'selected' : '' }}>30 000 € et plus</option>
                                        <option value="40000" {{ request('salary_min') == '40000' ? 'selected' : '' }}>40 000 € et plus</option>
                                        <option value="50000" {{ request('salary_min') == '50000' ? 'selected' : '' }}>50 000 € et plus</option>
                                        <option value="60000" {{ request('salary_min') == '60000' ? 'selected' : '' }}>60 000 € et plus</option>
                                        <option value="70000" {{ request('salary_min') == '70000' ? 'selected' : '' }}>70 000 € et plus</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de publication</label>
                                    <select name="posted_within" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                        <option value="">Toutes les dates</option>
                                        <option value="1" {{ request('posted_within') == '1' ? 'selected' : '' }}>Dernières 24 heures</option>
                                        <option value="7" {{ request('posted_within') == '7' ? 'selected' : '' }}>7 derniers jours</option>
                                        <option value="14" {{ request('posted_within') == '14' ? 'selected' : '' }}>14 derniers jours</option>
                                        <option value="30" {{ request('posted_within') == '30' ? 'selected' : '' }}>30 derniers jours</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <button type="submit" class="w-full bg-emerald-500 text-white py-2 px-4 rounded-md hover:bg-emerald-600 transition">
                                        Appliquer les filtres
                                    </button>
                                </div>
                                
                                <div>
                                    <a href="{{ route('jobs.index') }}" class="block w-full text-center text-sm text-emerald-600 hover:underline">
                                        Effacer tous les filtres
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    @guest
                    <div class="bg-emerald-50 rounded-lg p-6">
                        <h3 class="font-semibold text-emerald-800 mb-2">Créer un compte</h3>
                        <p class="text-sm text-emerald-700 mb-4">Créez un compte pour postuler facilement et recevoir des alertes d'emploi personnalisées.</p>
                        <div class="flex flex-col gap-3">
                            <a href="{{ route('register.candidate') }}" class="bg-emerald-500 text-white text-sm px-4 py-2 rounded-md text-center hover:bg-emerald-600 transition">
                                S'inscrire comme candidat
                            </a>
                            <a href="{{ route('register.recruiter') }}" class="bg-white text-emerald-500 border border-emerald-500 text-sm px-4 py-2 rounded-md text-center hover:bg-emerald-50 transition">
                                S'inscrire comme recruteur
                            </a>
                        </div>
                    </div>
                    @endguest
                </div>

                <!-- Contenu principal -->
                <div class="w-full lg:w-3/4">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Offres d'emploi</h1>
                            <p class="text-gray-600">{{ $jobOffers->total() }} offres trouvées</p>
                        </div>
                        <div class="flex items-center gap-2 bg-white rounded-md">
                            <label class="text-sm text-gray-700 mr-1">Trier par:</label>
                            <select name="sort" id="sort" onchange="window.location.href=this.value" class="border-0 focus:ring-0 text-sm py-1 pl-2 pr-8 rounded-md">
                                <option value="{{ route('jobs.index', request()->except('sort')) }}" {{ !request('sort') ? 'selected' : '' }}>Plus récentes</option>
                                <option value="{{ route('jobs.index', array_merge(request()->except('sort'), ['sort' => 'salary_desc'])) }}" {{ request('sort') == 'salary_desc' ? 'selected' : '' }}>Salaire (décroissant)</option>
                                <option value="{{ route('jobs.index', array_merge(request()->except('sort'), ['sort' => 'salary_asc'])) }}" {{ request('sort') == 'salary_asc' ? 'selected' : '' }}>Salaire (croissant)</option>
                            </select>
                        </div>
                    </div>

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
                                                    <span>{{ $job->category->name ?? 'Catégorie non spécifiée' }}</span>
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
                                <p class="text-gray-500 text-lg">Aucune offre d'emploi disponible avec ces critères.</p>
                                <p class="text-gray-400 mt-2">Essayez de modifier vos filtres de recherche.</p>
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
    </div>
</x-app-layout>