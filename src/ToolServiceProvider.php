<?php

namespace EagleDevelopers\NovaRouteViewer;

use EagleDevelopers\NovaRouteViewer\Http\Middleware\Authorize;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'route-viewer');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            //
        });

        $this->publishes([
            __DIR__.'/../config/nova-route-viewer.php' => config_path('nova-route-viewer.php'),
        ], 'nova-config');
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/eagle-developers/nova-route-viewer')
                ->group(__DIR__. '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/nova-route-viewer.php', 'nova-route-viewer'
        );
    }
}
