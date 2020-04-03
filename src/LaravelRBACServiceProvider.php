<?php

namespace LaravelRBAC;

use Route;
use Illuminate\Support\ServiceProvider;

class LaravelRBACServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerLaravelRBAC();

        $this->publishConfigs();
        $this->publishViews();
        $this->publishMigrations();
    }

    public function boot()
    {
        $this->bindRoutes();
    }

    public function registerLaravelRBAC()
    {
        $this->app->singleton('laravelrbac', function ($app) {
            return new LaravelRBAC();
        });
    }

    protected function path($path)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . ltrim($path, '\\/');
    }

    protected function publishConfigs()
    {
        $sourceConfigFile = $this->path('config' . DIRECTORY_SEPARATOR . 'laravelrbac.php');
        $this->publishes([
            $sourceConfigFile => config_path('laravelrbac.php')
        ], 'laravelrbac-config');

        $this->mergeConfigFrom($sourceConfigFile, 'laravelrbac');
    }

    protected function publishViews()
    {
        $this->loadViewsFrom($this->path('resources' . DIRECTORY_SEPARATOR . 'views'), 'laravelrbac');
    }

    protected function publishMigrations()
    {
        $this->loadMigrationsFrom($this->path('migrations'));
    }

    protected function bindRoutes()
    {
        $controller = config('laravelrbac.controller');

        Route::get('roles', "{$controller}@getRoles");
    }
}