---
title: Google calendar tile
weight: 3
---

This tile displays events on a Google calendar.

![screenshot](https://spatie.be/docs/laravel-dashboard/v2/images/calendar.png)

## Installation

You can install the tile via composer:

```bash
composer require spatie/laravel-dashboard-calendar-tile
```

You must also [set up](https://github.com/spatie/laravel-google-calendar#installation) the `spatie/laravel-google-calendar` package. That package will fetch data for Google Calendar. Here are instructions that show how you can [obtain credentials to communicate with Google Calendar](https://github.com/spatie/laravel-google-calendar#how-to-obtain-the-credentials-to-communicate-with-google-calendar).

In the `dashboard` config file, you must add this configuration in the `tiles` key. The `ids` should contain any calendar id that you want to display on the dashboard.

```php
// in config/dashboard.php

return [
    // ...
    'tiles' => [
        'calendar' => [
            'ids' => [
                env('GOOGLE_CALENDAR_ID'),
            ],
            'refresh_interval_in_seconds' => 60,
        ],
    ],
];
```

In `app\Console\Kernel.php` you should schedule the `Spatie\CalendarTile\FetchCalendarEventsCommand` to run. You can let in run every minute if you want. You could also run this less frequently if fast updates on the dashboard aren't that important for this tile.

```php
// in app/console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // ...
    $schedule->command(Spatie\CalendarTile\FetchCalendarEventsCommand::class)->everyMinute();
}
```

## Usage

In your dashboard view you use the `livewire:calendar-tile` component. You should pass the calendar id for your calendar to the `calendar-id` property.

```html
<x-dashboard>
    <livewire:calendar-tile position="e7:e16" :calendar-id="config('dashboard.tiles.calendar.ids.0')"/>
</x-dashboard>
```

### Customizing the view

If you want to customize the view used to render this tile, run this command:

```bash
php artisan vendor:publish --provider="Spatie\CalendarTile\CalendarTileServiceProvider" --tag="dashboard-calendar-tile-views"
```
