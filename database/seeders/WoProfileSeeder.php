<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WoProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WoProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temukan user WO yang dibuat di UserSeeder
        $woUser = User::where('email', 'rizky@wedding.com')->first();

        if ($woUser) {
            $woProfile = WoProfile::create([
                'user_id' => $woUser->id,
                'business_name' => 'Rizky Wedding Organizer',
                'slug' => Str::slug('Rizky Wedding Organizer'),
                'description' => 'Kami membantu mewujudkan pernikahan impian Anda dengan layanan profesional dan penuh dedikasi.',
                'phone' => '081234567890',
                'address' => 'Jl. Kebahagiaan No. 7, Jakarta',
                'subscription_plan' => 'pro',
            ]);

            // Set tenant_id pada user WO tersebut
            $woUser->update([
                'tenant_id' => $woProfile->id,
            ]);

            // Set juga tenant_id untuk user Client milik WO ini
            $clientUser = User::where('email', 'aditdinda@wedding.com')->first();
            if ($clientUser) {
                $clientUser->update([
                    'tenant_id' => $woProfile->id,
                ]);
            }
        }
    }
}
