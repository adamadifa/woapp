<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Super Admin
        User::create([
            'name' => 'Super Admin WOApp',
            'email' => 'admin@woapp.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // 2. Default Wedding Organizer User (Owner)
        User::create([
            'name' => 'Rizky Wedding Organizer',
            'email' => 'rizky@wedding.com',
            'password' => Hash::make('password'),
            'role' => 'wo',
            'is_active' => true,
        ]);

        // 3. Default Client User
        User::create([
            'name' => 'Adit & Dinda',
            'email' => 'aditdinda@wedding.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'is_active' => true,
        ]);
    }
}
