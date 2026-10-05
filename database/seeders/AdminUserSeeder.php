<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@kijuratowncouncil.go.ug'],
            [
                'name'      => 'System Administrator',
                'password'  => Hash::make('Admin@2026!'),
                'is_active' => true,
                'job_title' => 'System Administrator',
            ]
        );

        $admin->assignRole('Super Administrator');

        $this->command->info("Admin user created: admin@kijuratowncouncil.go.ug / Admin@2026!");
    }
}
