<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Company Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-3">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 p-3 mr-4 text-white bg-blue-500 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Active Jobs</div>
                            <div class="text-2xl font-semibold">{{ $jobs->where('is_active', true)->count() }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 p-3 mr-4 text-white bg-green-500 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Total Applications</div>
                            <div class="text-2xl font-semibold">{{ $jobs->sum('applications_count') }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 p-3 mr-4 text-white bg-purple-500 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Interviews Scheduled</div>
                            <div class="text-2xl font-semibold">{{ $jobs->flatMap->applications->where('status', 'interview')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <!-- Recent Jobs -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-lg font-semibold">Offres d'emploi récentes</h3>
                        <a href="{{ route('recruiter.jobs') }}" class="text-sm text-blue-500 hover:underline">Voir tout</a>
                    </div>
                    <div class="p-4">
                        @if($jobs->count())
                            <ul class="divide-y divide-gray-200">
                                @foreach($jobs->take(5) as $job)
                                <li class="py-3">
                                    <div class="flex justify-between">
                                        <div>
                                            <p class="font-medium">{{ $job->title }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $job->location->name ?? 'Emplacement non spécifié' }} • 
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
                                            </p>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <span class="px-2 py-1 mb-2 text-xs text-white bg-blue-500 rounded-full">{{ $job->applications_count }} Candidature(s)</span>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('recruiter.jobs.applications', $job->id) }}" class="text-xs text-blue-600 hover:text-blue-900">Voir candidatures</a>
                                                <a href="{{ route('recruiter.jobs.edit', $job->id) }}" class="text-xs text-emerald-600 hover:text-emerald-900">Modifier</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Aucune offre publiée pour le moment.</p>
                            <a href="{{ route('recruiter.jobs.create') }}" class="inline-block px-4 py-2 mt-3 text-white bg-emerald-500 rounded hover:bg-emerald-600">
                                Publier une offre
                            </a>
                        @endif
                    </div>
                </div>
                <!-- Recent Applications -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-lg font-semibold">Candidatures récentes</h3>
                    </div>
                    <div class="p-4">
                        @if($recentApplications->count())
                            <ul class="divide-y divide-gray-200">
                                @foreach($recentApplications as $application)
                                <li class="py-3">
                                    <div class="mb-2">
                                        <div class="flex justify-between">
                                            <p class="font-medium">{{ optional($application->candidateProfile->user)->name ?? 'Candidat' }}</p>
                                            <span class="text-sm text-gray-500">{{ $application->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600">
                                            Pour: {{ optional($application->jobOffer)->title ?? 'Offre non disponible' }}
                                        </p>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="px-2 py-1 text-xs text-white rounded
                                            @if($application->status == 'pending') bg-yellow-500
                                            @elseif($application->status == 'reviewed') bg-blue-500
                                            @elseif($application->status == 'shortlisted') bg-purple-500
                                            @elseif($application->status == 'interview') bg-indigo-500
                                            @elseif($application->status == 'offered') bg-green-500
                                            @elseif($application->status == 'hired') bg-green-700
                                            @elseif($application->status == 'rejected') bg-red-500
                                            @endif
                                        ">
                                            @switch($application->status)
                                                @case('pending')
                                                    En attente
                                                    @break
                                                @case('reviewed')
                                                    Examinée
                                                    @break
                                                @case('interview')
                                                    Entretien
                                                    @break
                                                @case('offered')
                                                    Offre proposée
                                                    @break
                                                @case('rejected')
                                                    Refusée
                                                    @break
                                                @default
                                                    {{ ucfirst($application->status) }}
                                            @endswitch
                                        </span>
                                        <div class="flex space-x-2">
                                            <button onclick="openStatusModal({{ $application->id }}, '{{ $application->status }}')" class="text-xs text-blue-600 hover:underline">Changer statut</button>
                                            <button onclick="openInterviewModal({{ $application->id }})" class="text-xs text-purple-600 hover:underline">Planifier entretien</button>
                                            <a href="{{ route('recruiter.jobs.applications', $application->jobOffer->id) }}" class="text-xs text-emerald-600 hover:underline">Détails</a>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Aucune candidature pour le moment.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 mt-8">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-lg font-semibold">Entretiens à venir</h3>
                        <a href="{{ route('recruiter.interviews') }}" class="text-sm text-blue-500 hover:underline">Voir tout</a>
                    </div>
                    <div class="p-4">
                        @if($upcomingInterviews->count())
                            <ul class="divide-y divide-gray-200">
                                @foreach($upcomingInterviews as $interview)
                                <li class="py-4">
                                    <div class="flex justify-between mb-2">
                                        <div>
                                            <h4 class="font-medium text-gray-900">
                                                {{ $interview->jobOffer->title }}
                                            </h4>
                                            <p class="text-sm text-gray-600">
                                                Candidat: {{ optional($interview->user)->name ?? 'Candidat' }}
                                            </p>
                                        </div>
                                        <span class="px-2 py-1 text-xs text-white rounded-full
                                            @if($interview->status == 'scheduled') bg-yellow-500
                                            @elseif($interview->status == 'confirmed') bg-green-500
                                            @elseif($interview->status == 'reschedule_requested') bg-purple-500
                                            @else bg-gray-500
                                            @endif
                                        ">
                                            @switch($interview->status)
                                                @case('scheduled')
                                                    En attente de confirmation
                                                    @break
                                                @case('confirmed')
                                                    Confirmé
                                                    @break
                                                @case('reschedule_requested')
                                                    Report demandé
                                                    @break
                                                @default
                                                    {{ ucfirst($interview->status) }}
                                            @endswitch
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 rounded-md p-3">
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 mb-1">Date et heure</p>
                                            <p class="text-sm flex items-center">
                                                <svg class="w-4 h-4 text-emerald-500 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $interview->scheduled_at->format('d/m/Y à H:i') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 mb-1">Type</p>
                                            <p class="text-sm flex items-center">
                                                @if($interview->interview_type == 'video')
                                                    <svg class="w-4 h-4 text-emerald-500 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                    Vidéo
                                                @elseif($interview->interview_type == 'phone')
                                                    <svg class="w-4 h-4 text-emerald-500 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                    </svg>
                                                    Téléphone
                                                @else
                                                    <svg class="w-4 h-4 text-emerald-500 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    En personne
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 mb-1">Durée</p>
                                            <p class="text-sm">{{ $interview->duration_minutes }} minutes</p>
                                        </div>
                                        <div>
                                            @if($interview->interview_type == 'video' && $interview->meeting_link)
                                                <p class="text-xs font-medium text-gray-500 mb-1">Lien de réunion</p>
                                                <a href="{{ $interview->meeting_link }}" target="_blank" class="text-sm text-blue-600 hover:underline flex items-center">
                                                    <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                    </svg>
                                                    Rejoindre
                                                </a>
                                            @elseif($interview->interview_type == 'in-person' && $interview->location)
                                                <p class="text-xs font-medium text-gray-500 mb-1">Lieu</p>
                                                <p class="text-sm">{{ $interview->location }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Aucun entretien planifié pour le moment.</p>
                            <p class="text-sm text-gray-400 mt-2">Planifiez des entretiens avec les candidats depuis la page des candidatures.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour changer le statut -->
<div id="status-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Changer le statut de la candidature</h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeStatusModal()">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form id="status-form" action="{{ route('recruiter.application.updateStatus', 0) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="application_id" id="status-application-id">
                
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Nouveau statut <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" 
                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                        <option value="pending">En attente</option>
                        <option value="reviewed">Examinée</option>
                        <option value="interview">Entretien</option>
                        <option value="offered">Offre proposée</option>
                        <option value="rejected">Refusée</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="recruiter_notes" class="block text-sm font-medium text-gray-700 mb-1">
                        Notes (optionnel)
                    </label>
                    <textarea id="recruiter_notes" name="recruiter_notes" rows="3" 
                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Notez ici vos observations concernant cette candidature..."></textarea>
                </div>
                
                <div class="flex justify-end mt-6 space-x-3">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                        onclick="closeStatusModal()">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-md shadow-sm hover:bg-emerald-700">
                        Mettre à jour
                    </button>
                </div>
            </form>
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
                <input type="hidden" name="application_id" id="interview-application-id">
                
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
    function openStatusModal(applicationId, currentStatus) {
        document.getElementById('status-application-id').value = applicationId;
        document.getElementById('status').value = currentStatus;
        document.getElementById('status-form').action = `/recruiter/applications/${applicationId}/status`;
        document.getElementById('status-modal').classList.remove('hidden');
    }
    
    function closeStatusModal() {
        document.getElementById('status-modal').classList.add('hidden');
    }
    
    function openInterviewModal(applicationId) {
        document.getElementById('interview-application-id').value = applicationId;
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