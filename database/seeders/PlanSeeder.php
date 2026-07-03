<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'price' => 0,
                'max_projects' => 1,
                'max_team_members' => 3,
                'has_custom_landing' => false,
                'has_client_dashboard' => false,
                'features' => json_encode([
                    '1 Active Wedding Project',
                    'Fitur Dasar Dashboard',
                    'Maksimal 3 Anggota Tim'
                ])
            ],
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'price' => 199000,
                'max_projects' => 5,
                'max_team_members' => 10,
                'has_custom_landing' => true,
                'has_client_dashboard' => false,
                'features' => json_encode([
                    'Up to 5 Active Projects',
                    'Up to 10 Team Members',
                    'Landing Page Publik ("Powered by")'
                ])
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'price' => 499000,
                'max_projects' => -1,
                'max_team_members' => -1,
                'has_custom_landing' => true,
                'has_client_dashboard' => true,
                'features' => json_encode([
                    'Unlimited Active Projects',
                    'Unlimited Team Members',
                    'Custom Public Landing Page (Bebas label)',
                    'Akses Kolaborasi Klien'
                ])
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'price' => 999000,
                'max_projects' => -1,
                'max_team_members' => -1,
                'has_custom_landing' => true,
                'has_client_dashboard' => true,
                'features' => json_encode([
                    'Semua Fitur Pro',
                    'Custom Domain Integration',
                    'Multi-Tenant & Dedicated Support'
                ])
            ]
        ];

        foreach ($plans as $plan) {
            \App\Models\Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
