<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Recruteurs en attente d\'approbation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-6 text-green-700 bg-green-100 border border-green-400 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-6 text-red-700 bg-red-100 border border-red-400 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium">Recruteurs en attente d'approbation</h3>
                        <p class="text-gray-600">Approuvez ou rejetez les demandes d'inscription des recruteurs.</p>
                    </div>

                    @if ($recruiters->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-sm text-gray-700 border-b">
                                        <th class="px-6 py-4 font-medium">Nom</th>
                                        <th class="px-6 py-4 font-medium">Email</th>
                                        <th class="px-6 py-4 font-medium">Entreprise</th>
                                        <th class="px-6 py-4 font-medium">Secteur</th>
                                        <th class="px-6 py-4 font-medium">Date d'inscription</th>
                                        <th class="px-6 py-4 font-medium">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recruiters as $recruiter)
                                    <tr class="text-sm text-gray-700 border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $recruiter->name }}</td>
                                        <td class="px-6 py-4">{{ $recruiter->email }}</td>
                                        <td class="px-6 py-4">{{ $recruiter->companyProfile->company_name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">{{ $recruiter->companyProfile->industry ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">{{ $recruiter->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-2">
                                                <form action="{{ route('admin.recruiters.approve', $recruiter->id) }}" method="POST" class="inline" id="approve-form-{{ $recruiter->id }}">
                                                    @csrf
                                                    <button type="button" onclick="confirmApproval({{ $recruiter->id }})" class="text-emerald-600 hover:text-emerald-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.recruiters.reject', $recruiter->id) }}" method="POST" class="inline" id="reject-form-{{ $recruiter->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmRejection({{ $recruiter->id }})" class="text-red-600 hover:text-red-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
                        <div class="p-8 text-center text-gray-500 bg-gray-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-lg">Aucun recruteur en attente d'approbation pour le moment.</p>
                            <p class="mt-2">Les nouvelles demandes apparaîtront ici.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmApproval(recruiterId) {
            Swal.fire({
                title: 'Approuver le recruteur?',
                text: "Le recruteur pourra publier des offres d'emploi après approbation.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Oui, approuver',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approve-form-' + recruiterId).submit();
                }
            });
        }

        function confirmRejection(recruiterId) {
            Swal.fire({
                title: 'Rejeter le recruteur?',
                text: "Le compte recruteur sera supprimé. Cette action est irréversible.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Oui, rejeter',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reject-form-' + recruiterId).submit();
                }
            });
        }
    </script>
</x-app-layout>