<?php

namespace Spatie\Dashboard;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
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

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard');

        Blade::component('dashboard::page', 'dashboard-page');
        Blade::component('dashboard::dashboard', 'dashboard');
        Blade::component(DashboardTileComponent::class, 'dashboard-tile');
    }
}
