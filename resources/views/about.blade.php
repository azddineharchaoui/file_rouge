<x-app-layout>
    <x-slot name="title">À propos de nous</x-slot>

    <!-- Hero Section -->
    <section class="bg-emerald-900 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-4">À propos de JobNow</h1>
                <p class="text-xl">Notre mission est de connecter les talents avec les meilleures opportunités professionnelles.</p>
            </div>
        </div>
    </section>

    <!-- Notre Histoire Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Notre Histoire</h2>
                    <p class="text-gray-600 mb-4">
                        Fondée en 2020, JobNow est née d'une vision simple : révolutionner la façon dont les recruteurs et les candidats se connectent. Nous avons identifié les défis du recrutement traditionnel et avons créé une plateforme qui simplifie et optimise ce processus.
                    </p>
                    <p class="text-gray-600">
                        Aujourd'hui, JobNow est fier de faciliter des milliers de connexions professionnelles chaque jour, contribuant ainsi à façonner des carrières épanouissantes et à aider les entreprises à se développer avec les bonnes personnes à bord.
                    </p>
                </div>
                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ asset('images/about/team-office.jpg') }}" alt="L'équipe JobNow" class="w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    <!-- Notre Mission Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Notre Mission</h2>
                <p class="text-gray-600 text-lg">
                    Nous sommes déterminés à créer un marché du travail plus efficient, équitable et accessible pour tous.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg p-8 shadow-sm hover:shadow-md transition">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Innovation</h3>
                    <p class="text-gray-600 text-center">
                        Nous exploitons la technologie avancée pour créer des solutions innovantes qui répondent aux défis du recrutement moderne.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg p-8 shadow-sm hover:shadow-md transition">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Communauté</h3>
                    <p class="text-gray-600 text-center">
                        Nous construisons une communauté inclusive où professionnels et entreprises peuvent se connecter, apprendre et grandir ensemble.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg p-8 shadow-sm hover:shadow-md transition">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Confiance</h3>
                    <p class="text-gray-600 text-center">
                        Nous privilégions la transparence, l'intégrité et la sécurité dans toutes nos interactions pour créer un environnement de confiance.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Notre Équipe Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Notre Équipe</h2>
                <p class="text-gray-600 text-lg">
                    Des professionnels passionnés qui travaillent chaque jour pour rendre le recrutement plus efficace et humain.
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <!-- Team Member 1 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                    <div class="aspect-w-1 aspect-h-1">
                        <img src="{{ asset('images/about/team-1.jpg') }}" alt="Jean Claude" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="font-bold text-lg text-gray-800">Jean Claude</h3>
                        <p class="text-emerald-600">Fondateur & CEO</p>
                        <div class="flex justify-center mt-4 space-x-3">
                            <a href="#" class="text-gray-400 hover:text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 2 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                    <div class="aspect-w-1 aspect-h-1">
                        <img src="{{ asset('images/about/team-2.jpg') }}" alt="Thomas Bernard" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="font-bold text-lg text-gray-800">Thomas Bernard</h3>
                        <p class="text-emerald-600">CTO</p>
                        <div class="flex justify-center mt-4 space-x-3">
                            <a href="#" class="text-gray-400 hover:text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 3 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                    <div class="aspect-w-1 aspect-h-1">
                        <img src="{{ asset('images/about/team-3.jpg') }}" alt="Laura Martin" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="font-bold text-lg text-gray-800">Laura Martin</h3>
                        <p class="text-emerald-600">Directrice Marketing</p>
                        <div class="flex justify-center mt-4 space-x-3">
                            <a href="#" class="text-gray-400 hover:text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 4 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                    <div class="aspect-w-1 aspect-h-1">
                        <img src="{{ asset('images/about/team-4.jpg') }}" alt="Paul Lemaire" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="font-bold text-lg text-gray-800">Paul Lemaire</h3>
                        <p class="text-emerald-600">Directeur Commercial</p>
                        <div class="flex justify-center mt-4 space-x-3">
                            <a href="#" class="text-gray-400 hover:text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-emerald-700 py-16 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Prêt à rejoindre JobNow?</h2>
            <p class="text-lg mb-8 max-w-2xl mx-auto">Que vous soyez à la recherche du candidat idéal ou de votre prochain emploi, nous sommes là pour vous aider.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register.candidate') }}" class="bg-white text-emerald-700 font-bold px-8 py-3 rounded-md hover:bg-gray-100 transition">
                    S'inscrire comme candidat
                </a>
                <a href="{{ route('register.recruiter') }}" class="bg-emerald-600 text-white font-bold px-8 py-3 rounded-md hover:bg-emerald-800 transition border border-white">
                    S'inscrire comme recruteur
                </a>
            </div>
        </div>
    </section>
</x-app-layout>