---
name: laravel-dashboard-development
description: Build custom dashboard tiles for spatie/laravel-dashboard v4 using Livewire 4, Tailwind CSS 4, and CSS Grid
---

# Laravel Dashboard Development

`spatie/laravel-dashboard` is a package for building real-time dashboards displayed on wall-mounted screens. It uses **Livewire 4**, **Tailwind CSS 4** (via browser CDN), and **CSS Grid** for layout.

## Creating a Custom Tile

### 1. Livewire Component

Create a Livewire component extending `BaseTileComponent`:

```php
namespace App\Livewire;

use Livewire\Component;
use Spatie\Dashboard\Components\BaseTileComponent;
use Spatie\Dashboard\Models\Tile;

class WeatherTile extends BaseTileComponent
{
    public function render()
    {
        return view('livewire.weather-tile', [
            'weather' => Tile::firstOrCreateForName('weather')->getData('current'),
        ]);
    }
}
```

Key points:
- `$position` is inherited from `BaseTileComponent` — do not add it or override `mount()`
- `#[Defer]` is inherited — skeleton loading works automatically via `placeholder()`
- No `mount()` method needed unless you have additional initialization

### 2. Blade View

Wrap your tile content in the `<x-dashboard-tile>` component, always passing `:position`:

```blade
<x-dashboard-tile :position="$position">
    <h1 class="text-2xl font-bold text-default">Weather</h1>
    <p class="text-dimmed">{{ $weather['temperature'] ?? '--' }}°C</p>
</x-dashboard-tile>
```

### 3. Register the Component

Register with Livewire in a service provider:

```php
use Livewire\Livewire;

Livewire::component('weather-tile', \App\Livewire\WeatherTile::class);
```

## Storing & Retrieving Data

Use the `Tile` model to persist data between requests:

```php
use Spatie\Dashboard\Models\Tile;

// Store data
Tile::firstOrCreateForName('weather')->putData('current', [
    'temperature' => 22,
    'description' => 'Sunny',
]);

// Retrieve data
$data = Tile::firstOrCreateForName('weather')->getData('current');
```

### Fetching External Data

Create an Artisan command to fetch data from APIs:

```php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Dashboard\Models\Tile;

class FetchWeatherCommand extends Command
{
    protected $signature = 'dashboard:fetch-weather';

    protected $description = 'Fetch weather data for the dashboard';

    public function handle(): void
    {
        $weather = Http::get('https://api.example.com/weather')->json();

        Tile::firstOrCreateForName('weather')->putData('current', $weather);

        $this->comment('Weather data fetched.');
    }
}
```

Schedule it in your application's console kernel or `routes/console.php`:

```php
Schedule::command('dashboard:fetch-weather')->everyFiveMinutes();
```

## Dashboard Setup

### Route

```php
Route::get('/dashboard', function () {
    return view('dashboard');
});
```

### Dashboard View

```blade
<x-dashboard>
    <livewire:weather-tile position="a1" />
    <livewire:calendar-tile position="b1:b2" />
    <livewire:stats-tile position="a2" />
</x-dashboard>
```

The `<x-dashboard>` component provides the full HTML page with Tailwind CSS 4 and theming.

## Grid Positioning

Tiles use Excel-like notation where **columns = letters** and **rows = numbers**:

- `a1` — column A, row 1 (single cell)
- `a1:b2` — spans from column A row 1 to column B row 2 (2x2 area)
- `a1:c1` — spans columns A through C in row 1

The grid auto-sizes based on the positions you use.

## Tile Props

The `<x-dashboard-tile>` component accepts these props:

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `position` | `string` | required | Grid position (Excel notation) |
| `refresh-interval` | `?int` | `null` | Livewire polling interval in seconds |
| `title` | `?string` | `null` | Tile title |
| `fade` | `bool` | `true` | Fade out content at bottom edge |
| `show` | `bool` | `true` | Show/hide tile |

## Theming

### Color Utilities

The dashboard provides Tailwind color utilities that adapt to light/dark mode:

| Utility | Light Mode | Dark Mode | Usage |
|---------|-----------|-----------|-------|
| `text-default` | dark text | white text | Primary text |
| `text-dimmed` | muted dark | muted white | Secondary text |
| `text-invers` | white text | dark text | Inverted text |
| `text-accent` | blue | orange | Accented text |
| `bg-canvas` | light gray | dark gray | Page background |
| `bg-tile` | white | dark surface | Tile background |
| `text-success` | green | dark green | Success states |
| `text-warning` | orange | dark orange | Warning states |
| `text-error` | red | pink-red | Error states |

These work with any Tailwind utility (`text-*`, `bg-*`, `border-*`, etc.).

### Theme Configuration

In `config/dashboard.php`:

```php
return [
    'theme' => 'light', // light, dark, device, auto
    'auto_theme_location' => [
        'lat' => 51.260197,
        'lng' => 4.402771,
    ],
];
```

- `light` / `dark` — fixed mode
- `device` — follows OS preference
- `auto` — light when sun is up, dark when sun is down (uses lat/lng)

## Custom Assets

Register additional scripts or stylesheets via the `Dashboard` service:

```php
use Spatie\Dashboard\Dashboard;

app(Dashboard::class)->script('https://cdn.example.com/chart.js');
app(Dashboard::class)->stylesheet('https://cdn.example.com/extra.css');
app(Dashboard::class)->inlineScript('console.log("loaded")');
app(Dashboard::class)->inlineStylesheet('.custom { color: red; }');
```

## Grid Template Utilities

The dashboard includes Tailwind theme utilities for grid layouts inside tiles:

- `grid-cols-1-1`, `grid-cols-1-auto`, `grid-cols-auto-1`, `grid-cols-auto-auto`, etc.
- `grid-rows-1-1`, `grid-rows-1-auto`, `grid-rows-auto-1`, `grid-rows-auto-auto`, etc.

## Do / Don't

- **Do** extend `BaseTileComponent`, not `Livewire\Component` directly
- **Do** always pass `:position="$position"` to `<x-dashboard-tile>`
- **Do** use the `Tile` model for data persistence
- **Do** use `text-default`, `text-dimmed`, etc. for theme-aware colors
- **Don't** add a `$position` property or `mount()` just for position — it's inherited
- **Don't** add `#[Defer]` to your tile — it's inherited from `BaseTileComponent`
- **Don't** use `env()` calls outside config files
- **Don't** store large datasets in tiles — keep data lean for fast rendering
