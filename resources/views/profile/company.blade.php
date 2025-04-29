<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Profil de mon entreprise') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="p-4 mb-6 text-green-700 bg-green-100 border border-green-400 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col gap-8 md:flex-row">
                        <!-- Section informations de l'entreprise -->
                        <div class="w-full md:w-1/3">
                            <div class="p-4 bg-white border rounded-lg shadow">
                                <div class="flex flex-col items-center mb-6 text-center">
                                    @if($profile->logo)
                                        <img src="{{ Storage::url($profile->logo) }}" alt="{{ $profile->company_name }}" class="object-cover w-32 h-32 mb-4 rounded-lg">
                                    @else
                                        <div class="flex items-center justify-center w-32 h-32 mb-4 text-3xl text-white bg-emerald-500 rounded-lg">
                                            {{ substr($profile->company_name, 0, 1) }}
                                        </div>
                                    @endif
                                    <h3 class="text-xl font-semibold">{{ $profile->company_name }}</h3>
                                    <p class="text-gray-600">{{ Auth::user()->email }}</p>
                                </div>
                                
                                <div class="border-t pt-4">
                                    <h4 class="mb-3 text-lg font-medium">Informations de Contact</h4>
                                    <div class="space-y-2">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                            <a href="{{ $profile->website }}" target="_blank" class="text-blue-500 hover:underline">{{ $profile->website ?: 'Non renseigné' }}</a>
                                        </div>
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ $profile->industry ?: 'Non renseigné' }}</span>
                                        </div>
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <span>{{ $profile->size ?: 'Non renseignée' }}</span>
                                        </div>
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span>{{ $profile->location ?: 'Non renseignée' }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <a href="#edit-form" class="block w-full py-2 text-center text-white bg-emerald-500 rounded-md hover:bg-emerald-600">
                                        Modifier mon profil d'entreprise
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Section description et détails -->
                        <div class="w-full md:w-2/3">
                            <div class="p-4 mb-6 bg-white border rounded-lg shadow">
                                <h3 class="mb-4 text-xl font-semibold">À propos de notre entreprise</h3>
                                <p class="mb-6 text-gray-700">
                                    {{ $profile->description ?: "Aucune description n'a été ajoutée." }}
                                </p>

                                <h3 class="mb-4 text-xl font-semibold">Logo de l'entreprise</h3>
                                <div class="flex flex-wrap gap-4 mb-6">
                                    @if($profile->logo)
                                        <img src="{{ Storage::url($profile->logo) }}" alt="{{ $profile->company_name }}" class="object-contain w-48 h-auto border rounded-md">
                                    @else
                                        <span class="text-gray-500">Aucun logo n'a été ajouté</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Formulaire de modification -->
                            <div id="edit-form" class="p-4 bg-white border rounded-lg shadow">
                                <h3 class="mb-6 text-xl font-semibold">Modifier le profil de mon entreprise</h3>
                                
                                <form action="{{ route('profile.updateCompany') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        <div>
                                            <label for="company_name" class="block mb-2 text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                                            <input type="text" name="company_name" id="company_name" value="{{ $profile->company_name }}" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-emerald-200" required>
                                        </div>
                                        
                                        <div>
                                            <label for="website" class="block mb-2 text-sm font-medium text-gray-700">Site web</label>
                                            <input type="url" name="website" id="website" value="{{ $profile->website }}" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-emerald-200">
                                        </div>
                                        
                                        <div>
                                            <label for="industry" class="block mb-2 text-sm font-medium text-gray-700">Secteur d'activité</label>
                                            <input type="text" name="industry" id="industry" value="{{ $profile->industry }}" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-emerald-200">
                                        </div>
                                        
                                        <div>
                                            <label for="size" class="block mb-2 text-sm font-medium text-gray-700">Taille de l'entreprise</label>
                                            <select name="size" id="size" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-emerald-200">
                                                <option value="1-10" {{ $profile->size == '1-10' ? 'selected' : '' }}>1-10 employés</option>
                                                <option value="11-50" {{ $profile->size == '11-50' ? 'selected' : '' }}>11-50 employés</option>
                                                <option value="51-200" {{ $profile->size == '51-200' ? 'selected' : '' }}>51-200 employés</option>
                                                <option value="201-500" {{ $profile->size == '201-500' ? 'selected' : '' }}>201-500 employés</option>
                                                <option value="501+" {{ $profile->size == '501+' ? 'selected' : '' }}>501+ employés</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="location" class="block mb-2 text-sm font-medium text-gray-700">Localisation</label>
                                            <input type="text" name="location" id="location" value="{{ $profile->location }}" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-emerald-200">
                                        </div>
                                        
                                        <div>
                                            <label for="logo" class="block mb-2 text-sm font-medium text-gray-700">Logo de l'entreprise</label>
                                            <input type="file" name="logo" id="logo" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-emerald-200">
                                            @if($profile->logo)
                                                <p class="mt-1 text-sm text-gray-500">Un logo est déjà téléchargé. Choisissez un nouveau fichier pour le remplacer.</p>
                                            @endif
                                        </div>
                                        
                                        <div class="md:col-span-2">
                                            <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Description de l'entreprise</label>
                                            <textarea name="description" id="description" rows="6" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-emerald-200">{{ $profile->description }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6">
                                        <button type="submit" class="px-6 py-2 text-white bg-emerald-500 rounded-md hover:bg-emerald-600">
                                            Enregistrer les modifications
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
