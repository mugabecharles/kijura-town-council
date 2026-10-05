<?php

namespace Database\Seeders;

use App\Models\Village;
use App\Models\Ward;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WardsVillagesSeeder extends Seeder
{
    public function run(): void
    {
        $wards = [
            [
                'name' => 'Kahuna',
                'description' => 'Kahuna Ward — one of the four wards of Kijura Town Council.',
                'villages' => ['Kahuna A', 'Kahuna B'],
            ],
            [
                'name' => 'Kijura',
                'description' => 'Kijura Ward — the central ward of Kijura Town Council.',
                'villages' => ['Kijura A', 'Kijura B'],
            ],
            [
                'name' => 'Kaisagara',
                'description' => 'Kaisagara Ward — one of the four wards of Kijura Town Council.',
                'villages' => ['Kaisagara A', 'Kaisagara B'],
            ],
            [
                'name' => 'Kyererezi',
                'description' => 'Kyererezi Ward — one of the four wards of Kijura Town Council.',
                'villages' => ['Kyererezi A', 'Kyererezi B'],
            ],
        ];

        foreach ($wards as $i => $wardData) {
            $ward = Ward::firstOrCreate(
                ['slug' => Str::slug($wardData['name'])],
                [
                    'name'        => $wardData['name'],
                    'slug'        => Str::slug($wardData['name']),
                    'description' => $wardData['description'],
                    'is_active'   => true,
                    'sort_order'  => $i + 1,
                ]
            );

            foreach ($wardData['villages'] as $j => $villageName) {
                Village::firstOrCreate(
                    ['ward_id' => $ward->id, 'name' => $villageName],
                    [
                        'ward_id'    => $ward->id,
                        'name'       => $villageName,
                        'slug'       => Str::slug($villageName),
                        'is_active'  => true,
                        'sort_order' => $j + 1,
                    ]
                );
            }
        }

        $this->command->info('Wards and villages seeded. (Official village list should be verified and updated by council.)');
    }
}
