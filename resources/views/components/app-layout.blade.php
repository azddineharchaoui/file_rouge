<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JobNow') }} - {{ $title ?? 'Find your dream job' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .dropdown {
            position: relative;
        }
        
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            width: 200px;
            background-color: white;
            border-radius: 0.375rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 0.5rem 0;
            z-index: 50;
            margin-top: 0.5rem;
            transition: opacity 0.15s ease-in-out;
        }
        
        .dropdown.active .dropdown-menu {
            display: block;
        }
        
        .dropdown-item {
            display: block;
            padding: 0.5rem 1rem;
            color: #4b5563;
            font-size: 0.875rem;
        }
        
        .dropdown-item:hover {
            background-color: #ecfdf5;
        }
    </style>
</head>
<body class="font-sans antialiased flex flex-col min-h-screen">
    <!-- Navigation Bar -->
    <header class="bg-emerald-900 text-white p-4">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="bg-white rounded p-1">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 7H4V19H20V7Z" fill="black" />
                        <path d="M15 3H9V7H15V3Z" fill="black" />
                    </svg>
                </div>
                <a href="{{ route('home') }}" class="font-bold text-xl">JobNow</a>
            </div>
            
            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-white hover:text-emerald-200">Home</a>
                <a href="{{ route('jobs.index') }}" class="text-white hover:text-emerald-200">Jobs</a>
                <a href="{{ route('about') }}" class="text-white hover:text-emerald-200">About</a>
                <a href="{{ route('contact') }}" class="text-white hover:text-emerald-200">Contact</a>
            </nav>
            
            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}" class="text-white hover:text-emerald-200">Login</a>
                    <div class="dropdown">
                        <button class="dropdown-toggle bg-emerald-500 text-white px-4 py-2 rounded-md text-sm hover:bg-emerald-600 transition flex items-center gap-1">
                            Register
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('register.candidate') }}" class="dropdown-item">Register as Candidate</a>
                            <a href="{{ route('register.recruiter') }}" class="dropdown-item">Register as Recruiter</a>
                        </div>
                    </div>
                @else
                    <div class="dropdown">
                        <button class="dropdown-toggle flex items-center gap-2 text-white">
                            @if(auth()->user()->candidateProfile && auth()->user()->candidateProfile->profile_picture)
                                <img src="{{ Storage::url(auth()->user()->candidateProfile->profile_picture) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover border border-white">
                            @else
                                <div class="w-8 h-8 rounded-full bg-emerald-600 flex items-center justify-center text-white">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <span>{{ auth()->user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('profile.show') }}" class="dropdown-item">Profile</a>
                            <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                            @if(auth()->user()->role === 'candidate')
                                <a href="{{ route('candidate.applications') }}" class="dropdown-item">My Applications</a>
                            @elseif(auth()->user()->role === 'recruiter')
                                <a href="{{ route('recruiter.jobs') }}" class="dropdown-item">Manage Jobs</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item w-full text-left">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <x-footer />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = document.querySelectorAll('.dropdown');
            
            dropdowns.forEach(dropdown => {
                const toggleButton = dropdown.querySelector('.dropdown-toggle');
                
                toggleButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdown.classList.toggle('active');
                    
                    dropdowns.forEach(otherDropdown => {
                        if (otherDropdown !== dropdown && otherDropdown.classList.contains('active')) {
                            otherDropdown.classList.remove('active');
                        }
                    });
                });
                
                const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                if (dropdownMenu) {
                    dropdownMenu.addEventListener('click', (e) => {
                        e.stopPropagation();
                    });
                }
            });
            
            document.addEventListener('click', () => {
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            });
        });
    </script>
</body>
</html>