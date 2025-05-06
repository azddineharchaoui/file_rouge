<x-app-layout>
    <x-slot name="title">Contactez-nous</x-slot>

    <!-- Hero Section -->
    <section class="bg-emerald-900 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-4">Contactez-nous</h1>
                <p class="text-xl">Nous sommes là pour répondre à toutes vos questions.</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Formulaire de contact -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Envoyez-nous un message</h2>
                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                required
                            >
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                required
                            >
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Sujet</label>
                            <input 
                                type="text" 
                                name="subject" 
                                id="subject" 
                                class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                required
                            >
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea 
                                name="message" 
                                id="message" 
                                rows="5" 
                                class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                required
                            ></textarea>
                        </div>
                        
                        <div>
                            <button 
                                type="submit" 
                                class="w-full bg-emerald-500 text-white px-6 py-3 rounded-md hover:bg-emerald-600 transition font-medium"
                            >
                                Envoyer
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Informations de contact -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Nos coordonnées</h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-emerald-100 rounded-md flex items-center justify-center text-emerald-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Adresse</h3>
                                <p class="mt-1 text-gray-600">
                                    123 Avenue des Champs-Élysées<br>
                                    75008 Paris<br>
                                    France
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-emerald-100 rounded-md flex items-center justify-center text-emerald-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Email</h3>
                                <p class="mt-1 text-gray-600">
                                    <a href="mailto:contact@jobnow.fr" class="text-emerald-600 hover:underline">contact@jobnow.fr</a>
                                </p>
                                <p class="text-gray-600">
                                    <a href="mailto:support@jobnow.fr" class="text-emerald-600 hover:underline">support@jobnow.fr</a>
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-emerald-100 rounded-md flex items-center justify-center text-emerald-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Téléphone</h3>
                                <p class="mt-1 text-gray-600">
                                    <a href="tel:+33123456789" class="text-emerald-600 hover:underline">+33 1 23 45 67 89</a>
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Du lundi au vendredi, de 9h à 18h
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Carte ou image de localisation -->
                    <div class="mt-8 rounded-lg overflow-hidden shadow">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d20995.766129713436!2d2.269807971267557!3d48.86830153443837!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66fc518637631%3A0x7c6b92d2c2465999!2zQ2hhbXBzLcOJbHlzw6llcywgUGFyaXMsIEZyYW5jZQ!5e0!3m2!1sen!2sma!4v1746292870861!5m2!1sen!2sma" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Questions fréquemment posées</h2>
                
                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Comment puis-je créer un compte?</h3>
                        <p class="text-gray-600">
                            Vous pouvez créer un compte en cliquant sur "S'inscrire" dans le menu de navigation. Vous aurez le choix entre créer un compte candidat ou recruteur selon vos besoins.
                        </p>
                    </div>
                    
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">L'inscription est-elle gratuite?</h3>
                        <p class="text-gray-600">
                            L'inscription est totalement gratuite pour les candidats. Pour les recruteurs, nous proposons différentes formules, dont une version d'essai gratuite.
                        </p>
                    </div>
                    
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Comment modifier mes informations de profil?</h3>
                        <p class="text-gray-600">
                            Une fois connecté, vous pouvez accéder à votre profil via le menu déroulant en haut à droite de la page. De là, vous pourrez modifier toutes vos informations personnelles.
                        </p>
                    </div>
                    
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Comment supprimer mon compte?</h3>
                        <p class="text-gray-600">
                            Pour supprimer votre compte, rendez-vous dans les paramètres de votre profil. Au bas de la page, vous trouverez l'option "Supprimer mon compte". Notez que cette action est irréversible.
                        </p>
                    </div>
                </div>
                
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Vous ne trouvez pas la réponse à votre question? <a href="#" class="text-emerald-600 font-medium hover:underline">Consultez notre centre d'aide</a> ou <a href="#" class="text-emerald-600 font-medium hover:underline">contactez-nous directement</a>.
                    </p>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    title: 'Message envoyé!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#10B981',
                    timer: 5000
                });
            @endif
        });
    </script>
</x-app-layout>