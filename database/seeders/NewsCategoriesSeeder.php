<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'General News',       'color' => '#2563eb'],
            ['name' => 'Health',             'color' => '#16a34a'],
            ['name' => 'Education',          'color' => '#9333ea'],
            ['name' => 'Agriculture',        'color' => '#65a30d'],
            ['name' => 'Infrastructure',     'color' => '#d97706'],
            ['name' => 'Economy',            'color' => '#0891b2'],
            ['name' => 'Environment',        'color' => '#16a34a'],
            ['name' => 'Community',          'color' => '#db2777'],
            ['name' => 'Public Notice',      'color' => '#dc2626'],
        ];

        foreach ($categories as $i => $cat) {
            NewsCategory::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                array_merge($cat, ['slug' => Str::slug($cat['name']), 'is_active' => true, 'sort_order' => $i + 1])
            );
        }

        $this->command->info('News categories seeded.');
    }
}
