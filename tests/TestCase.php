<?php

namespace Spatie\Dashboard\Tests;

use CreateDashboardTilesTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Dashboard\DashboardServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
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

    protected function setUpDatabase()
    {
        Schema::dropIfExists('dashboard_tiles');

        include_once __DIR__.'/../database/migrations/create_dashboard_tiles_table.php.stub';
        (new CreateDashboardTilesTable())->up();
    }

    protected function renderBladeString(string $bladeContent)
    {
        $tempFilePath = tempnam(sys_get_temp_dir(), 'tests') . '.blade.php';

        file_put_contents($tempFilePath, $bladeContent);

        View::addLocation(sys_get_temp_dir());

        $bladeViewName = Str::before(pathinfo($tempFilePath, PATHINFO_BASENAME), '.blade.php');

        return view($bladeViewName)->render();
    }
}
