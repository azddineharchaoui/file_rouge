<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Mes Entretiens') }}
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
                    @if($interviews->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium">Entretiens programmés</h3>
                            <p class="text-gray-600">Gérez vos entretiens à venir et passés</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entreprise</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poste</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Heure</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($interviews as $interview)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($interview->jobOffer->company->logo)
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($interview->jobOffer->company->logo) }}" alt="{{ $interview->jobOffer->company->company_name }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                            {{ substr($interview->jobOffer->company->company_name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $interview->jobOffer->company->company_name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $interview->jobOffer->title }}</div>
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
                                                @if($interview->status === 'scheduled')
                                                    <div class="flex space-x-2">
                                                        <form action="{{ route('candidate.confirmInterview', $interview) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="text-green-600 hover:text-green-900">Confirmer</button>
                                                        </form>
                                                        
                                                        <button type="button" class="text-yellow-600 hover:text-yellow-900" 
                                                                onclick="document.getElementById('reschedule-modal-{{ $interview->id }}').classList.remove('hidden')">
                                                            Demander un report
                                                        </button>
                                                    </div>
                                                @elseif($interview->status === 'confirmed' && $interview->meeting_link)
                                                    <a href="{{ $interview->meeting_link }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                                        Rejoindre
                                                    </a>
                                                @endif
                                                
                                                @if($interview->notes)
                                                    <div class="mt-2 text-xs text-gray-500">
                                                        <details>
                                                            <summary class="cursor-pointer">Notes</summary>
                                                            <p class="mt-1">{{ $interview->notes }}</p>
                                                        </details>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        <!-- Modal pour demander un report -->
                                        <div id="reschedule-modal-{{ $interview->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                                <div class="mt-3 text-center">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Demander un report d'entretien</h3>
                                                    <form class="mt-4 text-left" action="{{ route('candidate.requestReschedule', $interview) }}" method="POST">
                                                        @csrf
                                                        <div class="mb-4">
                                                            <label for="reschedule_reason" class="block text-sm font-medium text-gray-700">Motif du report</label>
                                                            <textarea name="reschedule_reason" id="reschedule_reason" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500 focus:ring-opacity-50" required></textarea>
                                                        </div>
                                                        <div class="flex justify-between mt-5">
                                                            <button type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400"
                                                                    onclick="document.getElementById('reschedule-modal-{{ $interview->id }}').classList.add('hidden')">
                                                                Annuler
                                                            </button>
                                                            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">
                                                                Envoyer la demande
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $interviews->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">Aucun entretien programmé</h3>
                            <p class="mt-1 text-gray-500">Vous n'avez pas encore d'entretiens programmés.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>