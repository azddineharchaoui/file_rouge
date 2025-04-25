<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('My Applications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($applications->count())
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 text-left">Job Title</th>
                                        <th class="px-4 py-2 text-left">Company</th>
                                        <th class="px-4 py-2 text-left">Applied Date</th>
                                        <th class="px-4 py-2 text-left">Status</th>
                                        <th class="px-4 py-2 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $application->job->title }}</td>
                                        <td class="px-4 py-2">{{ $application->jobOffer->company->company_name ?? 'Entreprise' }}</td>                                        <td class="px-4 py-2">{{ $application->created_at->format('M d, Y') }}</td>
                                        <td class="px-4 py-2">
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
                                        </td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('jobs.show', $application->job->id) }}" class="text-blue-500 hover:underline">View Job</a>
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
                        <p class="text-gray-500">You haven't applied to any jobs yet.</p>
                        <a href="{{ route('jobs.index') }}" class="inline-block px-4 py-2 mt-4 text-white bg-blue-500 rounded hover:bg-blue-600">
                            Browse Jobs
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>