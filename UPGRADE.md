# Upgrading to v4

## Requirements

- PHP 8.3+
- Laravel 11+
- Livewire 4

## Breaking Changes

### Theme and Mode enums

`Dashboard::getTheme()` now returns a `Spatie\Dashboard\Enums\Theme` enum instead of a string. `Dashboard::getMode()` now returns a new `Spatie\Dashboard\Enums\Mode` enum instead of a string.

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

### Tile model: `$guarded` replaced with `$fillable`

The `Tile` model now uses `$fillable = ['name', 'data']` instead of `$guarded = []`. If you are mass-assigning additional attributes on the `Tile` model, you will need to extend the model and add those attributes to `$fillable`.

### Tile model: `$casts` property replaced with `casts()` method

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

### Dashboard tile component: `refreshIntervalInSeconds` renamed to `refreshInterval`

The `$refreshIntervalInSeconds` property on `DashboardTileComponent` has been renamed to `$refreshInterval`. This does not affect Blade usage since the attribute was already `refresh-interval`.

If you published the tile view, update `tile.blade.php`:

```blade
{{-- Before --}}
{{ $refreshIntervalInSeconds ? "wire:poll.{$refreshIntervalInSeconds}s" : '' }}

{{-- After --}}
{{ $refreshInterval ? "wire:poll.{$refreshInterval}s" : '' }}
```

### Migration stub uses anonymous class

The migration stub now uses an anonymous class instead of a named `CreateDashboardTilesTable` class. If you have already published and run the migration, no action is needed. If you are publishing the migration for the first time, it will use the new format automatically.

### Fluent method return types changed from `self` to `static`

The fluent methods on `Dashboard` (`script()`, `inlineScript()`, `stylesheet()`, `inlineStylesheet()`) and the `DashboardServiceProvider` helper methods now return `static` instead of `self`. This only affects you if you were type-hinting the return value of these methods.

### Removed dead service provider binding

The contextual binding of `$defaultTheme` to `DashboardComponent` has been removed as it was unused. This should not affect any applications.
