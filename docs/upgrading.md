---
title: Upgrading
weight: 5
---

## From v3 to v4

### Requirements

- PHP 8.3+
- Laravel 11+
- Livewire 4

### Theme and Mode enums

`Dashboard::getTheme()` now returns a `Spatie\Dashboard\Enums\Theme` enum instead of a string. `Dashboard::getMode()` now returns a `Spatie\Dashboard\Enums\Mode` enum instead of a string.

```php
// Before
$theme = $dashboard->getTheme(); // 'light'
$mode = $dashboard->getMode(); // 'light'

// After
$theme = $dashboard->getTheme(); // Theme::Light
$mode = $dashboard->getMode(); // Mode::Light

// To get the string value
$theme->value; // 'light'
$mode->value; // 'light'
```

If you published the dashboard views, update `dashboard.blade.php` to use `->value`:

```blade
{{-- Before --}}
x-data="theme('{{ $theme }}', '{{ $initialMode }}')"

{{-- After --}}
x-data="theme('{{ $theme->value }}', '{{ $initialMode->value }}')"
```

### Tailwind CSS 4

The dashboard now uses Tailwind CSS 4 with the `@tailwindcss/browser` CDN. If you published the dashboard views, update them to use the new Tailwind 4 `@theme` directive instead of a `tailwind.config.js` file.

### Tile model changes

The `Tile` model now uses `$fillable = ['name', 'data']` instead of `$guarded = []`. If you are mass-assigning additional attributes, extend the model and add those attributes to `$fillable`.

The `Tile` model now uses the `casts()` method instead of the `$casts` property. If you are extending the `Tile` model and overriding casts, update to the method syntax:

```php
// Before
protected $casts = [
    'data' => 'array',
];

// After
protected function casts(): array
{
    return [
        'data' => 'array',
    ];
}
```

### `refreshIntervalInSeconds` renamed to `refreshInterval`

The `$refreshIntervalInSeconds` property on `DashboardTileComponent` has been renamed to `$refreshInterval`. This does not affect Blade usage since the attribute was already `refresh-interval`.

If you published the tile view, update `tile.blade.php`:

```blade
{{-- Before --}}
{{ $refreshIntervalInSeconds ? "wire:poll.{$refreshIntervalInSeconds}s" : '' }}

{{-- After --}}
{{ $refreshInterval ? "wire:poll.{$refreshInterval}s" : '' }}
```

### New `BaseTileComponent` class

A new `Spatie\Dashboard\Components\BaseTileComponent` abstract class is available. It extends Livewire's `Component`, includes a `$position` property, the `#[Defer]` attribute for lazy-loading, and a skeleton placeholder. You can use it as the base class for your tiles instead of `Livewire\Component`.

### New `lazy` and `defer` props on `<x-dashboard-tile>`

The `<x-dashboard-tile>` Blade component now accepts `lazy` and `defer` boolean props for controlling Livewire's lazy-loading behavior.

### Migration stub uses anonymous class

The migration stub now uses an anonymous class. If you have already published and run the migration, no action is needed.

## From v2 to v3

This release supports Livewire v3. There are no other breaking changes

If you have any error, you can check livewire 3 upgrade guide https://livewire.laravel.com/docs/upgrading

You can also try the command which can help if you have have created some custom iiles (->emit() became ->dispatch() for example)

```php artisan livewire:upgrade```

Don't forget to specify your APP_URL in .env, and to clear cache, config, etc... with ```php artisan optimize:clear```
