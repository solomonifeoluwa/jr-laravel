<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SecretRepositoryInterface;
use App\Repositories\SecretRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            SecretRepositoryInterface::class,
            SecretRepository::class
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
