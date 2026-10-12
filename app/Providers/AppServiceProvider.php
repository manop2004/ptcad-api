<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Force HTTPS asset/URL generation when served behind an HTTPS proxy (ngrok, Cloudflare, Render)
        $proto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '';
        $host  = $_SERVER['HTTP_HOST'] ?? '';
        if ($proto === 'https' || str_contains($host, 'ngrok') || str_contains($host, 'trycloudflare.com') || str_contains($host, 'onrender.com')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
