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

    /**
     * The dashboard title
     */
    'title' => 'Dashboard',

    /*
     * When the dashboard uses the `auto` theme, these coordinates will be used
     * to determine whether the sun is up or down.
     */
    'auto_theme_location' => [
        'lat' => 51.260197,
        'lng' => 4.402771,
    ],

    /*
     * These scripts will be loaded when the dashboard is displayed.
     */
    'scripts' => [
        'alpinejs' => 'https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js',
    ],

    /*
     * These stylesheets will be loaded when the dashboard is displayed.
     */
    'stylesheets' => [
        'inter' => 'https://rsms.me/inter/inter.css'
    ],
];
```

