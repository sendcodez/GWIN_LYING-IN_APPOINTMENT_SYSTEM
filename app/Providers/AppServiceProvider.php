<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

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
        Blade::directive('isActiveRoute', function ($route) {
            return "<?php echo (Route::currentRouteName() == trim($route, \"'\")) ? 'active' : ''; ?>";
        });
    }

    
}
