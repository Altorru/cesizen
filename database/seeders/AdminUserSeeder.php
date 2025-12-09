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
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@cesizen.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create sample content pages
        $pages = [
            [
                'title' => 'About CESIZen',
                'slug' => 'about',
                'content' => "# About CESIZen\n\nCESIZen is your companion for stress management and mental health.\n\n## Our Mission\n\nWe aim to provide accessible tools and resources to help you manage stress and improve your mental well-being.\n\n## Features\n\n- Emotion tracking\n- Breathing exercises\n- Mental health resources\n- Personalized insights",
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Mental Health Guide',
                'slug' => 'mental-health',
                'content' => "# Understanding Mental Health\n\nMental health is just as important as physical health.\n\n## What is Mental Health?\n\nMental health includes our emotional, psychological, and social well-being. It affects how we think, feel, and act.\n\n## Why It Matters\n\n- Helps determine how we handle stress\n- Relates to others\n- Makes healthy choices\n\n## Getting Help\n\nIf you're struggling with your mental health, remember that help is available. Don't hesitate to reach out to a mental health professional.",
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy',
                'content' => "# Privacy Policy\n\nLast updated: ".now()->format('F d, Y')."\n\n## Data We Collect\n\nWe collect only the data necessary to provide our services:\n\n- Account information (name, email)\n- Emotion tracking data\n- Usage statistics\n\n## How We Use Your Data\n\nYour data is used solely to provide and improve our services. We never sell your personal information.\n\n## Data Security\n\nWe implement industry-standard security measures to protect your data.",
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

        $this->command->info('Admin user and sample content pages created successfully!');
        $this->command->info('Email: admin@cesizen.com');
        $this->command->info('Password: password');
    }
}
