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
        Blade::directive('isActiveRoute', function ($routes) {
            return "<?php 
                \$routesArray = explode(',', $routes);
                \$isActive = false;
                foreach (\$routesArray as \$route) {
                    if (Route::currentRouteName() == trim(\$route, \"'\")) {
                        \$isActive = true;
                        break;
                    }
                }
                echo \$isActive ? 'active' : '';
            ?>";
        });
        
    }

    
}
