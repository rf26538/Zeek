<?php

namespace App\Module;

use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        PluginManager::getInstance($this->app);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('TeachifyPlugins', function ($app) {
            return PluginManager::getInstance($app);
        });
    }
}
