<?php

namespace Database\Seeders;

use App\Models\DocumentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DocumentCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Budgets',                'icon' => 'bi-cash-coin'],
            ['name' => 'Work Plans',             'icon' => 'bi-calendar-check'],
            ['name' => 'Development Plans',      'icon' => 'bi-map'],
            ['name' => 'Financial Reports',      'icon' => 'bi-bar-chart'],
            ['name' => 'Audit Reports',          'icon' => 'bi-clipboard-check'],
            ['name' => 'Policies',               'icon' => 'bi-book'],
            ['name' => 'Bylaws',                 'icon' => 'bi-journal-text'],
            ['name' => 'Strategic Plans',        'icon' => 'bi-bullseye'],
            ['name' => 'Procurement Documents',  'icon' => 'bi-cart3'],
            ['name' => 'Public Notices',         'icon' => 'bi-megaphone'],
            ['name' => 'Client Charter',         'icon' => 'bi-award'],
            ['name' => 'Other Documents',        'icon' => 'bi-file-earmark'],
        ];

        foreach ($categories as $i => $cat) {
            DocumentCategory::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                array_merge($cat, ['slug' => Str::slug($cat['name']), 'is_active' => true, 'sort_order' => $i + 1])
            );
        }

        $this->command->info('Document categories seeded.');
    }
}
