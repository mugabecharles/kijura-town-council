<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name',    'value' => 'Kijura Town Council', 'group' => 'general', 'type' => 'text',  'label' => 'Site Name'],
            ['key' => 'site_tagline', 'value' => 'Together for Development', 'group' => 'general', 'type' => 'text', 'label' => 'Tagline'],
            ['key' => 'site_description', 'value' => 'Official website of Kijura Town Council, Burahya County, Kabarole District, Western Uganda.', 'group' => 'general', 'type' => 'textarea', 'label' => 'Site Description'],
            ['key' => 'site_logo',    'value' => '', 'group' => 'general', 'type' => 'image',  'label' => 'Site Logo'],
            ['key' => 'site_favicon', 'value' => '', 'group' => 'general', 'type' => 'image',  'label' => 'Favicon'],

            // Contact
            ['key' => 'site_phone',   'value' => '+256 XXX XXX XXX', 'group' => 'contact', 'type' => 'text', 'label' => 'Phone'],
            ['key' => 'site_phone2',  'value' => '',                 'group' => 'contact', 'type' => 'text', 'label' => 'Phone 2'],
            ['key' => 'site_email',   'value' => 'info@kijuratowncouncil.go.ug', 'group' => 'contact', 'type' => 'text', 'label' => 'Email'],
            ['key' => 'site_address', 'value' => 'Kijura Town Council, Burahya County, Kabarole District, Western Uganda', 'group' => 'contact', 'type' => 'textarea', 'label' => 'Address'],
            ['key' => 'office_hours', 'value' => 'Monday – Friday: 8:00 AM – 5:00 PM', 'group' => 'contact', 'type' => 'text', 'label' => 'Office Hours'],
            ['key' => 'map_embed_url','value' => '', 'group' => 'contact', 'type' => 'text', 'label' => 'Google Maps Embed URL'],
            ['key' => 'map_latitude', 'value' => '0.8169', 'group' => 'contact', 'type' => 'text', 'label' => 'Latitude'],
            ['key' => 'map_longitude','value' => '30.4175', 'group' => 'contact', 'type' => 'text', 'label' => 'Longitude'],

            // Social
            ['key' => 'facebook_url', 'value' => '', 'group' => 'social', 'type' => 'text', 'label' => 'Facebook URL'],
            ['key' => 'twitter_url',  'value' => '', 'group' => 'social', 'type' => 'text', 'label' => 'Twitter/X URL'],
            ['key' => 'youtube_url',  'value' => '', 'group' => 'social', 'type' => 'text', 'label' => 'YouTube URL'],
            ['key' => 'whatsapp_number', 'value' => '', 'group' => 'social', 'type' => 'text', 'label' => 'WhatsApp Number'],

            // SEO
            ['key' => 'meta_title',   'value' => 'Kijura Town Council — Official Website', 'group' => 'seo', 'type' => 'text', 'label' => 'Default Meta Title'],
            ['key' => 'meta_description', 'value' => 'Official website of Kijura Town Council, Burahya County, Kabarole District. News, projects, services, tenders and citizen engagement.', 'group' => 'seo', 'type' => 'textarea', 'label' => 'Default Meta Description'],
            ['key' => 'og_image',     'value' => '', 'group' => 'seo', 'type' => 'image', 'label' => 'Default OG Image'],
            ['key' => 'google_analytics_id', 'value' => '', 'group' => 'seo', 'type' => 'text', 'label' => 'Google Analytics ID'],

            // Homepage
            ['key' => 'homepage_vision',  'value' => 'A well planned, economically vibrant and healthy Kijura Town Council.', 'group' => 'homepage', 'type' => 'textarea', 'label' => 'Vision Statement'],
            ['key' => 'homepage_mission', 'value' => 'To provide quality services equitably and improve livelihood of people.', 'group' => 'homepage', 'type' => 'textarea', 'label' => 'Mission Statement'],
            ['key' => 'homepage_motto',   'value' => 'Together for Development', 'group' => 'homepage', 'type' => 'text', 'label' => 'Motto'],

            // Council Facts
            ['key' => 'fact_established', 'value' => '1 July 2010',     'group' => 'facts', 'type' => 'text', 'label' => 'Established'],
            ['key' => 'fact_location',    'value' => 'Burahya County, Kabarole District', 'group' => 'facts', 'type' => 'text', 'label' => 'Location'],
            ['key' => 'fact_distance',    'value' => 'Approximately 30 km North-East of Fort Portal City', 'group' => 'facts', 'type' => 'text', 'label' => 'Distance from Fort Portal'],
            ['key' => 'fact_wards',       'value' => '4',                'group' => 'facts', 'type' => 'text', 'label' => 'Number of Wards'],
            ['key' => 'fact_elevation',   'value' => '1,513 m',          'group' => 'facts', 'type' => 'text', 'label' => 'Elevation'],
            ['key' => 'fact_economy',     'value' => 'Tea, agriculture, trade, markets', 'group' => 'facts', 'type' => 'text', 'label' => 'Key Economic Activities'],
        ];

        foreach ($settings as $s) {
            Setting::firstOrCreate(['key' => $s['key']], $s);
        }

        $this->command->info('Settings seeded.');
    }
}
