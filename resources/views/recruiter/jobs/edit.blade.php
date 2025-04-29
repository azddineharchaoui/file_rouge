<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Modifier l\'offre d\'emploi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="p-4 mb-6 text-red-700 bg-red-100 border border-red-400 rounded-md">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('recruiter.jobs.update', $job->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <!-- Informations principales -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Informations principales</h3>
                                <p class="mt-1 text-sm text-gray-600">Détails essentiels de l'offre d'emploi.</p>
                                
                                <div class="grid grid-cols-1 mt-6 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-6">
                                        <label for="title" class="block text-sm font-medium text-gray-700">
                                            Titre du poste <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-1">
                                            <input type="text" id="title" name="title" 
                                                class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                                                value="{{ old('title', $job->title) }}" required>
                                        </div>
                                    </div>
                            
                                    <div class="sm:col-span-3">
                                        <label for="categorie_id" class="block text-sm font-medium text-gray-700">
                                            Catégorie <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-1">
                                            <select id="categorie_id" name="categorie_id" 
                                                class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                                                required>
                                                <option value="">Sélectionner une catégorie</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('categorie_id', $job->categorie_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="sm:col-span-3">
                                        <label for="location_id" class="block text-sm font-medium text-gray-700">
                                            Localisation <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-1">
                                            <select id="location_id" name="location_id" 
                                                class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                                                required>
                                                <option value="">Sélectionner une localisation</option>
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->id }}" {{ old('location_id', $job->location_id) == $location->id ? 'selected' : '' }}>
                                                        {{ $location->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="sm:col-span-3">
                                        <label for="employment_type" class="block text-sm font-medium text-gray-700">
                                            Type de contrat <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-1">
                                            <select id="employment_type" name="employment_type" 
                                                class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                                                required>
                                                <option value="">Sélectionner un type</option>
                                                <option value="full-time" {{ old('employment_type', $job->employment_type) == 'full-time' ? 'selected' : '' }}>CDI / Temps plein</option>
                                                <option value="part-time" {{ old('employment_type', $job->employment_type) == 'part-time' ? 'selected' : '' }}>Temps partiel</option>
                                                <option value="contract" {{ old('employment_type', $job->employment_type) == 'contract' ? 'selected' : '' }}>CDD / Contrat</option>
                                                <option value="internship" {{ old('employment_type', $job->employment_type) == 'internship' ? 'selected' : '' }}>Stage</option>
                                                <option value="temporary" {{ old('employment_type', $job->employment_type) == 'temporary' ? 'selected' : '' }}>Intérim</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <!-- Salaire -->
                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Informations de salaire</h3>
                                <p class="mt-1 text-sm text-gray-600">Définissez une fourchette salariale pour cette offre.</p>
                                
                                <div class="grid grid-cols-1 mt-6 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label for="salary" class="block text-sm font-medium text-gray-700">
                                            Salaire <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-1">
                                            <input type="text" id="salary" name="salary" 
                                                class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                                                value="{{ old('salary', $job->salary) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Description du poste</h3>
                                <p class="mt-1 text-sm text-gray-600">Détaillez les missions et responsabilités du poste.</p>
                                
                                <div class="mt-6">
                                    <label for="description" class="block text-sm font-medium text-gray-700">
                                        Description détaillée <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-1">
                                        <textarea id="description" name="description" rows="10" 
                                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                                            required>{{ old('description', $job->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Exigences -->
                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Exigences du poste</h3>
                                <p class="mt-1 text-sm text-gray-600">Précisez les compétences et qualifications requises.</p>
                                
                                <div class="mt-6">
                                    <label for="requirements" class="block text-sm font-medium text-gray-700">
                                        Exigences et qualifications
                                    </label>
                                    <div class="mt-1">
                                        <textarea id="requirements" name="requirements" rows="6" 
                                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                                            >{{ old('requirements', $job->requirements) }}</textarea>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Listez les compétences techniques, diplômes, expériences et autres qualifications requises.
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Avantages -->
                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Avantages</h3>
                                <p class="mt-1 text-sm text-gray-600">Mettez en avant les avantages proposés aux candidats.</p>
                                
                                <div class="mt-6">
                                    <label for="benefits" class="block text-sm font-medium text-gray-700">
                                        Avantages et bénéfices
                                    </label>
                                    <div class="mt-1">
                                        <textarea id="benefits" name="benefits" rows="4" 
                                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                                            >{{ old('benefits', $job->benefits) }}</textarea>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Exemples: tickets restaurant, télétravail, RTT, primes, etc.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-8 space-x-3">
                            <a href="{{ route('recruiter.jobs') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                Annuler
                            </a>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-md shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                Mettre à jour l'offre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>