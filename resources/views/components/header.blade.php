<header class="bg-black/80 text-white p-4">
    <div class="container mx-auto flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="bg-white rounded p-1">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 7H4V19H20V7Z" fill="black" />
                    <path d="M15 3H9V7H15V3Z" fill="black" />
                </svg>
            </div>
            <span class="font-bold">JobNow</span>
        </div>
        
        <nav class="hidden md:flex items-center gap-6">
            <a href="{{ route('home') }}" class="text-white hover:text-gray-300">Home</a>
            <a href="{{ route('jobs.index') }}" class="text-white hover:text-gray-300">Jobs</a>
            <a href="{{ route('about') }}" class="text-white hover:text-gray-300">About Us</a>
            <a href="{{ route('contact') }}" class="text-white hover:text-gray-300">Contact Us</a>
        </nav>
        
        <div class="flex items-center gap-2">
            @guest
                <a href="{{ route('login') }}" class="text-white hover:text-gray-300">Login</a>
                <a href="{{ route('register') }}" class="bg-emerald-500 text-white px-4 py-1.5 rounded-md text-sm hover:bg-emerald-600">Register</a>
            @else
                @if(auth()->user()->isRecruiter())
                    <a href="{{ route('jobs.create') }}" class="bg-emerald-500 text-white px-4 py-1.5 rounded-md text-sm hover:bg-emerald-600 mr-4">
                        Publier une offre
                    </a>
                @endif
                <div class="relative">
                    <button class="flex items-center gap-2 text-white">
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full border">
                        <span>{{ auth()->user()->name }}</span>
                    </button>
                </div>
            @endguest
        </div>
    </div>
</header>