<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesPermissionsSeeder::class,
            SettingsSeeder::class,
            DepartmentsSeeder::class,
            WardsVillagesSeeder::class,
            NewsCategoriesSeeder::class,
            DocumentCategoriesSeeder::class,
            FeedbackCategoriesSeeder::class,
            AdminUserSeeder::class,
            SliderSeeder::class,
        ]);
    }
}
