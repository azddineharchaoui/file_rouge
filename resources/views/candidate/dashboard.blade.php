<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Candidate Dashboard') }}
        </h2>
    </x-slot>

    <!-- Ajout de SweetAlert directement dans cette page -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-4">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 p-3 mr-4 text-white bg-blue-500 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Applications</div>
                            <div class="text-2xl font-semibold">{{ $applicationStats['total'] }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 p-3 mr-4 text-white bg-green-500 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Interviews</div>
                            <div class="text-2xl font-semibold">{{ $applicationStats['interview'] }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 p-3 mr-4 text-white bg-purple-500 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Offers</div>
                            <div class="text-2xl font-semibold">{{ $applicationStats['offered'] }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 p-3 mr-4 text-white bg-indigo-500 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Success Rate</div>
                            <div class="text-2xl font-semibold">{{ $successRate }}%</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <!-- Recent Applications -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-lg font-semibold">Recent Applications</h3>
                        <a href="{{ route('candidate.applications') }}" class="text-sm text-blue-500 hover:underline">View All</a>
                    </div>
                    <div class="p-4">
                        @if(count($applications) > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($applications as $application)
                                <li class="py-3">
                                    <div>
                                        <div class="flex justify-between">
                                            <p class="font-medium">{{ $application->job->title }}</p>
                                            <span class="text-sm text-gray-500">{{ $application->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600">{{ $application->jobOffer->company->company_name ?? 'Entreprise' }} • {{ $application->jobOffer->location->name ?? $application->jobOffer->location ?? 'Lieu non spécifié' }}</p>                                        
                                        <div class="mt-1">
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
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">You haven't applied to any jobs yet.</p>
                            <a href="{{ route('jobs.index') }}" class="inline-block px-4 py-2 mt-3 text-white bg-blue-500 rounded hover:bg-blue-600">Browse Jobs</a>
                        @endif
                    </div>
                </div>

                <!-- Upcoming Interviews -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-lg font-semibold">Upcoming Interviews</h3>
                        <a href="{{ route('candidate.interviews') }}" class="text-sm text-blue-500 hover:underline">View All</a>
                    </div>
                    <div class="p-4">
                        @if(count($interviews) > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($interviews as $interview)
                                <li class="py-3">
                                    <div>
                                        <div class="flex justify-between">
                                            <p class="font-medium">{{ $interview->job->title }}</p>
                                            <span class="text-sm text-gray-500">{{ $interview->scheduled_at->format('M d, Y - h:i A') }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600">{{ $interview->job->company->name }}</p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-semibold">Type:</span> {{ ucfirst($interview->interview_type) }} • 
                                            <span class="font-semibold">Duration:</span> {{ $interview->duration_minutes }} minutes
                                        </p>
                                        <div class="mt-1">
                                            <span class="px-2 py-1 text-xs text-white rounded
                                                @if($interview->status == 'scheduled') bg-yellow-500
                                                @elseif($interview->status == 'confirmed') bg-green-500
                                                @elseif($interview->status == 'completed') bg-blue-500
                                                @elseif($interview->status == 'no-show') bg-red-500
                                                @elseif($interview->status == 'canceled') bg-gray-500
                                                @elseif($interview->status == 'reschedule_requested') bg-purple-500
                                                @endif
                                            ">
                                                {{ ucfirst(str_replace('_', ' ', $interview->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">No upcoming interviews scheduled.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>