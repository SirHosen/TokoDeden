<?php
// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register services for production
        if ($this->app->environment('production')) {
            $this->app->bind('path.public', function() {
                return base_path('public_html');
            });
        }
    }

    public function boot(): void
    {
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }

        // Set default string length for MySQL
        Schema::defaultStringLength(191);

        // Use Bootstrap pagination
        Paginator::useBootstrapFive();

        // Trust all proxies for shared hosting
        if (config('app.env') === 'production') {
            // In Laravel 11, we can just use an integer for all headers (value 1)
            // or configure this in the TrustProxies middleware directly
            // For now, let's use the Request::HEADER_X_FORWARDED_ALL replacement
            $this->app['request']->setTrustedProxies(
                ['*'],
                1
            );
        }
    }
}
