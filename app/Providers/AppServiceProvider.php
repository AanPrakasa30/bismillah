<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\Interfaces\FileService::class, \App\Services\FilepoundServiceImpl::class);
        $this->app->bind(\App\Services\Interfaces\SpreadsheetService::class, \App\Services\SpreadsheetServiceImpl::class);
        $this->app->bind(\App\Services\Interfaces\SiswaService::class, \App\Services\SiswaServiceImpl::class);
        $this->app->bind(\App\Services\Interfaces\AbsenService::class, \App\Services\AbsenServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
