---
title: Oh Dear Uptime tile
weight: 4
---

This tile displays sites that [Oh Dear](https://ohdear.app) detects as down.

![screenshot](https://spatie.be/docs/laravel-dashboard/v2/images/oh-dear.png)

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-dashboard-oh-dear-uptime-tile
```

This package listens for events coming from Oh Dear using the `ohdearapp/laravel-ohdear-webhooks` package. Before you can use this tile, you must set up `laravel-ohdear-webhooks`. You'll find instructions [in this section in the Oh Dear docs](https://ohdear.app/docs/integrations/webhooks/laravel-package).

In the `dashboard` config file, you must add this configuration in the `tiles` key.

```php
// in config/dashboard.php

return [
    // ...
    'tiles' => [
        'oh_dear_uptime' => [
            'refresh_interval_in_seconds' => 5,
        ],
];
```

## Usage

In your dashboard view, you use the `livewire:oh-dear-uptime-tile` component.

```html
<x-dashboard>
    <livewire:oh-dear-uptime-tile position="a1:a3" />
</x-dashboard>
```

### Customizing the view

If you want to customize the view used to render this tile, run this command:

```bash
php artisan vendor:publish --provider="Spatie\OhDearUptimeTile\OhDearUptimeTileServiceProvider" --tag="dashboard-oh-dear-uptime-tile-views"
```
