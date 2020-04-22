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
        $this->mergeConfigFrom(__DIR__.'/../config/dashboard.php', 'skeleton');

        $this->app->singleton(Sunrise::class, function () {
            return new Sunrise(
                config('dashboard.auto_theme_location.lat'),
                config('dashboard.auto_theme_location.lng')
            );
        });

        $this->app->when(DashboardComponent::class)
            ->needs('$defaultTheme')
            ->give(config('dashboard.theme'));
    }
}
