<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\GuestList;
use App\Models\User;
use App\Models\Venue;
use App\Models\WeddingPackage;
use App\Models\WeddingProject;
use Illuminate\Database\Seeder;

class ProjectDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Get WO User and Profile
        $woUser = User::where('email', 'rizky@wedding.com')->first();
        if (!$woUser) {
            $this->command->error('WO User rizky@wedding.com not found. Run db:seed first.');
            return;
        }
        $woProfileId = $woUser->tenant_id;

        // 2. Get Client User
        $clientUser = User::where('email', 'aditdinda@wedding.com')->first();
        if (!$clientUser) {
            $this->command->error('Client User aditdinda@wedding.com not found. Run db:seed first.');
            return;
        }

        // 3. Create a dummy package if none exists
        $package = WeddingPackage::first();
        if (!$package) {
            $package = WeddingPackage::create([
                'wo_profile_id' => $woProfileId,
                'name' => 'Premium Platinum Package',
                'description' => 'Paket lengkap eksklusif untuk pernikahan mewah.',
                'price' => 75000000.00,
                'items' => ['Catering 500 Pax', 'MUA & Busana', 'Dekorasi Pelaminan', 'Dokumentasi Foto & Video', 'MC & Entertainment'],
                'status' => 'active',
            ]);
        }

        // 4. Create Client Profile
        $client = Client::create([
            'wo_profile_id' => $woProfileId,
            'user_id' => $clientUser->id,
            'groom_name' => 'Aditya',
            'bride_name' => 'Dinda',
            'wedding_date' => '2026-10-10',
            'phone' => '081298765432',
            'package_id' => $package->id,
        ]);

        // 5. Create Venue
        $venue = Venue::create([
            'wo_profile_id' => $woProfileId,
            'name' => 'Gedung Golkar Ciamis',
            'address' => 'Jln. Raya Ciamis No. 45, Ciamis',
            'capacity' => 1000,
            'price' => 25000000.00,
            'contact_phone' => '089670444321',
            'facilities' => ['AC Central', 'Catering Area', 'Ruang Rias', 'Panggung Utama', 'Parking Area'],
            'images' => [],
        ]);

        // 6. Create Wedding Project
        $project = WeddingProject::create([
            'client_id' => $client->id,
            'wo_profile_id' => $woProfileId,
            'name' => 'Pernikahan Aditya & Dinda',
            'wedding_date' => '2026-10-10',
            'venue_id' => $venue->id,
            'total_budget' => 150000000.00,
            'status' => 'planning',
        ]);

        // 7. Create Dummy Guests
        $guestsData = [
            ['name' => 'Bpk. Ahmad Heryawan', 'category' => 'VVIP', 'rsvp_status' => 'confirmed', 'guest_count' => 2, 'seat_number' => 'VVIP-1', 'notes' => 'Mantan Gubernur'],
            ['name' => 'Dr. Ridwan Kamil', 'category' => 'VVIP', 'rsvp_status' => 'confirmed', 'guest_count' => 2, 'seat_number' => 'VVIP-2', 'notes' => 'Tokoh Masyarakat'],
            ['name' => 'Budi Santoso', 'category' => 'Keluarga Pria', 'rsvp_status' => 'confirmed', 'guest_count' => 4, 'seat_number' => 'Fam-A1', 'notes' => 'Paman dari Aditya'],
            ['name' => 'Siti Aminah', 'category' => 'Keluarga Wanita', 'rsvp_status' => 'confirmed', 'guest_count' => 3, 'seat_number' => 'Fam-B1', 'notes' => 'Bibi dari Dinda'],
            ['name' => 'Doni Setiawan', 'category' => 'Teman', 'rsvp_status' => 'pending', 'guest_count' => 2, 'seat_number' => 'Table-3', 'notes' => 'Teman SMA Aditya'],
            ['name' => 'Ratih Kumala', 'category' => 'Teman', 'rsvp_status' => 'pending', 'guest_count' => 1, 'seat_number' => 'Table-4', 'notes' => 'Teman Kuliah Dinda'],
            ['name' => 'Joko Widodo', 'category' => 'Kolega', 'rsvp_status' => 'declined', 'guest_count' => 2, 'seat_number' => null, 'notes' => 'Berhalangan hadir karena luar kota'],
            ['name' => 'Hendra Wijaya', 'category' => 'Kolega', 'rsvp_status' => 'confirmed', 'guest_count' => 2, 'seat_number' => 'Table-5', 'notes' => 'Rekan kerja Aditya'],
            ['name' => 'Arie Kriting', 'category' => 'Lainnya', 'rsvp_status' => 'confirmed', 'guest_count' => 2, 'seat_number' => 'Table-6', 'notes' => 'Guest star / hiburan'],
            ['name' => 'Clara Shinta', 'category' => 'Teman', 'rsvp_status' => 'declined', 'guest_count' => 1, 'seat_number' => null, 'notes' => 'Sedang di luar negeri'],
        ];

        foreach ($guestsData as $g) {
            GuestList::create(array_merge($g, [
                'project_id' => $project->id,
            ]));
        }

        $this->command->info('Dummy Wedding Project, Client, Venue, and Guests successfully seeded!');
    }
}
