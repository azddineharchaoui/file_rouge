<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Gestion des entretiens') }}
        </h2>
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

            @if(session('info'))
                <div class="p-4 mb-6 text-blue-700 bg-blue-100 border border-blue-400 rounded-md">
                    {{ session('info') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Liste des entretiens programmés</h3>
                    </div>

                    @if($interviews->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Candidat
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Offre d'emploi
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date & Heure
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Statut
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($interviews as $interview)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if($interview->user && $interview->user->candidateProfile && $interview->user->candidateProfile->avatar)
                                                            <img class="h-10 w-10 rounded-full" src="{{ Storage::url($interview->user->candidateProfile->avatar) }}" alt="{{ $interview->user->name }}">
                                                        @else
                                                            <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-500">
                                                                <span class="text-lg font-medium">{{ substr($interview->user->name ?? 'C', 0, 1) }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $interview->user->name ?? 'Candidat non disponible' }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $interview->user->email ?? 'Email non disponible' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $interview->jobOffer->title ?? 'Offre non disponible' }}</div>
                                                <div class="text-sm text-gray-500">Réf: {{ $interview->jobOffer->id ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $interview->scheduled_at->format('d/m/Y à H:i') }}</div>
                                                <div class="text-sm text-gray-500">{{ $interview->duration_minutes }} minutes</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($interview->interview_type == 'in-person')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        En personne
                                                    </span>
                                                    <div class="text-xs text-gray-500 mt-1">{{ $interview->location }}</div>
                                                @elseif($interview->interview_type == 'video')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Vidéo
                                                    </span>
                                                    @if($interview->meeting_link)
                                                        <div class="text-xs text-blue-600 mt-1">
                                                            <a href="{{ $interview->meeting_link }}" target="_blank" rel="noopener">Lien de réunion</a>
                                                        </div>
                                                    @endif
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Téléphone
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @switch($interview->status)
                                                    @case('scheduled')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            En attente
                                                        </span>
                                                        @break
                                                    @case('confirmed')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Confirmé
                                                        </span>
                                                        @break
                                                    @case('completed')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            Terminé
                                                        </span>
                                                        @break
                                                    @case('no-show')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Non présenté
                                                        </span>
                                                        @break
                                                    @case('canceled')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                            Annulé
                                                        </span>
                                                        @break
                                                    @case('reschedule_requested')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                            Report demandé
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                            {{ $interview->status }}
                                                        </span>
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    @if($interview->meeting_link && ($interview->interview_type == 'video'))
                                                        <a href="{{ $interview->meeting_link }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                                            <span class="sr-only">Rejoindre</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" title="Rejoindre">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                            </svg>
                                                        </a>
                                                    @endif
                                                    
                                                    <a href="{{ route('recruiter.jobs.applications', $interview->jobOffer->id ?? 0) }}" class="text-emerald-600 hover:text-emerald-900">
                                                        <span class="sr-only">Voir candidature</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" title="Voir candidature">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    
                                                    @if($interview->status == 'scheduled' || $interview->status == 'confirmed' || $interview->status == 'reschedule_requested')
                                                        <button type="button" onclick="openRescheduleModal({{ $interview->id }})" class="text-purple-600 hover:text-purple-900">
                                                            <span class="sr-only">Reprogrammer</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" title="Reprogrammer">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </button>

                                                        <form action="{{ route('recruiter.interviews.status', $interview->id) }}" method="POST" class="inline" id="cancel-form-{{ $interview->id }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="canceled">
                                                            <button type="button" class="text-red-600 hover:text-red-900" onclick="confirmCancel({{ $interview->id }})">
                                                                <span class="sr-only">Annuler</span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" title="Annuler">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    @if($interview->status == 'scheduled' || $interview->status == 'confirmed')
                                                        <form action="{{ route('recruiter.interviews.status', $interview->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="completed">
                                                            <button type="submit" class="text-blue-600 hover:text-blue-900" onclick="return confirm('Confirmez-vous que cet entretien a bien eu lieu?')">
                                                                <span class="sr-only">Marquer comme terminé</span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" title="Marquer comme terminé">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $interviews->links() }}
                        </div>
                    @else
                        <div class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">Aucun entretien programmé</h3>
                            <p class="mt-1 text-sm text-gray-500">Vous n'avez pas encore d'entretiens planifiés avec des candidats.</p>
                            <div class="mt-6">
                                <a href="{{ route('recruiter.jobs') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
                                    Voir mes offres d'emploi
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de reprogrammation -->
    <div id="reschedule-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Reprogrammer l'entretien</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeRescheduleModal()">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form id="reschedule-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-1">
                            Nouvelle date et heure <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" id="scheduled_at" name="scheduled_at" 
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                            Raison du changement
                        </label>
                        <textarea id="notes" name="notes" rows="3" 
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Expliquez pourquoi l'entretien est reprogrammé..."></textarea>
                    </div>
                    
                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                            onclick="closeRescheduleModal()">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-md shadow-sm hover:bg-emerald-700">
                            Reprogrammer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRescheduleModal(interviewId) {
            document.getElementById('reschedule-form').action = `/recruiter/interviews/${interviewId}`;
            document.getElementById('reschedule-modal').classList.remove('hidden');
        }
        
        function closeRescheduleModal() {
            document.getElementById('reschedule-modal').classList.add('hidden');
        }

        function confirmCancel(interviewId) {
            Swal.fire({
                title: 'Confirmation',
                text: 'Êtes-vous sûr de vouloir annuler cet entretien?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Oui, annuler',
                cancelButtonText: 'Non, garder'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancel-form-' + interviewId).submit();
                }
            });
        }
    </script>
</x-app-layout>
