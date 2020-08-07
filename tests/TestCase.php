<?php

namespace DebugMx\OuraRing\Tests;

use DebugMx\OuraRing\OuraRing;
use DebugMx\OuraRing\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    private OuraRing $ouraring;

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'OuraRing' => 'Debugmx\OuraRing\Facade'
        ];
    }

    public function getEnvironmentSetUp($app)
    {
    }

    public function ouraring(): OuraRing
    {
        return $this->ouraring ?? $this->ouraring = $this->app->ouraring;
    }
}
