<?php

namespace Spatie\Dashboard\Tests;

use CreateDashboardTilesTable;
use Illuminate\Support\Facades\Schema;
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

    /*
    protected function renderBladeString(string $bladeContent): string
    {
        $temporaryDirectory = sys_get_temp_dir();

        if (! in_array($temporaryDirectory, View::getFinder()->getPaths())) {
            View::addLocation(sys_get_temp_dir());
        }

        $tempFilePath = tempnam($temporaryDirectory, 'tests') . '.blade.php';

        file_put_contents($tempFilePath, $bladeContent);

        $bladeViewName = Str::before(pathinfo($tempFilePath, PATHINFO_BASENAME), '.blade.php');

        return view($bladeViewName)->render();
    }
    */
}
