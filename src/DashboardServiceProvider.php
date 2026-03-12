<?php

namespace Spatie\Dashboard;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Spatie\Dashboard\Components\DashboardComponent;
use Spatie\Dashboard\Components\DashboardTileComponent;
use Spatie\Dashboard\Components\UpdateModeComponent;
use Spatie\Sun\Sun;

class DashboardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $dashboard = $this->app->make(Dashboard::class);

        if ($inter = config('dashboard.stylesheets.inter')) {
            $dashboard->stylesheet($inter);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'dashboard');

        $this
            ->registerPublishables()
            ->registerBladeComponents()
            ->registerLivewireComponents();
    }

    public function register(): void
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
    }

    protected function registerPublishables(): static
    {
        $this->publishes([
            __DIR__.'/../database/migrations/create_dashboard_tiles_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_dashboard_tiles_table.php'),
        ], 'dashboard-migrations');

        $this->publishes([
            __DIR__.'/../config/dashboard.php' => config_path('dashboard.php'),
        ], 'dashboard-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/dashboard'),
        ], 'dashboard-views');

        return $this;
    }

    protected function registerBladeComponents(): static
    {
        Blade::component('dashboard', DashboardComponent::class);
        Blade::component('dashboard-tile', DashboardTileComponent::class);

        return $this;
    }

    protected function registerLivewireComponents(): static
    {
        Livewire::component('dashboard-update-mode', UpdateModeComponent::class);

        return $this;
    }
}
