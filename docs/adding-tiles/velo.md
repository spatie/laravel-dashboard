---
title: Velo tile
weight: 7
---

This tile displays the status of [Velo](https://www.velo-antwerpen.be/en), the Antwerp bike sharing system.

![screenshot](https://spatie.be/docs/laravel-dashboard/v2/images/velo.png)

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-dashboard-velo-tile
```

In the `dashboard` config file, you must add this configuration in the `tiles` key. The `ids` should contain the ids of the velo stations that you want to display on the dashboard.

```php
// in config/dashboard.php

return [
    // ...
    'tiles' => [
        'velo' => [
            'stations' => [],
            'refresh_interval_in_seconds' => 60,
        ],
    ],
];
```

In `app\Console\Kernel.php` you should schedule the `Spatie\VeloTile\FetchVeloStationsCommand` to run. You can let in run every minute if you want. You could also run is less frequently if you fast updates on the dashboard aren't that important for this tile.

```php
// in app/console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // ...
    $schedule->command(Spatie\VeloTile\FetchVeloStationsCommand::class)->everyMinute();
}
```

## Usage

In your dashboard view you use the `livewire:velo-tile` component. 

```html
<x-dashboard>
    <livewire:velo-tile position="a1" />
</x-dashboard>
```

### Customizing the view

If you want to customize the view used to render this tile, run this command:

```bash
php artisan vendor:publish --provider="Spatie\VeloTile\VeloTileServiceProvider" --tag="dashboard-velo-tile-views"
```
