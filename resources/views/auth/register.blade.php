<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JobNow - Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen bg-gray-100">
    <header class="bg-emerald-900 text-white p-4">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="bg-white rounded p-1">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 7H4V19H20V7Z" fill="black" />
                        <path d="M15 3H9V7H15V3Z" fill="black" />
                    </svg>
                </div>
                <span class="font-bold text-xl">JobNow</span>
            </div>
            <div>
                <a href="{{ route('login') }}" class="bg-emerald-500 text-white px-4 py-2 rounded-md text-sm hover:bg-emerald-600 transition">Login</a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <section class="container mx-auto px-4 py-12">
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Register</h2>

                @if (session('status'))
                    <div class="mb-4 text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                        <input id="password" type="password" name="password" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-gray-700 font-medium mb-2">Register as</label>
                        <select id="role" name="role" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('role') border-red-500 @enderror">
                            <option value="candidate" {{ old('role') == 'candidate' ? 'selected' : '' }}>Candidate</option>
                            <option value="recruiter" {{ old('role') == 'recruiter' ? 'selected' : '' }}>Recruiter</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 hidden" id="company_name_field">
                        <label for="company_name" class="block text-gray-700 font-medium mb-2">Company Name</label>
                        <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('company_name') border-red-500 @enderror">
                        @error('company_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="w-full bg-emerald-500 text-white px-6 py-3 rounded-md hover:bg-emerald-600 transition">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer class="bg-gray-100 pt-6 pb-6">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            © {{ date('Y') }} JobNow. All rights reserved.
        </div>
    </footer>

    <script>
        document.getElementById('role').addEventListener('change', function () {
            const companyNameField = document.getElementById('company_name_field');
            companyNameField.classList.toggle('hidden', this.value !== 'recruiter');
        });
    </script>
</body>
</html>