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
php artisan vendor:publish --provider="Spatie\Dashboard\DashboardServiceProvider" --tag="mailcoach-migrations"
php artisan migrate
```

You must publish the `dashboard` config file with this command.

```bash
php artisan vendor:publish --provider="Spatie\Dashboard\DashboardServiceProvider" --tag="dashboard-config"
```
