<?php

namespace Phu1237\AwesomeValidation;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/awesome_validation.php', 'awesome_validation'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void {
        $this->publishes([
            __DIR__ . '/../config/awesome_validation.php', config_path('awesome_validation')
        ]);
    }
}
