<?php

namespace DebugMx\OuraRing;

use Illuminate\Support\Str;

class OuraRing
{
    /**
     * The Laravel application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Normalized Laravel Version
     *
     * @var string
     */
    protected $version;

    /**
     * True when booted.
     *
     * @var bool
     */
    protected $booted = false;

    /**
     * True when enabled, false disabled an null for still unknown
     *
     * @var bool
     */
    protected $enabled = null;

    /**
     * True when this is a Lumen application
     *
     * @var bool
     */
    protected $is_lumen = false;

    /**
     * @param Application $app
     */
    public function __construct($app = null)
    {
        if (!$app) {
            $app = app();   //Fallback when $app is not given
        }
        $this->app = $app;
        $this->version = $app->version();
        $this->is_lumen = Str::contains($this->version, 'Lumen');
    }

    public function boot()
    {
        if ($this->booted) {
            return;
        }

        /** @var \DebugMx\OuraRing\OuraRing $ouraring */
        $ouraring = $this;

        /** @var Application $app */
        $app = $this->app;

        // Set custom error handler
        if ($app['config']->get('ouraring.error_handler', false)) {
            set_error_handler([$this, 'handleError']);
        }

        $this->scopes = $this->app['config']->get('ouraring.scopes.api', ['email', 'personal', 'daily']);
    }

    public function scopes()
    {
        return $this->app['config']->get('ouraring.base_uri.api', '');
    }

    public function authorizeBaseUri()
    {
        return $this->app['config']->get('ouraring.base_uri.authorize', '');
    }

    public function apiBaseUri()
    {
        return $this->app['config']->get('ouraring.base_uri.api', '');
    }

    public function apiPrefix()
    {
        return $this->app['config']->get('ouraring.api_prefix', 'v1');
    }

    public function endpointUrl(string $uri): string
    {
        return $this->apiBaseUri() . $uri;
    }

    public function buildActionUrl(string $action): string
    {
        return $this->endpointUrl('/' . $this->apiPrefix() . '/' . $action);
    }

    /**
     * Handle silenced errors
     *
     * @param $level
     * @param $message
     * @param string $file
     * @param int $line
     * @param array $context
     * @throws \ErrorException
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        if (error_reporting() & $level) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        } else {
            $this->addMessage($message, 'deprecation');
        }
    }

    /**
     * Magic calls for adding messages
     *
     * @param string $method
     * @param array $args
     * @return mixed|void
     */
    public function __call($method, $args)
    {
        $messageLevels = ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug', 'log'];
        if (in_array($method, $messageLevels)) {
            foreach ($args as $arg) {
                $this->addMessage($arg, $method);
            }
        }
    }

    /**
     * Check the version of Laravel
     *
     * @param string $version
     * @param string $operator (default: '>=')
     * @return boolean
     */
    protected function checkVersion($version, $operator = ">=")
    {
        return version_compare($this->version, $version, $operator);
    }

    protected function isLumen()
    {
        return $this->is_lumen;
    }
}
