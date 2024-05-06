<?php

namespace Stepanenko3\NovaHealth;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Stepanenko3\NovaHealth\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->config();

        $this->app->booted(function (): void {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event): void {
            Nova::style('nova-health', __DIR__ . '/../dist/css/tool.css');
            //
        });
    }

    public function register(): void
    {
        //
    }

    protected function routes(): void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        $path = config('nova-health.path', 'health');

        Nova::router(['nova', Authorize::class], $path)
            ->group(__DIR__ . '/../routes/inertia.php');

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/stepanenko3/nova-health')
            ->group(__DIR__ . '/../routes/api.php');
    }

    private function config(): void
    {
        if ($this->app->runningInConsole()) {
            // Publish config
            $this->publishes([
                __DIR__ . '/../config/' => config_path(),
            ], 'config');
        }

        $this->mergeConfigFrom(
            __DIR__ . '/../config/nova-health.php',
            'nova-health'
        );
    }
}
