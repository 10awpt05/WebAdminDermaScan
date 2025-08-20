<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FirebaseService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FirebaseService::class, function ($app) {
            return new FirebaseService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Force HTTPS in production
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        // Handle Firebase service account file
        if ($this->app->environment('production') && env('FIREBASE_JSON')) {
            $firebasePath = base_path('firebase.json');
            if (!file_exists($firebasePath)) {
                file_put_contents($firebasePath, env('FIREBASE_JSON'));
            }
        }
    }
}
