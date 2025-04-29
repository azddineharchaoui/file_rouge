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
                    <h3 class="mb-4 text-lg font-medium">Vos offres d'emploi</h3>
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
                                                <div class="text-sm font-medium text-gray-900">{{ $job->title }}</div>
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
                                                    <form action="{{ route('recruiter.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ? Cette action est irréversible.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1 text-xs text-red-600 bg-red-100 rounded hover:bg-red-200">
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $jobOffers->links() }}
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
</x-app-layout>
