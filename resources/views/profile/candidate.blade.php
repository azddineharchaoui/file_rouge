<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Mon Profil') }}
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
                        <!-- Section informations personnelles -->
                        <div class="w-full md:w-1/3">
                            <div class="p-4 bg-white border rounded-lg shadow">
                                <div class="flex flex-col items-center mb-6 text-center">
                                    @if($profile->profile_picture)
                                        <img src="{{ Storage::url($profile->profile_picture) }}" alt="{{ Auth::user()->name }}" class="object-cover w-32 h-32 mb-4 rounded-full">
                                    @else
                                        <div class="flex items-center justify-center w-32 h-32 mb-4 text-3xl text-white bg-blue-500 rounded-full">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <h3 class="text-xl font-semibold">{{ Auth::user()->name }}</h3>
                                    <p class="text-gray-600">{{ Auth::user()->email }}</p>
                                </div>
                                
                                <div class="border-t pt-4">
                                    <h4 class="mb-3 text-lg font-medium">Informations de Contact</h4>
                                    <div class="space-y-2">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            <span>{{ $profile->phone ?? 'Non renseigné' }}</span>
                                        </div>
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span>{{ $profile->address ?? 'Non renseignée' }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <a href="#edit-form" class="block w-full py-2 text-center text-white bg-emerald-500 rounded-md hover:bg-emerald-600">
                                        Modifier mon profil
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Section CV et compétences -->
                        <div class="w-full md:w-2/3">
                            <div class="p-4 mb-6 bg-white border rounded-lg shadow">
                                <h3 class="mb-4 text-xl font-semibold">À propos de moi</h3>
                                <p class="mb-6 text-gray-700">
                                    {{ $profile->bio ?? "Aucune information n'a été ajoutée." }}
                                </p>

                                <h3 class="mb-4 text-xl font-semibold">CV et Lettre de motivation</h3>
                                <div class="flex flex-wrap gap-4 mb-6">
                                    @if($profile->cv_path)
                                        <a href="{{ Storage::url($profile->cv_path) }}" target="_blank" class="flex items-center px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                            </svg>
                                            Voir mon CV
                                        </a>
                                    @else
                                        <span class="text-gray-500">Aucun CV n'a été ajouté</span>
                                    @endif
                                </div>

                                <h3 class="mb-4 text-xl font-semibold">Compétences</h3>
                                <div class="mb-6">
                                    @if($profile->skills && count($profile->skills) > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($profile->skills as $skill)
                                                <span class="px-3 py-1 text-sm text-white bg-blue-500 rounded-full">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-500">Aucune compétence n'a été ajoutée</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Formulaire de modification -->
                            <div id="edit-form" class="p-4 bg-white border rounded-lg shadow">
                                <h3 class="mb-6 text-xl font-semibold">Modifier mon profil</h3>
                                
                                <form action="{{ route('profile.updateCandidate') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        <div>
                                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">Téléphone</label>
                                            <input type="text" name="phone" id="phone" value="{{ $profile->phone }}" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-emerald-200">
                                        </div>
                                        
                                        <div>
                                            <label for="address" class="block mb-2 text-sm font-medium text-gray-700">Adresse</label>
                                            <input type="text" name="address" id="address" value="{{ $profile->address }}" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-emerald-200">
                                        </div>
                                        
                                        <div class="md:col-span-2">
                                            <label for="bio" class="block mb-2 text-sm font-medium text-gray-700">À propos de moi</label>
                                            <textarea name="bio" id="bio" rows="4" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-emerald-200">{{ $profile->bio }}</textarea>
                                        </div>
                                        
                                        <div>
                                            <label for="cv_path" class="block mb-2 text-sm font-medium text-gray-700">CV (PDF)</label>
                                            <input type="file" name="cv_path" id="cv_path" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-emerald-200">
                                            @if($profile->cv_path)
                                                <p class="mt-1 text-sm text-gray-500">Un CV est déjà téléchargé. Choisissez un nouveau fichier pour le remplacer.</p>
                                            @endif
                                        </div>
                                        
                                        <div>
                                            <label for="profile_picture" class="block mb-2 text-sm font-medium text-gray-700">Photo de profil</label>
                                            <input type="file" name="profile_picture" id="profile_picture" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-emerald-200">
                                        </div>
                                        
                                        <div class="md:col-span-2">
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Compétences</label>
                                            <div class="p-4 border rounded-md">
                                                <input type="text" id="skill-input" placeholder="Ajouter une compétence et appuyer sur Entrée" class="w-full px-3 py-2 mb-2 border rounded-md focus:outline-none focus:ring focus:ring-emerald-200">
                                                <div id="skills-container" class="flex flex-wrap gap-2 mt-2">
                                                    @if($profile->skills)
                                                        @foreach($profile->skills as $index => $skill)
                                                            <div class="flex items-center px-3 py-1 text-sm text-white bg-blue-500 rounded-full">
                                                                <input type="hidden" name="skills[]" value="{{ $skill }}">
                                                                <span>{{ $skill }}</span>
                                                                <button type="button" class="ml-2 text-white hover:text-red-200" onclick="removeSkill(this.parentNode)">×</button>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const skillInput = document.getElementById('skill-input');
            const skillsContainer = document.getElementById('skills-container');
            
            // Add skill when Enter key is pressed
            skillInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const skillText = skillInput.value.trim();
                    
                    if (skillText) {
                        addSkill(skillText);
                        skillInput.value = '';
                    }
                }
            });
            
            // Function to add skill
            window.addSkill = function(skillText) {
                const skillItem = document.createElement('div');
                skillItem.className = 'flex items-center px-3 py-1 text-sm text-white bg-blue-500 rounded-full';
                skillItem.innerHTML = `
                    <input type="hidden" name="skills[]" value="${skillText}">
                    <span>${skillText}</span>
                    <button type="button" class="ml-2 text-white hover:text-red-200" onclick="removeSkill(this)">×</button>
                `;
                skillsContainer.appendChild(skillItem);
            }
            
            // Function to remove skill
            window.removeSkill = function(element) {
                element.remove();
            }
        });
    </script>
</x-app-layout>