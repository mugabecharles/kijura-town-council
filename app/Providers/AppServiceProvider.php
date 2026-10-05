<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Use Bootstrap 5 pagination
        Paginator::useBootstrapFive();

        // Trust all proxies on Render (load balancer terminates TLS)
        if (app()->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
            request()->setTrustedProxies(
                ['*'],
                \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_FOR |
                \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_HOST |
                \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PORT |
                \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PROTO
            );
        }

        // Share site settings with all views
        View::composer('*', function ($view) {
            try {
                $siteSettings = [
                    'site_name'   => Setting::get('site_name', 'Kijura Town Council'),
                    'site_tagline'=> Setting::get('site_tagline', 'Together for Development'),
                    'site_email'  => Setting::get('site_email', 'info@kijuratowncouncil.go.ug'),
                    'site_phone'  => Setting::get('site_phone', ''),
                    'site_address'=> Setting::get('site_address', 'Kijura, Burahya County, Kabarole District'),
                    'site_logo'   => Setting::get('site_logo', ''),
                    'facebook_url'=> Setting::get('facebook_url', ''),
                    'twitter_url' => Setting::get('twitter_url', ''),
                    'youtube_url' => Setting::get('youtube_url', ''),
                ];
                $view->with('siteSettings', $siteSettings);
            } catch (\Exception $e) {
                $view->with('siteSettings', [
                    'site_name'   => 'Kijura Town Council',
                    'site_tagline'=> 'Together for Development',
                    'site_email'  => 'info@kijuratowncouncil.go.ug',
                    'site_phone'  => '',
                    'site_address'=> 'Kijura, Burahya County, Kabarole District',
                    'site_logo'   => '',
                    'facebook_url'=> '',
                    'twitter_url' => '',
                    'youtube_url' => '',
                ]);
            }
        });
    }
}
