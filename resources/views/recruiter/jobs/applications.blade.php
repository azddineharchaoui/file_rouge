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
                                <p class="text-xs font-medium text-gray-500 mb-1">Vues totales</p>
                                <p class="text-sm flex items-center">
                                    <svg class="w-4 h-4 text-gray-500 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ $job->views ?? 0 }}
                                </p>
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
                                                    <a href="#" class="text-emerald-600 hover:text-emerald-900" 
                                                       onclick="openCandidateModal('{{ $application->user->name }}', '{{ $application->user->email }}', '{{ $application->user->candidateProfile->phone ?? 'Non renseigné' }}', '{{ $application->created_at->format('d/m/Y') }}', '{{ $application->user->id }}')">
                                                        <span class="sr-only">Voir détails</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" title="Voir détails">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    
                                                    
                                                    
                                                    <form action="{{ route('recruiter.application.updateStatus', $application->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="reviewed">
                                                        <button type="submit" class="text-blue-600 hover:text-blue-900">
                                                            <span class="sr-only">Marquer comme examinée</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" title="Marquer comme examinée">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    
                                                    <button type="button" class="text-purple-600 hover:text-purple-900" onclick="openInterviewModal('{{ $application->id }}')">
                                                        <span class="sr-only">Planifier un entretien</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" title="Planifier un entretien">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                    </button>

                                                    <form action="{{ route('recruiter.application.updateStatus', $application->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <span class="sr-only">Rejeter</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" title="Rejeter">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
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
                    <input type="hidden" name="application_id" id="modal-application-id">
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
    
    <!-- Modal pour afficher les détails du candidat -->
    <div id="candidate-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Détails du candidat</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeCandidateModal()">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="mb-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nom</p>
                            <p id="candidate-name" class="text-base"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date de candidature</p>
                            <p id="application-date" class="text-base"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p id="candidate-email" class="text-base"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Téléphone</p>
                            <p id="candidate-phone" class="text-base"></p>
                        </div>
                    </div>
                </div>
                
                <!-- Nouvelle section pour les compétences -->
                <div class="mb-5">
                    <p class="text-sm font-medium text-gray-500 mb-2">Compétences</p>
                    <div id="candidate-skills" class="flex flex-wrap gap-2">
                        <!-- Les compétences seront ajoutées ici dynamiquement -->
                    </div>
                </div>
                
                <div class="flex justify-end mt-6 space-x-3">
                    <a id="view-resume-link" href="#" target="_blank" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                        Consulter le CV
                    </a>
                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50" onclick="closeCandidateModal()">
                        Fermer
                    </button>
                </div>
                
                <div id="cv-not-available" class="hidden mt-4 p-3 bg-yellow-50 text-yellow-800 rounded-md text-sm">
                    Note: Si le CV n'apparaît pas, le candidat n'a peut-être pas téléversé de CV valide ou le fichier a été déplacé.
                </div>
            </div>
        </div>
    </div>

    <script>
        function openInterviewModal(applicationId) {
            document.getElementById('modal-application-id').value = applicationId;
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
                document.getElementById('location').required = true;
                document.getElementById('meeting_link').required = false;
            } else {
                meetingLinkField.classList.add('hidden');
                locationField.classList.add('hidden');
                document.getElementById('meeting_link').required = false;
                document.getElementById('location').required = false;
            }
        }
        
        function openCandidateModal(name, email, phone, date, userId) {
            document.getElementById('candidate-name').textContent = name;
            document.getElementById('candidate-email').textContent = email;
            document.getElementById('candidate-phone').textContent = phone;
            document.getElementById('application-date').textContent = date;
            
            // Set the link to view resume
            document.getElementById('view-resume-link').href = `/recruiter/applications/resume-by-user/${userId}`;
            
            // Récupérer les compétences du candidat
            fetch(`/recruiter/applications/candidate-skills/${userId}`)
                .then(response => response.json())
                .then(data => {
                    const skillsContainer = document.getElementById('candidate-skills');
                    skillsContainer.innerHTML = '';
                    
                    if (data.skills && data.skills.length > 0) {
                        data.skills.forEach(skill => {
                            const skillBadge = document.createElement('span');
                            skillBadge.className = 'px-2 py-1 text-xs font-medium bg-emerald-100 text-emerald-800 rounded-full';
                            skillBadge.textContent = skill;
                            skillsContainer.appendChild(skillBadge);
                        });
                    } else {
                        const noSkills = document.createElement('p');
                        noSkills.className = 'text-sm text-gray-500 italic';
                        noSkills.textContent = 'Aucune compétence renseignée';
                        skillsContainer.appendChild(noSkills);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des compétences:', error);
                    const skillsContainer = document.getElementById('candidate-skills');
                    skillsContainer.innerHTML = '<p class="text-sm text-gray-500 italic">Impossible de charger les compétences</p>';
                });
            
            // Vérifier si le CV est disponible
            fetch(`/recruiter/applications/check-resume/${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.resumeExists) {
                        document.getElementById('cv-not-available').classList.remove('hidden');
                    } else {
                        document.getElementById('cv-not-available').classList.add('hidden');
                    }
                })
                .catch(() => {
                    // En cas d'erreur, afficher le message d'avertissement
                    document.getElementById('cv-not-available').classList.remove('hidden');
                });
            
            document.getElementById('candidate-modal').classList.remove('hidden');
        }
        
        function closeCandidateModal() {
            document.getElementById('candidate-modal').classList.add('hidden');
        }
    </script>
</x-app-layout>