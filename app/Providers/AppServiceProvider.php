<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

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
            Paginator::useBootstrap();

            Gate::define('edit-user', function ($user, $currentUser) {
                return $user->id == $currentUser->id;
            });

            Gate::policy(User::class, UserPolicy::class);

    }
}
