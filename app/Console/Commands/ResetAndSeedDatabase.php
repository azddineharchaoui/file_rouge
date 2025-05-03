<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ResetAndSeedDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reset-and-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Réinitialise la base de données et ajoute les données de test';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->confirm('Cela va supprimer toutes les données existantes. Êtes-vous sûr de vouloir continuer?')) {
            // Vérifier et corriger les noms de fichiers de migration problématiques
            $this->checkAndFixMigrationFiles();

            $this->info('Réinitialisation de la base de données...');
            Artisan::call('migrate:fresh', ['--force' => true]);
            $this->info('Migration terminée!');

            $this->info('Ajout des données de base...');
            Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\DatabaseSeeder', '--force' => true]);
            $this->info('Données de base ajoutées!');

            $this->info('Ajout des offres d\'emploi...');
            Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\JobOfferSeeder', '--force' => true]);
            $this->info('Offres d\'emploi ajoutées!');

            $this->info('La base de données a été réinitialisée et remplie avec succès!');
        } else {
            $this->info('Opération annulée.');
        }
    }

    /**
     * Vérifie et corrige les fichiers de migration problématiques
     */
    protected function checkAndFixMigrationFiles()
    {
        $migrationsPath = database_path('migrations');
        $files = File::files($migrationsPath);

        foreach ($files as $file) {
            // Vérifier si le fichier commence par _xx_xx_
            if (preg_match('/^_xx_xx_/', $file->getFilename())) {
                $currentPath = $file->getPathname();
                $newFilename = date('Y_m_d_His') . '_' . substr($file->getFilename(), 6);
                $newPath = $migrationsPath . '/' . $newFilename;
                
                File::move($currentPath, $newPath);
                $this->info("Migration renommée: {$file->getFilename()} -> {$newFilename}");
            }
            
            // S'assurer que les dates des fichiers de migration pour users sont correctes
            if (strpos($file->getFilename(), 'add_is_approved_to_users_table') !== false && 
                strpos($file->getFilename(), '2025_') === 0) {
                $currentPath = $file->getPathname();
                $newFilename = date('Y_m_d_His') . '_add_is_approved_to_users_table.php';
                $newPath = $migrationsPath . '/' . $newFilename;
                
                File::move($currentPath, $newPath);
                $this->info("Migration renommée: {$file->getFilename()} -> {$newFilename}");
            }
        }
    }
}
