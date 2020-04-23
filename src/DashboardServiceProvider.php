<?php

namespace Spatie\Dashboard;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Spatie\Dashboard\Http\Components\DashboardComponent;
use Spatie\Dashboard\Http\Components\DashboardTileComponent;

class DashboardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->make(Dashboard::class)
            ->script('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js')
            ->inlineStylesheet(file_get_contents(__DIR__.'/../resources/dist/dashboard.min.css'));

        if (! class_exists('CreateDashboardTilesTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_dashboard_tiles_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_dashboard_tiles_table.php'),
            ], 'migrations');
        }

        $this->publishes([
            __DIR__ . '/../config/dashboard.php' => config_path('dashboard.php'),
        ], 'dashboard-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dashboard'),
        ], 'dashboard-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard');

        Blade::component(DashboardComponent::class, 'dashboard');
        Blade::component(DashboardTileComponent::class, 'dashboard-tile');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/dashboard.php', 'dashboard');

        $this->app->singleton(Dashboard::class);
        $this->app->alias(Dashboard::class, 'dashboard');


        $this->app->singleton(Sun::class, function () {
            return new Sun(
                config('dashboard.auto_theme_location.lat'),
                config('dashboard.auto_theme_location.lng')
            );
        });

        $this->app->when(DashboardComponent::class)
            ->needs('$defaultTheme')
            ->give(config('dashboard.theme'));
    }
}
