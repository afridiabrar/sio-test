<?php

namespace App\Providers;

use App\Services\ProjectService;
use App\Services\UserProjectService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() {
        $this->app->bind(
            \App\Contracts\ProjectServiceInterface::class,
            \App\Services\ProjectService::class,
        );
        $this->app->bind(
            \App\Contracts\UserProjectServiceInterface::class,
            \App\Services\UserProjectService::class
        );
        $this->app->bind(
            \App\Contracts\TimeLogServiceInterface::class,
            \App\Services\TimeLogService::class
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
