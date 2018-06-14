<?php

namespace Elimuswift\SMS;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/sms.php' => config_path('sms.php'),
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/sms.php',
            'sms'
        );
        $this->registerSender();
        $this->app->bind('sms', function ($app) {
            $sms = new SMS($app['sms.sender'], $app);
            //Set the from setting
            if ($app['config']->has('sms.from')) {
                $sms->alwaysFrom($app['config']->get('sms.from'));
            }

            return $sms;
        });
    }

    /**
     * Register the correct driver based on the config file.
     */
    public function registerSender()
    {
        $this->app->bind('sms.sender', function ($app) {
            return (new DriverManager($app))->driver();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sms', 'sms.sender'];
    }
}
