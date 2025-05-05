<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Gestion des offres d\'emploi') }}
            </h2>
            <a href="{{ route('recruiter.jobs.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-emerald-500 border border-transparent rounded-md hover:bg-emerald-600">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Créer une offre
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="p-4 mb-6 text-green-700 bg-green-100 border border-green-400 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-6 text-red-700 bg-red-100 border border-red-400 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-4 text-lg font-medium">Vos offres d'emploi</h3>
                        <a href="{{ route('recruiter.jobs.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-emerald-500 border border-transparent rounded-md hover:bg-emerald-600">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Ajouter un nouveau job
                        </a>
                    </div>
                    @if($jobOffers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Titre
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Lieu
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Candidatures
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date de création
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($jobOffers as $job)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="min-w-0 flex-1">
                                                    <h3 class="text-base font-medium text-gray-900 truncate">{{ $job->title }}</h3>
                                                    <div class="mt-1 flex items-center text-sm text-gray-500">
                                                        <span class="truncate">{{ $job->location->name ?? 'Emplacement non spécifié' }}</span>
                                                        <span class="mx-2 inline-block">&middot;</span>
                                                        <span>
                                                            @switch($job->employment_type)
                                                                @case('full-time')
                                                                    CDI / Temps plein
                                                                    @break
                                                                @case('part-time')
                                                                    Temps partiel
                                                                    @break
                                                                @case('contract')
                                                                    CDD / Contrat
                                                                    @break
                                                                @case('internship')
                                                                    Stage
                                                                    @break
                                                                @case('temporary')
                                                                    Intérim
                                                                    @break
                                                                @default
                                                                    {{ $job->employment_type }}
                                                            @endswitch
                                                        </span>
                                                    </div>
                                                    <div class="mt-2 flex items-center gap-4">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $job->applications_count ?? 0 }} candidature(s)
                                                        </span>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            {{ $job->views ?? 0 }} vue(s)
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $job->formatted_employment_type }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $job->location->name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $job->applications_count }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $job->created_at->format('d/m/Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('jobs.show', $job->id) }}" class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded hover:bg-blue-200">
                                                        Voir
                                                    </a>
                                                    <a href="{{ route('recruiter.jobs.applications', $job->id) }}" class="px-3 py-1 text-xs text-purple-600 bg-purple-100 rounded hover:bg-purple-200">
                                                        Candidatures
                                                    </a>
                                                    <a href="{{ route('recruiter.jobs.edit', $job->id) }}" class="px-3 py-1 text-xs text-emerald-600 bg-emerald-100 rounded hover:bg-emerald-200">
                                                        Modifier
                                                    </a>
                                                    <form method="POST" action="{{ route('recruiter.jobs.destroy', $job->id) }}" class="inline" id="delete-form-{{ $job->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="confirmDelete({{ $job->id }})" class="text-red-600 hover:text-red-900" title="Supprimer">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    @else
                        <div class="p-4 text-center text-gray-500 bg-gray-50 rounded-md">
                            <p class="mb-2 text-lg font-medium">Vous n'avez pas encore créé d'offre d'emploi</p>
                            <p class="mb-6">Créez votre première offre d'emploi pour commencer à recruter des candidats.</p>
                            <a href="{{ route('recruiter.jobs.create') }}" class="inline-flex items-center px-6 py-3 text-white bg-emerald-500 rounded-md hover:bg-emerald-600 transition-colors">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Créer ma première offre
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Assurez-vous que SweetAlert est chargé avant d'utiliser la fonction confirmDelete -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(jobId) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Cette offre d'emploi et toutes ses candidatures seront supprimées définitivement!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + jobId).submit();
                }
            });
        }
    </script>
</x-app-layout>
