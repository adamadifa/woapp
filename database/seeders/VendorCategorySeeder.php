<?php

namespace Database\Seeders;

use App\Models\VendorCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VendorCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Venue / Gedung', 'icon' => 'office-building', 'description' => 'Gedung pernikahan, hotel, kebun, villa, pantai, dsb.'],
            ['name' => 'Catering / Makanan', 'icon' => 'cake', 'description' => 'Penyedia buffet, pondokan/stall, gubukan, dan minuman.'],
            ['name' => 'Dekorasi & Florist', 'icon' => 'home', 'description' => 'Pelaminan, photo booth, dekorasi jalan, buket bunga.'],
            ['name' => 'Makeup Artist (MUA) & Attire', 'icon' => 'sparkles', 'description' => 'Rias pengantin, sewa kebaya, jas, baju adat, gaun.'],
            ['name' => 'Dokumentasi (Foto & Video)', 'icon' => 'camera', 'description' => 'Fotografer, videografer, foto prewedding, drone, photobooth instan.'],
            ['name' => 'Hiburan (Music & Band)', 'icon' => 'music-note', 'description' => 'Acoustic band, sound system, MC profesional, tarian tradisional.'],
            ['name' => 'Undangan & Souvenir', 'icon' => 'mail', 'description' => 'Undangan cetak, undangan digital/web, souvenir pernikahan.'],
        ];

        foreach ($categories as $c) {
            VendorCategory::create([
                'name' => $c['name'],
                'slug' => Str::slug($c['name']),
                'icon' => $c['icon'],
                'description' => $c['description'],
            ]);
        }
    }
}
