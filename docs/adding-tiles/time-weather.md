---
title: Google calendar tile
weight: 3
---

This tile displays the time, weather, and optionally a rain forecast.

![screenshot](TODO: add link)

## Installation

You can install the tile via composer:

```bash
composer require spatie/laravel-dashboard-time-weather-tile
```

You must also [set up](https://github.com/spatie/laravel-google-calendar#installation) the `spatie/laravel-google-calendar` package. That package will fetch data for Google Calendar. Here are instructions that show how you can [obtain credentials to communicate with Google Calendar](https://github.com/spatie/laravel-google-calendar#how-to-obtain-the-credentials-to-communicate-with-google-calendar).

In the `dashboard` config file, you must add this configuration in the `tiles` key. The `ids` should contain any calendar id that you want to display on the dashboard.

```php
// in config/dashboard.php

return [
    // ...
    'tiles' => [
        'time_weather' => [
            'open_weather_map_key' => env('OPEN_WEATHER_MAP_KEY'),
            'open_weather_map_city' => 'Antwerp',
            'buienradar_latitude' => env('BUIENRADAR_LATITUDE'),
            'buienradar_longitude' => env('BUIENRADAR_LONGITUDE'),
        ],
];
```

In `app\Console\Kernel.php` you should schedule the `Spatie\CalendarTile\FetchOpenWeatherMapDataCommand` to run every minute. 

If you want to rain forecast, and the Buienradar service supports your location, you can optionally schedule the `Spatie\CalendarTile\FetchBuienradarForecastsCommand` too.

```php
// in app/console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // ...
    $schedule->command(Spatie\CalendarTile\FetchOpenWeatherMapDataCommand::class)->everyMinute();
    $schedule->command(Spatie\CalendarTile\FetchBuienradarForecastsCommand::class)->everyMinute();
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
php artisan vendor:publish --provider="Spatie\CalendarTile\CalendarTileServiceProvider" --tag="dashboard-calendar-tile-views"
```
