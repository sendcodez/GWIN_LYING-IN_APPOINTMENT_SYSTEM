<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Appointment;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Share appointment counts with all views using the layouts.sidebar
        View::composer('layouts.sidebar', function ($view) {
            $appointmentCounts = [
                'pending' => Appointment::where('status', 1)->count(),
                'approved' => Appointment::where('status', 2)->count(),
                'completed' => Appointment::where('status', 3)->count(),
                'cancelled' => Appointment::where('status', 4)->count(),
                'disapproved' => Appointment::where('status', 5)->count(),
            ];
            
            $view->with('appointmentCounts', $appointmentCounts);
        });
    }
}
