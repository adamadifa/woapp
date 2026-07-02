<?php

namespace Database\Seeders;

use App\Models\Vendor;
use App\Models\WeddingPackage;
use App\Models\WoProfile;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $woProfile = WoProfile::first();

        if ($woProfile) {
            // 1. Seed Packages
            WeddingPackage::create([
                'wo_profile_id' => $woProfile->id,
                'name' => 'Silver Package',
                'description' => 'Paket ekonomis lengkap untuk kapasitas tamu hingga 300 orang.',
                'price' => 35000000.00,
                'items' => [
                    'Standard Decoration',
                    'Catering 300 Pax',
                    'Bridal & Groom Makeup (MUA)',
                    '1 Photographer & 1 Videographer',
                    'Master of Ceremony (MC)',
                    'Standard Sound System & Music'
                ],
                'is_active' => true,
            ]);

            WeddingPackage::create([
                'wo_profile_id' => $woProfile->id,
                'name' => 'Gold Package',
                'description' => 'Paket wedding populer dengan dekorasi premium untuk kapasitas tamu hingga 500 orang.',
                'price' => 65000000.00,
                'items' => [
                    'Premium Decoration',
                    'Catering 500 Pax',
                    'Bridal & Groom Makeup + Family Makeup',
                    '2 Photographers & 1 Videographer + Album',
                    'Professional MC & Acoustic Band',
                    'Premium Sound System'
                ],
                'is_active' => true,
            ]);

            // 2. Seed Vendors
            Vendor::create([
                'wo_profile_id' => $woProfile->id,
                'name' => 'Lestari Catering Service',
                'category' => 'Catering',
                'phone' => '081299998888',
                'address' => 'Jl. Makanan Enak No. 12, Jakarta',
                'price_range' => 'Rp 50.000 - Rp 120.000 / pax',
                'rating' => 4.8,
                'status' => 'active',
            ]);

            Vendor::create([
                'wo_profile_id' => $woProfile->id,
                'name' => 'Glow Makeup Artistry',
                'category' => 'MUA',
                'phone' => '081277776666',
                'address' => 'Mall Cantik Lt. 2, Jakarta',
                'price_range' => 'Rp 5.000.000 - Rp 15.000.000',
                'rating' => 4.9,
                'status' => 'active',
            ]);
        }
    }
}
