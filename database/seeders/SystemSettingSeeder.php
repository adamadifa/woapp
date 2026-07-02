<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'app_name' => 'WOApp - Wedding Management System',
            'company_email' => 'support@woapp.com',
            'company_phone' => '08123456789',
            'company_address' => 'Gedung Solusi IT Lt. 4, Jakarta, Indonesia',
            'bank_transfer_info' => 'Bank BCA - Rekening: 1234-567-890 - Atas Nama: PT WOApp Solusi Pernikahan',
        ];

        foreach ($settings as $key => $val) {
            SystemSetting::setValue($key, $val);
        }
    }
}
