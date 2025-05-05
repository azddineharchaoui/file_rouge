<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tableau de bord administrateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-6 text-green-700 bg-green-100 border border-green-400 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Statistiques générales -->
            <div class="grid grid-cols-1 gap-5 mb-8 md:grid-cols-3">
                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Utilisateurs</h3>
                        <span class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-full">
                            {{ $stats['totalUsers'] }}
                        </span>
                    </div>
                    <div class="flex justify-between mt-4 text-sm">
                        <div>
                            <p class="text-gray-600">Candidats</p>
                            <p class="font-semibold">{{ $stats['totalCandidates'] }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Recruteurs</p>
                            <p class="font-semibold">{{ $stats['totalRecruiters'] }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">En attente</p>
                            <p class="font-semibold text-orange-500">{{ $stats['pendingRecruiters'] }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Offres d'emploi</h3>
                        <span class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-green-500 rounded-full">
                            {{ $stats['totalJobOffers'] }}
                        </span>
                    </div>
                    <div class="mt-4 text-sm">
                        <p class="text-gray-600">Candidatures</p>
                        <p class="font-semibold">{{ $stats['totalApplications'] }}</p>
                    </div>
                </div>
                
                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Alertes</h3>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.recruiters.pending') }}" class="flex items-center justify-between p-3 transition bg-yellow-50 rounded-md hover:bg-yellow-100">
                            <span class="text-sm text-yellow-800">Recruteurs en attente</span>
                            <span class="px-2 py-1 text-xs font-medium text-white bg-yellow-500 rounded-full">
                                {{ $stats['pendingRecruiters'] }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <!-- Recruteurs en attente d'approbation -->
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <h3 class="text-lg font-medium text-gray-900">Recruteurs en attente</h3>
                        <a href="{{ route('admin.recruiters.pending') }}" class="text-sm text-emerald-600 hover:underline">Voir tout</a>
                    </div>
                    <div class="p-6">
                        @if($pendingRecruiters->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="text-sm text-gray-700 border-b">
                                            <th class="py-3 pr-6">Nom</th>
                                            <th class="py-3 pr-6">Entreprise</th>
                                            <th class="py-3 pr-6">Date</th>
                                            <th class="py-3 pr-6">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pendingRecruiters as $recruiter)
                                        <tr class="text-sm text-gray-700 border-b hover:bg-gray-50">
                                            <td class="py-3 pr-6">{{ $recruiter->name }}</td>
                                            <td class="py-3 pr-6">{{ $recruiter->companyProfile->company_name ?? 'N/A' }}</td>
                                            <td class="py-3 pr-6">{{ $recruiter->created_at->format('d/m/Y') }}</td>
                                            <td class="flex py-3 space-x-2">
                                                <form action="{{ route('admin.recruiters.approve', $recruiter->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 text-xs text-white bg-green-500 rounded hover:bg-green-600">
                                                        Approuver
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.recruiters.reject', $recruiter->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir rejeter ce compte?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600">
                                                        Rejeter
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-4 text-center text-gray-500">
                                Aucun recruteur en attente d'approbation.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Offres d'emploi récentes -->
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <h3 class="text-lg font-medium text-gray-900">Offres d'emploi récentes</h3>
                        <a href="{{ route('admin.jobs') }}" class="text-sm text-emerald-600 hover:underline">Voir tout</a>
                    </div>
                    <div class="p-6">
                        @if($recentJobs->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="text-sm text-gray-700 border-b">
                                            <th class="py-3 pr-6">Titre</th>
                                            <th class="py-3 pr-6">Entreprise</th>
                                            <th class="py-3 pr-6">Date</th>
                                            <th class="py-3 pr-6">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentJobs as $job)
                                        <tr class="text-sm text-gray-700 border-b hover:bg-gray-50">
                                            <td class="py-3 pr-6">{{ $job->title }}</td>
                                            <td class="py-3 pr-6">{{ $job->company->company_name ?? 'N/A' }}</td>
                                            <td class="py-3 pr-6">{{ $job->created_at->format('d/m/Y') }}</td>
                                            <td class="py-3">
                                                <form action="{{ route('admin.jobs.delete', $job->id) }}" method="POST" id="delete-form-{{ $job->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmJobDelete({{ $job->id }})" class="px-3 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-4 text-center text-gray-500">
                                Aucune offre d'emploi récente.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Utilisateurs récents -->
            <div class="mt-8 overflow-hidden bg-white rounded-lg shadow">
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Utilisateurs récents</h3>
                    <a href="{{ route('admin.users') }}" class="text-sm text-emerald-600 hover:underline">Voir tout</a>
                </div>
                <div class="p-6">
                    @if($recentUsers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-sm text-gray-700 border-b">
                                        <th class="py-3 pr-6">Nom</th>
                                        <th class="py-3 pr-6">Email</th>
                                        <th class="py-3 pr-6">Rôle</th>
                                        <th class="py-3 pr-6">Statut</th>
                                        <th class="py-3 pr-6">Date d'inscription</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentUsers as $user)
                                    <tr class="text-sm text-gray-700 border-b hover:bg-gray-50">
                                        <td class="py-3 pr-6">{{ $user->name }}</td>
                                        <td class="py-3 pr-6">{{ $user->email }}</td>
                                        <td class="py-3 pr-6">
                                            @if($user->role === 'admin')
                                                <span class="px-2 py-1 text-xs text-white bg-purple-500 rounded-full">Admin</span>
                                            @elseif($user->role === 'recruiter')
                                                <span class="px-2 py-1 text-xs text-white bg-blue-500 rounded-full">Recruteur</span>
                                            @else
                                                <span class="px-2 py-1 text-xs text-white bg-green-500 rounded-full">Candidat</span>
                                            @endif
                                        </td>
                                        <td class="py-3 pr-6">
                                            @if($user->is_approved)
                                                <span class="px-2 py-1 text-xs text-white bg-green-500 rounded-full">Actif</span>
                                            @else
                                                <span class="px-2 py-1 text-xs text-white bg-orange-500 rounded-full">En attente</span>
                                            @endif
                                        </td>
                                        <td class="py-3 pr-6">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center text-gray-500">
                            Aucun utilisateur récent.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmJobDelete(jobId) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Cette offre d'emploi sera supprimée définitivement!",
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