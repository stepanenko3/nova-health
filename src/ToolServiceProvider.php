<?php

namespace Stepanenko3\NovaHealth;

use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Publish config
            $this->publishes([
                __DIR__ . '/../config/' => config_path(),
            ], 'config');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRoutes();

        $this->mergeConfigFrom(
            __DIR__ . '/../config/nova-health.php',
            'nova-health'
        );
    }

    protected function registerRoutes()
    {
        // Register nova routes
        Nova::router()->group(function ($router) {
            $path = config('nova-health.path', 'health');
            $router->get($path, fn () => inertia('NovaHealth', ['basePath' => $path]));
        });

        if ($this->app->routesAreCached()) return;

        Route::prefix('nova-vendor/stepanenko3/nova-health')
            ->group(__DIR__.'/../routes/api.php');
    }
}
