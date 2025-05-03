<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('Recruiter Registration') }}</h1>
        <p class="mt-2 text-gray-600">{{ __('Create an account to post jobs and find candidates') }}</p>
    </div>

    <form method="POST" action="{{ route('register.recruiter') }}" enctype="multipart/form-data">
        @csrf

        <!-- Personal Information -->
        <div class="p-4 mb-6 border rounded-lg border-gray-200">
            <h2 class="mb-4 text-xl font-semibold">{{ __('Personal Information') }}</h2>
            
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Company Information -->
        <div class="p-4 mb-6 border rounded-lg border-gray-200">
            <h2 class="mb-4 text-xl font-semibold">{{ __('Company Information') }}</h2>
            
            <!-- Company Name -->
            <div>
                <x-input-label for="company_name" :value="__('Company Name')" />
                <x-text-input id="company_name" class="block w-full mt-1" type="text" name="company_name" :value="old('company_name')" required />
                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
            </div>

            <!-- Company Website -->
            <div class="mt-4">
                <x-input-label for="company_website" :value="__('Company Website')" />
                <x-text-input id="company_website" class="block w-full mt-1" type="url" name="company_website" :value="old('company_website')" />
                <x-input-error :messages="$errors->get('company_website')" class="mt-2" />
            </div>

            <!-- Company Description -->
            <div class="mt-4">
                <x-input-label for="company_description" :value="__('Company Description')" />
                <textarea id="company_description" name="company_description" rows="4" 
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('company_description') }}</textarea>
                <x-input-error :messages="$errors->get('company_description')" class="mt-2" />
            </div>

            <!-- Company Logo -->
            <div class="mt-4">
                <x-input-label for="company_logo" :value="__('Company Logo')" />
                <input id="company_logo" name="company_logo" type="file" accept="image/*" 
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                <p class="mt-1 text-sm text-gray-500">Recommended: Square image, at least 200x200 pixels</p>
                <x-input-error :messages="$errors->get('company_logo')" class="mt-2" />
            </div>
        </div>

        

        <div class="flex items-center justify-end mt-6">
            <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                {{ __('Looking for a job?') }}
                <a href="{{ route('register.candidate') }}" class="text-blue-600 hover:underline">
                    {{ __('Register as a candidate instead') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>