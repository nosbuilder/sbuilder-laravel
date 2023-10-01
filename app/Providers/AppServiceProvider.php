<?php

namespace App\Providers;

use App\Storage\SBuilderStorage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() : void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot() : void
    {
        //
    }
}
