---
title: Attendances tile
weight: 9
---

This tile displays who will be in the office this week, based upon Google calendar.

![screenshot](https://spatie.be/docs/laravel-dashboard/v2/images/attendances.png)

## Installation

You can install the tile via composer:

```bash
composer require spatie/laravel-dashboard-attendances-tile
```

You must also [set up](https://github.com/spatie/laravel-google-calendar#installation) the `spatie/laravel-google-calendar` package. That package will fetch data for Google Calendar. Here are instructions that show how you can [obtain credentials to communicate with Google Calendar](https://github.com/spatie/laravel-google-calendar#how-to-obtain-the-credentials-to-communicate-with-google-calendar).

In the `dashboard` config file, you must add this configuration in the `tiles` key.

The `emails` should contain the email addresses of the team. Each member should allow access to their calendar via the service account created earlier.

A team member works from home whenever he puts a keyword from `keywords.home` into the name of an event within his Google calendar. A team member works in the office when there is a keyword from the `keywords.office` list in the name of an event in his Google calendar.

When a team member has no events with any keywords from home or office, then the member will automatically work from the office. Unless `missingKeywordMeansAtOffice` is set to `false`, which will mean the team member works from home.

```php
// in config/dashboard.php

return [
    // ...
    'tiles' => [
        'attendances' => [
            'emails' =>  [
                'freek@spatie.be',
                'ruben@spatie.be',
                'vic@spatie.be',
            ],
            'keywords' => [
                'home' => ['thuis', 'verlof', 'ziek',],
                'office' => ['kantoor'],
            ],
            'missingKeywordMeansAtOffice' => true,
        ],
];
```

In `app\Console\Kernel.php` you should schedule the `Spatie\AttendancesTile\FetchAttendancesCommand` to run. You can let in run every minute if you want. You could also run this less frequently if fast updates on the dashboard aren't that important for this tile.

```php
// in app/console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // ...
    $schedule->command(Spatie\AttendancesTile\FetchAttendancesCommand::class)->everyMinute();
}
```

## Usage

In your dashboard view you use the `livewire:attendances-tile` component.

```html
<x-dashboard>
    <livewire:attendances-tile position="e7:e16"/>
</x-dashboard>
```

### Customizing the view

If you want to customize the view used to render this tile, run this command:

```bash
php artisan vendor:publish --provider="Spatie\AttendancesTile\AttendancesTileServiceProvider" --tag="dashboard-attendances-tile-views"
```
