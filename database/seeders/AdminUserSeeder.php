<?php

namespace Database\Seeders;

use App\Models\ContentPage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function now;

class AdminUserSeeder extends Seeder
{
    /**
     * Exécuter les seeds de la base de données.
     */
    public function run(): void
    {
        // Créer un utilisateur administrateur
        $admin = User::firstOrCreate(
            ['email' => 'admin@cesizen.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Créer des pages de contenu d'exemple
        $pages = [
            [
                'title' => 'À propos de CESIZen',
                'slug' => 'a-propos',
                'content' => "# À propos de CESIZen\n\nCESIZen est votre compagnon pour la gestion du stress et de la santé mentale.\n\n## Notre Mission\n\nNous visons à fournir des outils et des ressources accessibles pour vous aider à gérer le stress et améliorer votre bien-être mental.\n\n## Fonctionnalités\n\n- Suivi des émotions\n- Exercices de respiration\n- Ressources sur la santé mentale\n- Informations personnalisées",
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Guide de la santé mentale',
                'slug' => 'sante-mentale',
                'content' => "# Comprendre la santé mentale\n\nLa santé mentale est tout aussi importante que la santé physique.\n\n## Qu'est-ce que la santé mentale ?\n\nLa santé mentale comprend notre bien-être émotionnel, psychologique et social. Elle affecte notre façon de penser, de ressentir et d'agir.\n\n## Pourquoi c'est important\n\n- Aide à déterminer comment nous gérons le stress\n- Influence nos relations avec les autres\n- Contribue à faire des choix sains\n\n## Obtenir de l'aide\n\nSi vous êtes aux prises avec votre santé mentale, n'oubliez pas que de l'aide est disponible. N'hésitez pas à contacter un professionnel de la santé mentale.",
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Politique de confidentialité',
                'slug' => 'confidentialite',
                'content' => "# Politique de confidentialité\n\nDernière mise à jour : ".now()->format('d F Y')."\n\n## Données que nous collectons\n\nNous collectons uniquement les données nécessaires pour fournir nos services :\n\n- Informations de compte (nom, email)\n- Données de suivi des émotions\n- Statistiques d'utilisation\n\n## Comment nous utilisons vos données\n\nVos données sont utilisées uniquement pour fournir et améliorer nos services. Nous ne vendons jamais vos informations personnelles.\n\n## Sécurité des données\n\nNous mettons en œuvre des mesures de sécurité conformes aux normes de l'industrie pour protéger vos données.",
                'is_published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($pages as $pageData) {
            ContentPage::firstOrCreate(
                ['slug' => $pageData['slug']],
                [
                    ...$pageData,
                    'created_by' => $admin->id,
                ]
            );
        }

        $this->command->info('Utilisateur administrateur et pages de contenu d\'exemple créés avec succès !');
        $this->command->info('Email: admin@cesizen.com');
        $this->command->info('Mot de passe: password');
    }
}
