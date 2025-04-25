<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Candidatures pour') }}: {{ $job->title }}
            </h2>
            <a href="{{ route('recruiter.jobs') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux offres
            </a>
        </div>
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
                    <h3 class="mb-6 text-lg font-medium text-gray-900">Informations sur l'offre</h3>
                    <div class="p-4 mb-6 bg-gray-50 rounded-md">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Titre</p>
                                <p class="text-base font-semibold">{{ $job->title }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Localisation</p>
                                <p class="text-base">{{ $job->location->city}}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Type de contrat</p>
                                <p class="text-base">{{ $job->employment_type }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Candidatures reçues</p>
                                <p class="text-base font-semibold">{{ $applications->total() }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date de publication</p>
                                <p class="text-base">{{ $job->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date limite</p>
                                <p class="text-base">{{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') : 'Non spécifiée' }}</p>
                            </div>
                        </div>
                    </div>

                    <h3 class="mb-4 text-lg font-medium text-gray-900">Candidatures</h3>

                    @if($applications->count() > 0)
                        <div class="overflow-hidden border border-gray-200 rounded-md">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Candidat
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date de candidature
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
                                    @foreach($applications as $application)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if($application->user->candidateProfile && $application->user->candidateProfile->avatar)
                                                            <img class="h-10 w-10 rounded-full" src="{{ Storage::url($application->user->candidateProfile->avatar) }}" alt="{{ $application->user->name }}">
                                                        @else
                                                            <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-500">
                                                                <span class="text-lg font-medium">{{ substr($application->user->name, 0, 1) }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $application->user->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $application->user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $application->created_at->format('d/m/Y H:i') }}</div>
                                                <div class="text-sm text-gray-500">{{ $application->created_at->diffForHumans() }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @switch($application->status)
                                                    @case('pending')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            En attente
                                                        </span>
                                                        @break
                                                    @case('reviewed')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            Examinée
                                                        </span>
                                                        @break
                                                    @case('interview')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                            Entretien
                                                        </span>
                                                        @break
                                                    @case('offered')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Offre proposée
                                                        </span>
                                                        @break
                                                    @case('rejected')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Refusée
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                            {{ $application->status }}
                                                        </span>
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="#" class="text-emerald-600 hover:text-emerald-900">Voir</a>
                                                    
                                                    <form action="{{ route('recruiter.application.updateStatus', $application->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="reviewed">
                                                        <button type="submit" class="text-blue-600 hover:text-blue-900">Marquer comme examinée</button>
                                                    </form>
                                                    
                                                    <button type="button" class="text-purple-600 hover:text-purple-900" onclick="openInterviewModal('{{ $application->user_id }}')">Planifier un entretien</button>
                                                    <form action="{{ route('recruiter.application.updateStatus', $application->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Rejeter</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $applications->links() }}
                        </div>
                    @else
                        <div class="p-4 text-center text-gray-500 bg-gray-50 rounded-md">
                            <p class="mb-2 text-lg font-medium">Aucune candidature pour cette offre pour le moment</p>
                            <p>Les candidatures apparaîtront ici une fois que des candidats auront postulé.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de planification d'entretien -->
    <div id="interview-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Planifier un entretien</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeInterviewModal()">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form id="interview-form" action="{{ route('recruiter.scheduleInterview') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="modal-user-id">
                    <input type="hidden" name="job_offer_id" value="{{ $job->id }}">
                    
                    <div class="mb-4">
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-1">
                            Date et heure de l'entretien <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" id="scheduled_at" name="scheduled_at" 
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-1">
                            Durée (minutes) <span class="text-red-500">*</span>
                        </label>
                        <select id="duration_minutes" name="duration_minutes" 
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                            <option value="30">30 minutes</option>
                            <option value="45">45 minutes</option>
                            <option value="60" selected>1 heure</option>
                            <option value="90">1 heure 30</option>
                            <option value="120">2 heures</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="interview_type" class="block text-sm font-medium text-gray-700 mb-1">
                            Type d'entretien <span class="text-red-500">*</span>
                        </label>
                        <select id="interview_type" name="interview_type" 
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500" required
                            onchange="toggleLocationFields()">
                            <option value="video">Entretien vidéo</option>
                            <option value="phone">Entretien téléphonique</option>
                            <option value="in-person">Entretien en personne</option>
                        </select>
                    </div>
                    
                    <div id="meeting-link-field" class="mb-4">
                        <label for="meeting_link" class="block text-sm font-medium text-gray-700 mb-1">
                            Lien de la réunion <span class="text-red-500">*</span>
                        </label>
                        <input type="url" id="meeting_link" name="meeting_link" 
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="https://meet.google.com/..." required>
                    </div>
                    
                    <div id="location-field" class="mb-4 hidden">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                            Adresse <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="location" name="location" 
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                            Notes pour le candidat
                        </label>
                        <textarea id="notes" name="notes" rows="3" 
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Précisions sur l'entretien, préparation recommandée, etc."></textarea>
                    </div>
                    
                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                            onclick="closeInterviewModal()">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-md shadow-sm hover:bg-emerald-700">
                            Planifier l'entretien
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openInterviewModal(applicationId) {
            document.getElementById('modal-user-id').value = applicationId;
            document.getElementById('interview-modal').classList.remove('hidden');
            toggleLocationFields();
        }
        
        function closeInterviewModal() {
            document.getElementById('interview-modal').classList.add('hidden');
        }
        
        function toggleLocationFields() {
            const interviewType = document.getElementById('interview_type').value;
            const meetingLinkField = document.getElementById('meeting-link-field');
            const locationField = document.getElementById('location-field');
            
            if (interviewType === 'video') {
                meetingLinkField.classList.remove('hidden');
                locationField.classList.add('hidden');
                document.getElementById('meeting_link').required = true;
                document.getElementById('location').required = false;
            } else if (interviewType === 'in-person') {
                meetingLinkField.classList.add('hidden');
                locationField.classList.remove('hidden');
                document.getElementById('meeting_link').required = false;
                document.getElementById('location').required = true;
            } else {
                meetingLinkField.classList.add('hidden');
                locationField.classList.add('hidden');
                document.getElementById('meeting_link').required = false;
                document.getElementById('location').required = false;
            }
        }
    </script>
</x-app-layout>