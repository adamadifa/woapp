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
                'name' => 'Grand Ballroom Mulia',
                'category' => 'Venue / Gedung',
                'phone' => '081211112222',
                'address' => 'Hotel Mulia Lt. 1, Jakarta',
                'price' => 75000000,
                'packages' => [
                    ['name' => 'Half Day Event', 'price' => 50000000],
                    ['name' => 'Full Day Event', 'price' => 80000000],
                ],
                'rating' => 4.9,
                'status' => 'active',
            ]);

            Vendor::create([
                'wo_profile_id' => $woProfile->id,
                'name' => 'Lestari Catering Service',
                'category' => 'Catering / Makanan',
                'phone' => '081299998888',
                'address' => 'Jl. Makanan Enak No. 12, Jakarta',
                'price' => 75000,
                'packages' => [
                    ['name' => 'Paket Silver (500 Pax)', 'price' => 37500000],
                    ['name' => 'Paket Gold (1000 Pax)', 'price' => 75000000],
                    ['name' => 'Paket Platinum (1500 Pax)', 'price' => 112500000],
                ],
                'rating' => 4.8,
                'status' => 'active',
            ]);

            Vendor::create([
                'wo_profile_id' => $woProfile->id,
                'name' => 'Rosy Decoration',
                'category' => 'Dekorasi & Florist',
                'phone' => '081255554444',
                'address' => 'Kawasan Bunga Indah Kav. 3, Jakarta',
                'price' => 25000000,
                'packages' => [
                    ['name' => 'Standard Rustic', 'price' => 20000000],
                    ['name' => 'Premium Royal Garden', 'price' => 35000000],
                ],
                'rating' => 4.7,
                'status' => 'active',
            ]);

            Vendor::create([
                'wo_profile_id' => $woProfile->id,
                'name' => 'Glow Makeup Artistry',
                'category' => 'Makeup Artist (MUA) & Attire',
                'phone' => '081277776666',
                'address' => 'Mall Cantik Lt. 2, Jakarta',
                'price' => 10000000,
                'packages' => [
                    ['name' => 'Make Up Bride Only', 'price' => 5000000],
                    ['name' => 'Make Up Bride & Groom', 'price' => 7500000],
                    ['name' => 'Make Up Keluarga (Lengkap)', 'price' => 12000000],
                ],
                'rating' => 4.9,
                'status' => 'active',
            ]);

            Vendor::create([
                'wo_profile_id' => $woProfile->id,
                'name' => 'Snapshots Photography',
                'category' => 'Dokumentasi (Foto & Video)',
                'phone' => '081233334444',
                'address' => 'Kuningan Creative Hub, Jakarta',
                'price' => 15000000,
                'packages' => [
                    ['name' => 'Akad & Reception Package', 'price' => 12000000],
                    ['name' => 'Full Day + Prewedding Video', 'price' => 20000000],
                ],
                'rating' => 4.8,
                'status' => 'active',
            ]);

            Vendor::create([
                'wo_profile_id' => $woProfile->id,
                'name' => 'Melody Acoustic & Sound',
                'category' => 'Hiburan (Music & Band)',
                'phone' => '081222223333',
                'address' => 'Harmoni Music Studio, Jakarta',
                'price' => 8000000,
                'packages' => [
                    ['name' => 'Acoustic Duo + 3000W Sound', 'price' => 6000000],
                    ['name' => 'Full Band + 5000W Sound', 'price' => 10000000],
                ],
                'rating' => 4.6,
                'status' => 'active',
            ]);

            Vendor::create([
                'wo_profile_id' => $woProfile->id,
                'name' => 'Creative Paper Co.',
                'category' => 'Undangan & Souvenir',
                'phone' => '081266667777',
                'address' => 'Pusat Niaga Senen Blok B, Jakarta',
                'price' => 5000,
                'packages' => [
                    ['name' => 'Digital Invitation Only', 'price' => 1000000],
                    ['name' => 'Standard Printed (300 Pcs)', 'price' => 3500000],
                    ['name' => 'Premium Acrylic (500 Pcs)', 'price' => 8500000],
                ],
                'rating' => 4.7,
                'status' => 'active',
            ]);
        }
    }
}
