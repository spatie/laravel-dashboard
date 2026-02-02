<?php

namespace Spatie\Dashboard\Tests;

use CreateDashboardTilesTable;
use Illuminate\Support\Facades\Schema;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Dashboard\DashboardServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            DashboardServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
    }

    protected function setUpDatabase()
    {
        Schema::dropIfExists('dashboard_tiles');

        include_once __DIR__.'/../database/migrations/create_dashboard_tiles_table.php.stub';
        (new CreateDashboardTilesTable)->up();
    }
}
