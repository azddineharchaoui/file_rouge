<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Category;
use App\Models\Location;
use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Création du compte administrateur
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin1@jobnow.com',
        //     'password' => Hash::make('123456789'),
        //     'role' => 'admin',
        //     'is_approved' => true,
        //     'email_verified_at' => now(),
        // ]);

        //Création de quelques recruteurs en attente de validation
        // $recruiter1 = User::create([
        //     'name' => 'Jean Dupont',
        //     'email' => 'recruteur1@example.com',
        //     'password' => Hash::make('123456789'),
        //     'role' => 'recruiter',
        //     'is_approved' => false, // En attente de validation
        //     'email_verified_at' => now(),
        // ]);

        // $recruiter2 = User::create([
        //     'name' => 'Marie Martin',
        //     'email' => 'recruteur2@example.com',
        //     'password' => Hash::make('123456789'),
        //     'role' => 'recruiter',
        //     'is_approved' => false, // En attente de validation
        //     'email_verified_at' => now(),
        // ]);

        //Création des profils d'entreprise pour les recruteurs
        // CompanyProfile::create([
        //     'user_id' => $recruiter1->id,
        //     'company_name' => 'Tech Innovations',
        //     'website' => 'https://techinnovations.example.com',
        //     'description' => 'Entreprise spécialisée dans le développement de solutions innovantes.',
        //     'industry' => 'Technologie',
        //     'size' => '50-200 employés',
        //     'logo' => null,
        // ]);

        // CompanyProfile::create([
        //     'user_id' => $recruiter2->id,
        //     'company_name' => 'Finance Plus',
        //     'website' => 'https://financeplus.example.com',
        //     'description' => 'Cabinet de conseil financier pour entreprises et particuliers.',
        //     'industry' => 'Finance',
        //     'size' => '10-50 employés',
        //     'logo' => null,
        // ]);

        // Création de quelques catégories d'emploi
        $categories = [
            'Développement Web',
            'Marketing Digital',
            'Design & Créativité',
            'Finance & Comptabilité',
            'Ressources Humaines',
            'Vente & Business Development',
            'Support Client',
            'Management & Direction',
            'Data & Analyse',
            'Ingénierie & Technique',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        // Création de quelques localisations
        $locations = [
            'Paris',
            'Lyon',
            'Marseille',
            'Bordeaux',
            'Lille',
            'Toulouse',
            'Nantes',
            'Strasbourg',
            'Remote / Télétravail'
        ];

        foreach ($locations as $location) {
            Location::create(['name' => $location]);
        }

        // Message de confirmation
        $this->command->info('Base de données initialisée avec un compte administrateur et des données de test!');
        $this->command->info('Connectez-vous avec: admin@jobnow.com / Admin123!');
    }
}
