<x-app-layout>
    <div class="bg-gray-50 py-10">
        <div class="container mx-auto px-4">
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow">
                {{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow">
                    {{ session('error') }}
                </div>
            @endif
            <div class="mb-6">
                <a href="{{ route('jobs.index') }}" class="inline-flex items-center text-emerald-600 hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour aux offres
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                @if($job->company && $job->company->logo)
                                    <img src="{{ Storage::url($job->company->logo) }}" alt="{{ $job->company->company_name }}" class="w-12 h-12 object-contain">
                                @else
                                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 font-bold text-xl">
                                        {{ substr($job->company->company_name ?? 'J', 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $job->title }}</h1>
                                <p class="text-emerald-600">{{ $job->company->company_name ?? 'Entreprise' }}</p>
                            </div>
                        </div>
                        <div>
                            @guest
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <a href="{{ route('register.candidate') }}" class="bg-emerald-500 text-white px-5 py-2 rounded-md text-sm font-medium hover:bg-emerald-600 transition text-center">
                                        S'inscrire pour postuler
                                    </a>
                                    <a href="{{ route('register.recruiter') }}" class="border border-emerald-500 text-emerald-500 px-5 py-2 rounded-md text-sm font-medium hover:bg-emerald-50 transition text-center">
                                        S'inscrire comme recruteur
                                    </a>
                                </div>
                            @else
                                @if(auth()->user()->role === 'candidate')
                                    @if($job->hasUserApplied())
                                        <div class="bg-green-100 border border-green-200 text-green-700 px-6 py-3 rounded-md text-sm font-medium flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Candidature envoyée avec succès !
                                        </div>
                                    @else
                                        <form action="{{ route('jobs.apply', $job->id) }}" method="POST" id="apply-form">
                                            @csrf
                                            <button type="button" onclick="confirmApply()" class="bg-emerald-500 text-white px-6 py-3 rounded-md text-sm font-medium hover:bg-emerald-600 transition">Postuler maintenant</button>
                                        </form>
                                        <!-- Ajout de SweetAlert directement dans cette page -->
                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                        <script>
                                            function confirmApply() {
                                                Swal.fire({
                                                    title: 'Confirmer la candidature',
                                                    text: 'Voulez-vous vraiment postuler à cette offre ? Votre CV actuel sera envoyé au recruteur.',
                                                    icon: 'question',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#10B981',
                                                    cancelButtonColor: '#6B7280',
                                                    confirmButtonText: 'Oui, postuler',
                                                    cancelButtonText: 'Annuler'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById('apply-form').submit();
                                                    }
                                                });
                                            }
                                        </script>
                                    @endif
                                @endif  
                            @endguest
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <div class="flex flex-wrap gap-4 mb-6">
                                <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-gray-700">{{ $job->location->name ?? 'Lieu non spécifié' }}</span>                                </div>
                                <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-700">{{ $job->formatted_employment_type }}</span>
                                </div>
                                <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-700">{{ $job->salary_range }}</span>
                                </div>
                                <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-gray-700">{{ $job->category->name ?? 'Catégorie' }}</span>
                                </div>
                                <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-gray-700">{{ $job->closing_date ? $job->closing_date->format('d/m/Y') : 'Pas de date limite' }}</span>
                                </div>
                            </div>

                            <div class="prose max-w-none">
                                <h2 class="text-xl font-bold mb-4">Description du poste</h2>
                                {!! nl2br(e($job->description)) !!}
                                
                                <h2 class="text-xl font-bold mt-8 mb-4">Exigences</h2>
                                {!! nl2br(e($job->requirements)) !!}
                            </div>
                            
                        </div>

                        <div>
                            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                                <h3 class="text-lg font-semibold mb-4">À propos de l'entreprise</h3>
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 font-bold text-xl">
                                        {{ substr($job->company->company_name ?? 'J', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $job->company->company_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $job->company->industry }}</p>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-4">{{ $job->company->description }}</p>
                                
                                <a href="{{ $job->company->website }}" target="_blank" rel="noopener noreferrer" class="text-emerald-600 text-sm hover:underline inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    Visiter le site web
                                </a>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Autres offres similaires</h3>
                                <div class="space-y-4">
                                    @foreach($similarJobs as $similarJob)
                                        <a href="{{ route('jobs.show', $similarJob->id) }}" class="block hover:bg-gray-100 p-3 rounded-md transition">
                                            <h4 class="font-medium text-gray-900">{{ $similarJob->title }}</h4>
                                            <p class="text-sm text-gray-500">{{ $similarJob->company->company_name }}</p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-xs text-emerald-600">{{ $similarJob->location->name ?? 'Non spécifié' }}</span>
                                                <span class="text-xs text-gray-400">•</span>
                                                <span class="text-xs text-emerald-600">{{ $similarJob->created_at->diffForHumans() }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>