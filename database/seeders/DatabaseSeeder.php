<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\User;
use App\Models\CompanyProfile;
use App\Models\CandidateProfile;
use App\Models\JobOffer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Vérifier que toutes les tables nécessaires existent
        if (!Schema::hasTable('users') || !Schema::hasTable('candidate_profiles')) {
            $this->command->error('Les tables requises n\'existent pas. Veuillez d\'abord exécuter les migrations.');
            return;
        }
        
        // Vérifier si la colonne is_approved existe
        $hasIsApproved = Schema::hasColumn('users', 'is_approved');
        
        // Création d'un utilisateur Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin1@jobnow.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'role' => 'admin', 
            'remember_token' => Str::random(10),
        ]);

        // Ajouter is_approved uniquement si la colonne existe
        if ($hasIsApproved) {
            $admin->is_approved = true;
            $admin->save();
        }

        // Création d'un utilisateur Recruteur
        $recruiter = User::create([
            'name' => 'Recruteur Test',
            'email' => 'recruiter@jobnow.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'role' => 'recruiter', 
            'remember_token' => Str::random(10),
        ]);

        // Ajouter is_approved uniquement si la colonne existe
        if ($hasIsApproved) {
            $recruiter->is_approved = true;
            $recruiter->save();
        }

        // Création du profil de l'entreprise - compatible avec la structure de la table
        $company = CompanyProfile::create([
            'user_id' => $recruiter->id,
            'company_name' => 'Entreprise Test',
            'industry' => 'Technology',
            'website' => 'https://entreprisetest.com',
            'description' => 'Une entreprise de test pour le développement de l\'application.',
            'location' => 'Casablanca', 
        ]);

        // Création d'un utilisateur Candidat
        $candidate = User::create([
            'name' => 'Candidat Test',
            'email' => 'candidate@jobnow.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'role' => 'candidate', 
            'remember_token' => Str::random(10),
        ]);

        // Ajouter is_approved uniquement si la colonne existe
        if ($hasIsApproved) {
            $candidate->is_approved = true;
            $candidate->save();
        }

        // Création du profil du candidat
        $candidateProfile = CandidateProfile::create([
            'user_id' => $candidate->id,
            'phone' => '0612345678',
            'address' => '123 Rue Candidat',
            'bio' => 'Un candidat de test pour le développement de l\'application.',
        ]);

        // Suppression des catégories existantes
        Category::truncate();

        // Création de nouvelles catégories d'emploi adaptées
        $categories = [
            'Développement web',
            'Développement mobile',
            'IT & Réseaux',
            'Marketing digital',
            'Design & Création',
            'Vente & Commerce',
            'Finance & Comptabilité',
            'Ressources humaines',
            'Administration & Secrétariat',
            'Service client',
            'Ingénierie & Architecture',
            'Santé & Médical',
            'Éducation & Formation',
            'Logistique & Transport',
            'Hôtellerie & Restauration',
            'BTP & Construction',
            'Agriculture',
            'Tourisme',
            'Juridique',
            'Télécommunications',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        // Suppression des localisations existantes
        Location::truncate();

        // Création de villes marocaines avec tous les champs obligatoires
        $locations = [
            ['name' => 'Casablanca', 'city' => 'Casablanca', 'country' => 'Maroc'],
            ['name' => 'Rabat', 'city' => 'Rabat', 'country' => 'Maroc'],
            ['name' => 'Marrakech', 'city' => 'Marrakech', 'country' => 'Maroc'],
            ['name' => 'Fès', 'city' => 'Fès', 'country' => 'Maroc'],
            ['name' => 'Tanger', 'city' => 'Tanger', 'country' => 'Maroc'],
            ['name' => 'Agadir', 'city' => 'Agadir', 'country' => 'Maroc'],
            ['name' => 'Meknès', 'city' => 'Meknès', 'country' => 'Maroc'],
            ['name' => 'Oujda', 'city' => 'Oujda', 'country' => 'Maroc'],
            ['name' => 'Kénitra', 'city' => 'Kénitra', 'country' => 'Maroc'],
            ['name' => 'Tétouan', 'city' => 'Tétouan', 'country' => 'Maroc'],
            ['name' => 'El Jadida', 'city' => 'El Jadida', 'country' => 'Maroc'],
            ['name' => 'Mohammedia', 'city' => 'Mohammedia', 'country' => 'Maroc'],
            ['name' => 'Safi', 'city' => 'Safi', 'country' => 'Maroc'],
            ['name' => 'Salé', 'city' => 'Salé', 'country' => 'Maroc'],
            ['name' => 'Nador', 'city' => 'Nador', 'country' => 'Maroc'],
            ['name' => 'Béni Mellal', 'city' => 'Béni Mellal', 'country' => 'Maroc'],
            ['name' => 'Témara', 'city' => 'Témara', 'country' => 'Maroc'],
            ['name' => 'Khouribga', 'city' => 'Khouribga', 'country' => 'Maroc'],
            ['name' => 'Ouarzazate', 'city' => 'Ouarzazate', 'country' => 'Maroc'],
            ['name' => 'Essaouira', 'city' => 'Essaouira', 'country' => 'Maroc'],
            ['name' => 'Dakhla', 'city' => 'Dakhla', 'country' => 'Maroc'],
            ['name' => 'Laâyoune', 'city' => 'Laâyoune', 'country' => 'Maroc'],
            ['name' => 'Travail à distance', 'city' => 'N/A', 'country' => 'Global'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }

        // Message de confirmation
        $this->command->info('Les données initiales ont été créées avec succès !');
        $this->command->info('Admin user: admin@jobnow.com / password');
        $this->command->info('Recruiter user: recruiter@jobnow.com / password');
        $this->command->info('Candidate user: candidate@jobnow.com / password');
    }
}
