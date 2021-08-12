<?php

namespace App\Extensions\Passwords;

use Illuminate\Auth\Passwords\PasswordResetServiceProvider as BasePasswordResetServiceProvider;

class CustomPasswordResetServiceProvider extends BasePasswordResetServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPasswordBroker();
    }

    /**
     * Register the password broker instance.
     *
     * @return void
     */
    protected function registerPasswordBroker()
    {
        $this->app->singleton('auth.password', function ($app) {
            return new CustomPasswordBrokerManager($app);
        });

        $this->app->bind('auth.password.broker', function ($app) {
            return $app->make('auth.password')->broker();
        });
    }

    public function provides()
    {
        return ['auth.password'];
    }
}
