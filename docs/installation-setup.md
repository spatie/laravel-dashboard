---
title: Installation & setup
weight: 4
---

You can install the package via composer:

```bash
composer require spatie/laravel-dashboard
```

To create the `dashboard_tiles` table, you must create and run the migration.

```bash
php artisan vendor:publish --provider="Spatie\Dashboard\DashboardServiceProvider" --tag="dashboard-migrations"
php artisan migrate
```

You must publish the `dashboard` config file with this command.

```bash
php artisan vendor:publish --provider="Spatie\Dashboard\DashboardServiceProvider" --tag="dashboard-config"
```

This is the content of the published config file:

```php
return [
    /*
     * The dashboard supports these themes:
     *
     * - light: always use light mode
     * - dark: always use dark mode
     * - device: follow the OS preference for determining light or dark mode
     * - auto: use light mode when the sun is up, dark mode when the sun is down
     */
    'theme' => 'light',

    /*
     * When the dashboard uses the `auto` theme, these coordinates will be used
     * to determine whether the sun is up or down
     */
    'auto_theme_location' => [
        'lat' => 51.260197,
        'lng' => 4.402771,
    ],
];
```

