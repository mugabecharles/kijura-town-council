<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentsSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Administration',               'icon' => 'bi-building'],
            ['name' => 'Finance',                      'icon' => 'bi-cash-coin'],
            ['name' => 'Planning & Development',       'icon' => 'bi-map'],
            ['name' => 'Works & Infrastructure',       'icon' => 'bi-tools'],
            ['name' => 'Community Services',           'icon' => 'bi-people'],
            ['name' => 'Health Services',              'icon' => 'bi-heart-pulse'],
            ['name' => 'Education',                    'icon' => 'bi-book'],
            ['name' => 'Production & Agriculture',     'icon' => 'bi-tree'],
            ['name' => 'Natural Resources & Environment', 'icon' => 'bi-leaf'],
            ['name' => 'Trade & Industry',             'icon' => 'bi-shop'],
            ['name' => 'Human Resource Management',   'icon' => 'bi-person-badge'],
            ['name' => 'Internal Audit',               'icon' => 'bi-clipboard-check'],
            ['name' => 'Procurement',                  'icon' => 'bi-cart3'],
        ];

        foreach ($departments as $i => $dept) {
            Department::firstOrCreate(
                ['slug' => Str::slug($dept['name'])],
                array_merge($dept, [
                    'slug'            => Str::slug($dept['name']),
                    'is_active'       => true,
                    'show_on_website' => true,
                    'sort_order'      => $i + 1,
                ])
            );
        }

        $this->command->info('Departments seeded.');
    }
}
