<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Gestion des offres d\'emploi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-6 text-green-700 bg-green-100 border border-green-400 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium">Toutes les offres d'emploi</h3>
                        <p class="text-gray-600">Gérez les offres d'emploi publiées sur la plateforme.</p>
                    </div>

                    @if ($jobOffers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-sm text-gray-700 border-b">
                                        <th class="px-6 py-4 font-medium">Titre</th>
                                        <th class="px-6 py-4 font-medium">Entreprise</th>
                                        <th class="px-6 py-4 font-medium">Location</th>
                                        <th class="px-6 py-4 font-medium">Type</th>
                                        <th class="px-6 py-4 font-medium">Candidatures</th>
                                        <th class="px-6 py-4 font-medium">Date de publication</th>
                                        <th class="px-6 py-4 font-medium">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobOffers as $job)
                                    <tr class="text-sm text-gray-700 border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $job->title }}</td>
                                        <td class="px-6 py-4">{{ $job->company->company_name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">{{ $job->location->city }}</td>
                                        <td class="px-6 py-4">{{ $job->employment_type }}</td>
                                        <td class="px-6 py-4">{{ $job->applications->count() }}</td>
                                        <td class="px-6 py-4">{{ $job->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('jobs.show', $job->id) }}" class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded hover:bg-blue-200">
                                                    Voir
                                                </a>
                                                <form action="{{ route('admin.jobs.delete', $job->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre? Cette action est irréversible.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600">
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

                        <div class="mt-6">
                            {{ $jobOffers->links() }}
                        </div>
                    @else
                        <div class="p-8 text-center text-gray-500 bg-gray-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-lg">Aucune offre d'emploi disponible.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>