---
title: Time and Weather tile
weight: 3
---

This tile displays the time, weather, and optionally a rain forecast.

![screenshot](https://spatie.be/docs/laravel-dashboard/v2/images/time-weather.png)

## Installation

You can install the tile via composer:

```bash
composer require spatie/laravel-dashboard-time-weather-tile
```

In the `dashboard` config file, you must add this configuration in the `tiles` key.

Sign up at https://openweathermap.org/ to obtain `OPEN_WEATHER_MAP_KEY`

Head to https://www.buienradar.nl/ to get your cities `BUIENRADAR_LATITUDE`and `BUIENRADAR_LONGITUDE`

```php
// in config/dashboard.php

return [
    // ...
    'tiles' => [
        'time_weather' => [
            'open_weather_map_key' => env('OPEN_WEATHER_MAP_KEY'),
            'open_weather_map_city' => 'Antwerp',
            'units' => 'metric', // 'metric' or 'imperial' (metric is default)
            'buienradar_latitude' => env('BUIENRADAR_LATITUDE'),
            'buienradar_longitude' => env('BUIENRADAR_LONGITUDE'),
        ],
    ],
];
```

In `app\Console\Kernel.php` you should schedule the `Spatie\TimeWeatherTile\FetchOpenWeatherMapDataCommand` to run every minute. 

If you want to rain forecast, and the Buienradar service supports your location, you can optionally schedule the `Spatie\TimeWeatherTile\FetchBuienradarForecastsCommand` too.

```php
// in app/console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // ...
    $schedule->command(\Spatie\TimeWeatherTile\Commands\FetchOpenWeatherMapDataCommand::class)->everyMinute();
    $schedule->command(\Spatie\TimeWeatherTile\Commands\FetchBuienradarForecastsCommand::class)->everyMinute();
}
```

## Usage

In your dashboard view you use the `livewire:time-weather-tile` component.

```html
<x-dashboard>
    <livewire:time-weather-tile position="a1" />
</x-dashboard>
```

### Customizing the view

If you want to customize the view used to render this tile, run this command:

```bash
php artisan vendor:publish --provider="Spatie\TimeWeatherTile\TimeWeatherTileServiceProvider" --tag="dashboard-time-weather-tile-views"
```
