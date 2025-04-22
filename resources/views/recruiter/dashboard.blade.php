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
                        <h3 class="text-lg font-semibold">Recent Jobs</h3>
                        <a href="{{ route('recruiter.jobs') }}" class="text-sm text-blue-500 hover:underline">View All</a>
                    </div>
                    <div class="p-4">
                        @if($jobs->count())
                            <ul class="divide-y divide-gray-200">
                                @foreach($jobs->take(5) as $job)
                                <li class="py-3">
                                    <div class="flex justify-between">
                                        <div>
                                            <p class="font-medium">{{ $job->title }}</p>
                                            <p class="text-sm text-gray-500">{{ $job->location }} • {{ $job->type }}</p>
                                        </div>
                                        <div class="text-sm">
                                            <span class="px-2 py-1 text-white bg-blue-500 rounded-full">{{ $job->applications_count }} Applications</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">No jobs posted yet.</p>
                            <a href="{{ route('recruiter.jobs.create') }}" class="inline-block px-4 py-2 mt-3 text-white bg-blue-500 rounded hover:bg-blue-600">
                                Post a Job
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Recent Applications -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-lg font-semibold">Recent Applications</h3>
                    </div>
                    <div class="p-4">
                        @if($recentApplications->count())
                            <ul class="divide-y divide-gray-200">
                                @foreach($recentApplications as $application)
                                <li class="py-3">
                                    <div>
                                        <div class="flex justify-between">
                                            <p class="font-medium">{{ $application->user->name }}</p>
                                            <span class="text-sm text-gray-500">{{ $application->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600">Applied for: {{ $application->job->title }}</p>
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
                            <p class="text-gray-500">No applications yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>