<?php

namespace App\Providers;

use App\SoapPlugin;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() : void
    {
        $this->app->bind(
            abstract: SoapPlugin::class,
            concrete: static fn() => new SoapPlugin(wsdl: config('sbuilder.url') . '/cms/admin/soap.php?wsdl')
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() : void
    {
        //
    }
}
