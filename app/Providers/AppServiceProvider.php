<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Migrations\Migrator; // <--- penting ditambahkan

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
        // Tambahkan path custom untuk migration ekskul
        $this->app->afterResolving(Migrator::class, function ($migrator) {
            $migrator->path(database_path('migrations/ekskul'));
        });
    }
}
