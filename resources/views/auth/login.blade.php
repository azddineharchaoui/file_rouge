<x-app-layout>
    <x-slot name="title">Connexion</x-slot>
    
    <section class="container mx-auto px-4 py-12">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Connexion</h2>

            @if (session('status'))
                <div class="mb-4 text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Adresse email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Mot de passe</label>
                    <input id="password" type="password" name="password" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 flex items-center">
                    <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-emerald-500 focus:ring-emerald-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 text-gray-700">Se souvenir de moi</label>
                </div>

                <div>
                    <button type="submit" class="w-full bg-emerald-500 text-white px-6 py-3 rounded-md hover:bg-emerald-600 transition">
                        Connexion
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('password.request') }}" class="text-emerald-500 hover:underline">Mot de passe oublié?</a>
            </div>
            
            <div class="mt-6 text-center">
                <p class="text-gray-600">Pas encore de compte?</p>
                <div class="mt-3 flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('register.candidate') }}" class="inline-block px-6 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 transition">
                        S'inscrire comme candidat
                    </a>
                    <a href="{{ route('register.recruiter') }}" class="inline-block px-6 py-2 bg-white text-emerald-500 border border-emerald-500 rounded-md hover:bg-emerald-50 transition">
                        S'inscrire comme recruteur
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>