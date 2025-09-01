<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Bootstrap for pagination
        Paginator::useBootstrap();

        // Format Currency Blade Directive
        Blade::directive('currency', function ($expression) {
            return "<?php echo 'Rp ' . number_format($expression, 0, ',', '.'); ?>";
        });

        // Stock Status Blade Directive
        Blade::directive('stockStatus', function ($expression) {
            return "<?php echo $expression > 0 ? '<span class=\"text-green-600\">Tersedia</span>' : '<span class=\"text-red-600\">Habis</span>'; ?>";
        });
    }
}
