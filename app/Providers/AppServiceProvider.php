<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        Paginator::defaultView('vendor.pagination.custom');
        Paginator::defaultSimpleView('vendor.pagination.custom');

        \Illuminate\Support\Facades\Blade::directive('khr', function ($expression) {
            return "<?php echo number_format(round(floatval($expression) * 4100, -2)) . ' ៛'; ?>";
        });
    }
}

if (!function_exists('format_khr')) {
    function format_khr($usd)
    {
        return number_format(round(floatval($usd) * 4100, -2)) . ' ៛';
    }
}
