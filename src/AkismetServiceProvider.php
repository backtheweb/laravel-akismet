<?php

namespace Backtheweb\Akismet;

use Illuminate\Support\ServiceProvider;

class AkismetServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/akismet.php' => config_path('akismet.php')],   'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Backtheweb\Akismet\Akismet', function($app) {

            $config  = $app['config']->get('akismet');

            return new Akismet($config['key'], $config['url']);

        });

        $this->app->alias('Backtheweb\Akismet\Akismet', 'Akismet');
    }

    public function provides()
    {
        return ['Backtheweb\Akismet\Akismet', 'Akismet'];
    }
}
