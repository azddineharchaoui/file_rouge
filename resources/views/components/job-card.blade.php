@props(['job'])

<div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex gap-4">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center">
                <div class="w-8 h-8 overflow-hidden rounded-full">
                    <img src="{{ $job->company->logo }}" alt="{{ $job->company->company_name }}" class="w-full h-full object-cover">
                </div>
            </div>
            <div>
                <h3 class="font-bold text-lg">{{ $job->title }}</h3>
                <p class="text-gray-500">{{ $job->company->company_name }}</p>
                <div class="flex flex-wrap gap-4 mt-2">
                    <div class="flex items-center gap-1 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        <span>{{ $job->category->name ?? 'Catégorie non spécifiée' }}</span>
                    </div>
                    <div class="flex items-center gap-1 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>{{ $job->formatted_employment_type }}</span>
                    </div>
                    <div class="flex items-center gap-1 text-gray-500">
                        <span class="text-emerald-500">$</span>
                        <span>{{ $job->salary_range }}</span>
                    </div>
                    <div class="flex items-center gap-1 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>{{ $job->location->name ?? 'Lieu non spécifié' }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-xs text-emerald-500">{{ $job->created_at->diffForHumans() }}</span>
            <a href="{{ route('jobs.show', $job->id) }}" class="bg-emerald-500 text-white px-4 py-1.5 rounded text-sm hover:bg-emerald-600">Job Details</a>
        </div>
    </div>
</div>