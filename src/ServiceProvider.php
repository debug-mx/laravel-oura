<?php

namespace DebugMx\OuraRing;

use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function register()
    {
        $configPath = __DIR__ . '/../config/ouraring.php';
        $this->mergeConfigFrom($configPath, 'ouraring');

        $this->app->singleton(OuraRing::class, function () {
            $ouraring = new OuraRing($this->app);

            /*if ($this->app->bound(SessionManager::class)) {
                $sessionManager = $this->app->make(SessionManager::class);
                $httpDriver = new SymfonyHttpDriver($sessionManager);
                $debugbar->setHttpDriver($httpDriver);
            }*/

            return $ouraring;
        });

        $this->app->alias(OuraRing::class, 'ouraring');
    }

    public function boot()
    {
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('ouraring.php')], 'config');
    }

    /**
     * Get the active router.
     *
     * @return Router
     */
    protected function getRouter()
    {
        return $this->app['router'];
    }
}
