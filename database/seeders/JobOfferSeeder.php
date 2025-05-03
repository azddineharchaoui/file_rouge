<?php

namespace Database\Seeders;

use App\Models\JobOffer;
use App\Models\Category;
use App\Models\Location;
use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class JobOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifier que les tables nécessaires existent
        if (!Schema::hasTable('job_offers') || !Schema::hasTable('company_profiles')) {
            $this->command->error('Les tables requises n\'existent pas. Veuillez d\'abord exécuter les migrations.');
            return;
        }
        
        // Vérifier que les données préalables existent
        if (CompanyProfile::count() == 0 || Category::count() == 0 || Location::count() == 0) {
            $this->command->error('Veuillez d\'abord exécuter le DatabaseSeeder pour créer les données de base');
            return;
        }

        // Supprimer les offres existantes
        JobOffer::truncate();

        // Récupérer les IDs nécessaires
        $companyId = CompanyProfile::first()->id;
        $categories = Category::all();
        $locations = Location::all();

        // Liste d'offres d'emploi
        $jobOffers = [
            [
                'title' => 'Développeur Full Stack JavaScript',
                'description' => 'Nous recherchons un développeur Full Stack JavaScript expérimenté pour rejoindre notre équipe de développement web. Vous serez responsable de la conception et du développement de nouvelles fonctionnalités, ainsi que de la maintenance des fonctionnalités existantes de notre plateforme.',
                'requirements' => "- 3+ ans d'expérience en développement web\n- Maîtrise de JavaScript, React, Node.js\n- Connaissance des bases de données SQL et NoSQL\n- Expérience avec Git\n- Bonne communication et travail d'équipe",
                'salary' => 15000,
                'employment_type' => 'full-time',
                'category' => 'Développement web',
                'location' => 'Casablanca',
                'is_remote' => false,
                'experience_level' => 'mid',
            ],
            [
                'title' => 'Ingénieur DevOps',
                'description' => 'En tant qu\'Ingénieur DevOps, vous serez responsable de l\'automatisation, de la mise en place et de la maintenance de notre infrastructure cloud, ainsi que du déploiement continu de nos applications.',
                'requirements' => "- 2+ ans d'expérience en DevOps\n- Maîtrise des conteneurs (Docker, Kubernetes)\n- Expérience avec AWS ou Azure\n- Connaissance des outils CI/CD (Jenkins, GitLab CI)\n- Compétences en scripting (Bash, Python)",
                'salary' => 18000,
                'employment_type' => 'full-time',
                'category' => 'IT & Réseaux',
                'location' => 'Rabat',
                'is_remote' => true,
                'experience_level' => 'senior',
            ],
            [
                'title' => 'Chef de Projet Digital',
                'description' => 'Nous recrutons un Chef de Projet Digital pour gérer nos projets web et mobiles. Vous serez responsable de la planification, de l\'exécution et de la livraison des projets digitaux dans les délais et le budget impartis.',
                'requirements' => "- 5+ ans d'expérience en gestion de projets digitaux\n- Certification PMP ou équivalent\n- Excellente communication\n- Connaissance des méthodologies Agile/Scrum\n- Maîtrise des outils de gestion de projet",
                'salary' => 22000,
                'employment_type' => 'full-time',
                'category' => 'Marketing digital',
                'location' => 'Casablanca',
                'is_remote' => false,
                'experience_level' => 'senior',
            ],
            [
                'title' => 'Développeur Mobile iOS',
                'description' => 'Nous cherchons un développeur iOS pour concevoir et développer des applications mobiles innovantes pour iPhone et iPad. Vous travaillerez en étroite collaboration avec notre équipe de conception et de développement.',
                'requirements' => "- 2+ ans d'expérience en développement iOS\n- Maîtrise de Swift et Objective-C\n- Connaissance de l'architecture MVC/MVVM\n- Expérience avec les API RESTful\n- Portfolio d'applications publiées sur l'App Store",
                'salary' => 16000,
                'employment_type' => 'full-time',
                'category' => 'Développement mobile',
                'location' => 'Marrakech',
                'is_remote' => true,
                'experience_level' => 'mid',
            ],
            [
                'title' => 'Responsable Marketing Digital',
                'description' => 'En tant que Responsable Marketing Digital, vous serez chargé(e) de définir et mettre en œuvre notre stratégie de marketing digital, y compris SEO, SEM, médias sociaux et marketing par e-mail.',
                'requirements' => "- 4+ ans d'expérience en marketing digital\n- Maîtrise des outils d'analyse web (Google Analytics)\n- Expérience en gestion de campagnes publicitaires en ligne\n- Connaissance des techniques SEO/SEM\n- Diplôme en marketing ou communication",
                'salary' => 20000,
                'employment_type' => 'full-time',
                'category' => 'Marketing digital',
                'location' => 'Casablanca',
                'is_remote' => false,
                'experience_level' => 'senior',
            ],
            [
                'title' => 'Designer UI/UX',
                'description' => 'Nous recherchons un Designer UI/UX créatif pour concevoir des interfaces utilisateur exceptionnelles pour nos applications web et mobiles. Vous travaillerez sur l\'expérience utilisateur globale, les wireframes, les prototypes et les designs finaux.',
                'requirements' => "- 3+ ans d'expérience en design UI/UX\n- Maîtrise de Figma et Adobe Creative Suite\n- Portfolio démontrant vos compétences en design\n- Connaissance des principes de l'expérience utilisateur\n- Capacité à créer des prototypes interactifs",
                'salary' => 14000,
                'employment_type' => 'full-time',
                'category' => 'Design & Création',
                'location' => 'Tanger',
                'is_remote' => true,
                'experience_level' => 'mid',
            ],
            [
                'title' => 'Comptable',
                'description' => 'Nous recherchons un comptable pour rejoindre notre équipe financière. Vous serez responsable de la tenue des comptes, de la préparation des états financiers et des déclarations fiscales.',
                'requirements' => "- Diplôme en comptabilité ou finance\n- 2+ ans d'expérience en comptabilité\n- Maîtrise des logiciels comptables\n- Connaissance des normes comptables marocaines\n- Rigueur et organisation",
                'salary' => 10000,
                'employment_type' => 'full-time',
                'category' => 'Finance & Comptabilité',
                'location' => 'Rabat',
                'is_remote' => false,
                'experience_level' => 'mid',
            ],
            [
                'title' => 'Développeur Frontend React',
                'description' => 'Nous recherchons un développeur Frontend React pour créer des interfaces utilisateur réactives et élégantes. Vous travaillerez en étroite collaboration avec notre équipe de conception et de développement.',
                'requirements' => "- 2+ ans d'expérience en développement Frontend\n- Maîtrise de React, JavaScript, HTML5, CSS3\n- Expérience avec les outils de build modernes (Webpack, Babel)\n- Connaissance de Redux ou MobX\n- Sensibilité au design et à l'expérience utilisateur",
                'salary' => 14000,
                'employment_type' => 'full-time',
                'category' => 'Développement web',
                'location' => 'Casablanca',
                'is_remote' => true,
                'experience_level' => 'mid',
            ],
            [
                'title' => 'Chargé(e) de recrutement',
                'description' => 'Nous recherchons un(e) chargé(e) de recrutement pour rejoindre notre équipe RH. Vous serez responsable du processus de recrutement de A à Z, de la définition des besoins à l\'intégration des nouveaux collaborateurs.',
                'requirements' => "- 2+ ans d'expérience en recrutement\n- Maîtrise des techniques d'entretien\n- Connaissance des outils de sourcing\n- Excellentes compétences relationnelles\n- Diplôme en RH ou domaine connexe",
                'salary' => 12000,
                'employment_type' => 'full-time',
                'category' => 'Ressources humaines',
                'location' => 'Marrakech',
                'is_remote' => false,
                'experience_level' => 'mid',
            ],
            [
                'title' => 'Ingénieur Qualité Logiciel (QA)',
                'description' => 'En tant qu\'Ingénieur QA, vous serez responsable de l\'assurance qualité de nos produits logiciels. Vous concevrez et exécuterez des tests pour garantir que nos applications répondent aux plus hauts standards de qualité.',
                'requirements' => "- 3+ ans d'expérience en QA\n- Connaissance des méthodologies de test\n- Expérience en automatisation des tests\n- Maîtrise des outils comme Selenium, Cypress ou Jest\n- Bonne communication et documentation",
                'salary' => 15000,
                'employment_type' => 'full-time',
                'category' => 'IT & Réseaux',
                'location' => 'Casablanca',
                'is_remote' => true,
                'experience_level' => 'mid',
            ],
            [
                'title' => 'Stagiaire en Développement Web',
                'description' => 'Nous proposons un stage en développement web pour les étudiants en informatique. Vous travaillerez sur des projets réels sous la supervision de développeurs expérimentés.',
                'requirements' => "- Étudiant en informatique ou développement web\n- Connaissance de base en HTML, CSS et JavaScript\n- Motivation pour apprendre\n- Disponibilité pour un stage de 3 à 6 mois\n- Esprit d'équipe",
                'salary' => 3000,
                'employment_type' => 'internship',
                'category' => 'Développement web',
                'location' => 'Rabat',
                'is_remote' => false,
                'experience_level' => 'entry',
            ],
            [
                'title' => 'Commercial B2B',
                'description' => 'Nous recherchons un commercial B2B pour développer notre portefeuille client. Vous serez responsable de la prospection, de la négociation et de la fidélisation de clients professionnels.',
                'requirements' => "- 3+ ans d'expérience en vente B2B\n- Excellentes compétences en négociation\n- Capacité à atteindre des objectifs commerciaux\n- Permis de conduire\n- Expérience dans le secteur IT est un plus",
                'salary' => 12000,
                'employment_type' => 'full-time',
                'category' => 'Vente & Commerce',
                'location' => 'Agadir',
                'is_remote' => false,
                'experience_level' => 'mid',
            ],
        ];

        // Créer les offres d'emploi
        foreach ($jobOffers as $offer) {
            $categoryId = $categories->where('name', $offer['category'])->first()->id ?? $categories->first()->id;
            $locationId = $locations->where('name', $offer['location'])->first()->id ?? $locations->first()->id;

            try {
                // S'assurer que les champs correspondent à la structure de la table
                $jobData = [
                    'title' => $offer['title'],
                    'description' => $offer['description'],
                    'requirements' => $offer['requirements'],
                    'salary' => $offer['salary'],
                    'employment_type' => $this->mapEmploymentType($offer['employment_type']),
                    'company_id' => $companyId,
                    'categorie_id' => $categoryId,
                    'location_id' => $locationId,
                    'is_featured' => rand(0, 1) == 1,
                    'is_remote' => $offer['is_remote'],
                    'application_deadline' => now()->addDays(rand(14, 30)),
                    'experience_level' => $this->mapExperienceLevel($offer['experience_level']),
                    'views' => rand(10, 100),
                ];

                // Vérifier si le schéma de JobOffer a tous ces champs avant de créer
                JobOffer::create($jobData);
            } catch (\Exception $e) {
                $this->command->error("Erreur lors de la création de l'offre '{$offer['title']}': " . $e->getMessage());
            }
        }

        $this->command->info('Les offres d\'emploi ont été créées avec succès !');
    }

    /**
     * Convertit les valeurs d'experience_level pour correspondre à l'enum dans la base de données
     */
    private function mapExperienceLevel($level)
    {
        $mapping = [
            'entry' => 'Entry',
            'mid' => 'Intermediate',
            'senior' => 'Senior',
        ];

        return $mapping[$level] ?? 'Entry';
    }

    /**
     * Convertit les valeurs d'employment_type pour correspondre à l'enum dans la base de données
     */
    private function mapEmploymentType($type)
    {
        $mapping = [
            'full-time' => 'Full-time',
            'part-time' => 'Part-time',
            'contract' => 'Contract',
            'internship' => 'Internship',
            'temporary' => 'Temporary',
        ];

        return $mapping[$type] ?? 'Full-time';
    }
}
