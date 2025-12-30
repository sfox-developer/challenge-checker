<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Habit\Models\Habit;

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
        // Register morph map for polymorphic relationships
        Relation::morphMap([
            'challenge' => Challenge::class,
            'habit' => Habit::class,
        ]);

        // Force HTTPS in production
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Share auth state with all views (including error pages)
        view()->composer('*', function ($view) {
            try {
                $isAuth = auth()->check();
                $user = auth()->user();
                
                \Log::info('View Composer Auth State', [
                    'view' => $view->name(),
                    'isAuthenticated' => $isAuth,
                    'userId' => $user?->id,
                    'userName' => $user?->name,
                ]);
                
                $view->with('isAuthenticated', $isAuth);
                $view->with('currentUser', $user);
            } catch (\Exception $e) {
                \Log::warning('View Composer Auth Failed', [
                    'view' => $view->name() ?? 'unknown',
                    'error' => $e->getMessage(),
                ]);
                
                // If session is not available, default to not authenticated
                $view->with('isAuthenticated', false);
                $view->with('currentUser', null);
            }
        });
    }
}
