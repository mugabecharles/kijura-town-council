<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'title'       => 'Welcome to Kijura Town Council',
                'subtitle'    => 'Serving our community through equitable and quality service delivery.',
                'image'       => 'sliders/placeholder-1.jpg',
                'button_text' => 'Explore Kijura',
                'button_url'  => '/about',
                'sort_order'  => 1,
            ],
            [
                'title'       => 'A Thriving Tea-Growing Community',
                'subtitle'    => 'Home to TAMTECO and Kamusanga Tea Factories and surrounding tea plantations.',
                'image'       => 'sliders/placeholder-2.jpg',
                'button_text' => 'Explore Our Economy',
                'button_url'  => '/economy',
                'sort_order'  => 2,
            ],
            [
                'title'       => 'Together for Development',
                'subtitle'    => 'Working with communities and partners to improve livelihoods and service delivery.',
                'image'       => 'sliders/placeholder-3.jpg',
                'button_text' => 'View Projects',
                'button_url'  => '/projects',
                'sort_order'  => 3,
            ],
            [
                'title'       => 'Supporting Our Farmers',
                'subtitle'    => 'Promoting agricultural productivity and sustainable livelihoods.',
                'image'       => 'sliders/placeholder-4.jpg',
                'button_text' => 'Agriculture & Production',
                'button_url'  => '/economy/agriculture',
                'sort_order'  => 4,
            ],
        ];

        foreach ($slides as $slide) {
            Slider::firstOrCreate(
                ['title' => $slide['title']],
                array_merge($slide, ['is_active' => true, 'duration' => 6000])
            );
        }

        $this->command->info('Slider placeholders seeded. Replace images through the CMS.');
    }
}
