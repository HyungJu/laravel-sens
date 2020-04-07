<?php

namespace NotificationChannels\Sens;

use GuzzleHttp\Client as HttpClient;
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
                return (new Sens(
                    config('services.sens.x-ncp-iam-access-key'),
                    config('services.sens.x-ncp-secret-key'),
                    config('services.sens.serviceid')
                ))->setDefaultFrom(config('services.sens.from')
                  ->setDefaultTimezone(config('services.sens.timezone'))
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
