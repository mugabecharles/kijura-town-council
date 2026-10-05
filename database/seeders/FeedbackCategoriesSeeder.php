<?php

namespace Database\Seeders;

use App\Models\FeedbackCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FeedbackCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Service Delivery',      'color' => '#2563eb'],
            ['name' => 'Infrastructure/Roads',   'color' => '#d97706'],
            ['name' => 'Revenue/Taxation',       'color' => '#9333ea'],
            ['name' => 'Health Services',        'color' => '#16a34a'],
            ['name' => 'Education',              'color' => '#0891b2'],
            ['name' => 'Sanitation & Waste',     'color' => '#65a30d'],
            ['name' => 'Business & Trade',       'color' => '#db2777'],
            ['name' => 'General',                'color' => '#6b7280'],
        ];

        foreach ($categories as $cat) {
            FeedbackCategory::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                array_merge($cat, ['slug' => Str::slug($cat['name']), 'is_active' => true])
            );
        }

        $this->command->info('Feedback categories seeded.');
    }
}
