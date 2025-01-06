<?php

namespace Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Phu1237\AwesomeValidation\ServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }
}
