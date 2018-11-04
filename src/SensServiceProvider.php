<?php

namespace NotificationChannels\Sens;

use Illuminate\Support\ServiceProvider;

class SensServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Bootstrap code here.

       
        $this->app->when(SensChannel::class)
            ->needs(Sens::class)
            ->give(function () {
                return new Sens(
                    config('sens.x-ncp-auth-key'),
config('sens.x-ncp-service-secret'),
config('sens.serviceid'),
                    new HttpClient()
                );
            });
        

    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
