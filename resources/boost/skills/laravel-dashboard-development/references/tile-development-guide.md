# Tile Development Reference Guide

## Complete Working Example

### Component

```php
namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Spatie\Dashboard\Components\BaseTileComponent;
use Spatie\Dashboard\Models\Tile;

class WeatherTile extends BaseTileComponent
{
    public function render()
    {
        return view('livewire.weather-tile', [
            'weather' => Tile::firstOrCreateForName('weather')->getData('current'),
            'updatedAt' => Tile::firstOrCreateForName('weather')->getData('updated_at'),
        ]);
    }
}
```

### Blade View

```blade
<x-dashboard-tile :position="$position" :title="'Weather'">
    <div class="grid grid-rows-auto-1 h-full">
        <div>
            @if($weather)
                <p class="text-4xl font-bold text-default">{{ $weather['temperature'] }}°C</p>
                <p class="text-dimmed mt-1">{{ $weather['description'] }}</p>
            @else
                <p class="text-dimmed">Waiting for data...</p>
            @endif
        </div>

        @if($updatedAt)
            <div class="self-end">
                <p class="text-xs text-dimmed">Updated {{ \Carbon\Carbon::parse($updatedAt)->diffForHumans() }}</p>
            </div>
        @endif
    </div>
</x-dashboard-tile>
```

### Artisan Command

```php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Spatie\Dashboard\Models\Tile;

class FetchWeatherCommand extends Command
{
    protected $signature = 'dashboard:fetch-weather';

    protected $description = 'Fetch current weather data for the dashboard';

    public function handle(): void
    {
        $this->info('Fetching weather data...');

        $response = Http::get('https://api.example.com/weather')->json();

        Tile::firstOrCreateForName('weather')->putData('current', [
            'temperature' => $response['temp'],
            'description' => $response['summary'],
        ]);

        Tile::firstOrCreateForName('weather')->putData('updated_at', now()->toISOString());

        $this->comment('Weather data updated.');
    }
}
```

### Scheduling

In `routes/console.php`:

```php
use Illuminate\Support\Facades\Schedule;

Schedule::command('dashboard:fetch-weather')->everyFiveMinutes();
```

### Registration

In `AppServiceProvider` or a dedicated service provider:

```php
use Livewire\Livewire;

public function boot(): void
{
    Livewire::component('weather-tile', \App\Livewire\WeatherTile::class);
}
```

### Dashboard View

```blade
<x-dashboard>
    <livewire:weather-tile position="a1" />
</x-dashboard>
```

---

## BaseTileComponent API

```php
namespace Spatie\Dashboard\Components;

use Livewire\Attributes\Defer;
use Livewire\Component;

#[Defer]
abstract class BaseTileComponent extends Component
{
    public string $position;

    public function placeholder(): string
    {
        // Returns an animated skeleton loader
        // Override this method to customize the loading placeholder
    }
}
```

### What `BaseTileComponent` provides:
- **`$position` property** — automatically populated by Livewire from the tag attribute
- **`#[Defer]` attribute** — enables deferred rendering; the `placeholder()` output is shown while the component loads
- **`placeholder()` method** — returns an animated skeleton loader (pulsing circles and bars). Override to customize.

### Customizing the placeholder

Override `placeholder()` to provide a tile-specific skeleton:

```php
class WeatherTile extends BaseTileComponent
{
    public function placeholder(): string
    {
        return <<<'HTML'
        <div class="h-full w-full animate-pulse p-4">
            <div class="h-8 bg-white/10 rounded w-1/4 mb-4"></div>
            <div class="h-16 bg-white/10 rounded w-1/2"></div>
        </div>
        HTML;
    }

    public function render() { /* ... */ }
}
```

---

## DashboardTileComponent (`<x-dashboard-tile>`) Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `position` | `string` | **required** | Grid position in Excel notation (`a1`, `a1:b2`) |
| `refresh-interval` | `?int` | `null` | Livewire `wire:poll` interval in seconds |
| `title` | `?string` | `null` | Displayed as tile title (rendered by tile view) |
| `fade` | `bool` | `true` | Applies a CSS gradient mask to fade content at the bottom edge |
| `show` | `bool` | `true` | Controls `display:none` when `false` |
| `lazy` | `bool` | `false` | Lazy-load the tile |
| `defer` | `bool` | `false` | Defer tile rendering |

### How position maps to CSS Grid

The `position` string is converted to a `grid-area` CSS value:

- `a1` → `grid-area: 1 / 1` (row 1, column 1)
- `b3` → `grid-area: 3 / 2` (row 3, column 2)
- `a1:b2` → `grid-area: 1 / 1 / 3 / 3` (spans row 1-2, column A-B)
- `a1:c1` → `grid-area: 1 / 1 / 2 / 4` (spans row 1, columns A-C)

Letters map to columns (a=1, b=2, c=3...), numbers map to rows.

### Tile wrapper HTML structure

The `<x-dashboard-tile>` renders:

```html
<div style="grid-area: ..." class="overflow-hidden rounded relative bg-tile" wire:poll.Xs>
    <div class="absolute inset-0 overflow-hidden p-4" style="fade-mask...">
        {{ $slot }}
    </div>
</div>
```

- Outer div: grid placement, background, overflow hidden, rounded corners
- Inner div: absolute positioned with padding, optional fade mask
- Content goes in the `{{ $slot }}`

---

## Tile Model API

### Database Schema

Table: `dashboard_tiles`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint (auto) | Primary key |
| `name` | string | Unique tile identifier |
| `data` | json (nullable) | Key-value data store |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Publishing the Migration

```bash
php artisan vendor:publish --tag="dashboard-migrations"
php artisan migrate
```

### Model Methods

```php
use Spatie\Dashboard\Models\Tile;

// Get or create a tile by name
$tile = Tile::firstOrCreateForName('my-tile');

// Store a value
$tile->putData('key', $value);    // Returns $this (chainable)

// Retrieve a value (supports dot notation via Arr::get)
$value = $tile->getData('key');

// Chain multiple puts
Tile::firstOrCreateForName('stats')
    ->putData('visitors', 1234)
    ->putData('pageviews', 5678);
```

The `data` column is cast to `array`. Each `putData()` call merges into the existing data and persists immediately.

---

## Dashboard Service Class API

The `Dashboard` class is registered as a singleton. Access it via the container:

```php
use Spatie\Dashboard\Dashboard;

$dashboard = app(Dashboard::class);
```

### Methods

| Method | Description |
|--------|-------------|
| `script(string $url): self` | Add an external `<script>` tag (with `defer`) |
| `inlineScript(string $script): self` | Add inline `<script>` content |
| `stylesheet(string $url): self` | Add an external `<link rel="stylesheet">` |
| `inlineStylesheet(string $css): self` | Add inline `<style>` content |
| `assets(): HtmlString` | Render all registered assets as HTML |
| `getTheme(): string` | Get the active theme (checks `?theme=` query param, falls back to config) |
| `getMode(): string` | Get `'light'` or `'dark'` based on theme setting |

Register custom assets in a service provider's `boot()` method:

```php
public function boot(): void
{
    $dashboard = app(Dashboard::class);

    $dashboard->script('https://cdn.jsdelivr.net/npm/chart.js');
    $dashboard->inlineStylesheet('.chart-container { height: 100%; }');
}
```

---

## Full Config Reference

File: `config/dashboard.php`

```php
return [
    /*
     * Supported themes: light, dark, device, auto
     * - light: always light mode
     * - dark: always dark mode
     * - device: follows the OS color scheme preference
     * - auto: light when sun is up, dark when sun is down
     */
    'theme' => 'light',

    /*
     * Coordinates for the 'auto' theme to calculate sunrise/sunset.
     */
    'auto_theme_location' => [
        'lat' => 51.260197,
        'lng' => 4.402771,
    ],

    /*
     * External stylesheets loaded on every dashboard page.
     * Set to false/null to disable.
     */
    'stylesheets' => [
        'inter' => 'https://rsms.me/inter/inter.css',
    ],
];
```

### Publishing Config

```bash
php artisan vendor:publish --tag="dashboard-config"
```

### Publishing Views

```bash
php artisan vendor:publish --tag="dashboard-views"
```

---

## CSS Color Variables

### Light Mode (`:root`)

| Variable | Value |
|----------|-------|
| `--color-default` | `rgba(0, 0, 0, 0.9)` |
| `--color-dimmed` | `rgba(0, 0, 0, 0.6)` |
| `--color-invers` | `rgba(255, 255, 255, 0.9)` |
| `--color-accent` | `rgba(25, 71, 147, 0.9)` |
| `--color-canvas` | `rgb(240, 240, 240)` |
| `--color-tile` | `rgb(255, 255, 255)` |
| `--color-warning` | `rgb(255, 172, 51)` |
| `--color-error` | `rgb(234, 15, 65)` |
| `--color-success` | `rgb(72, 187, 120)` |

### Dark Mode (`.dark-mode`)

| Variable | Value |
|----------|-------|
| `--color-default` | `rgba(255, 255, 255, 0.9)` |
| `--color-dimmed` | `rgba(255, 255, 255, 0.6)` |
| `--color-invers` | `rgba(0, 0, 0, 0.9)` |
| `--color-accent` | `rgb(255, 172, 51)` |
| `--color-canvas` | `rgb(27, 27, 27)` |
| `--color-tile` | `rgb(39, 39, 39)` |
| `--color-warning` | `rgb(143, 86, 0)` |
| `--color-error` | `rgb(234, 89, 114)` |
| `--color-success` | `rgb(47, 133, 90)` |

---

## Grid Template Utilities

Available in the Tailwind theme for use inside tiles:

### Column Templates
- `grid-cols-1-1` → `1fr 1fr`
- `grid-cols-1-auto` → `1fr auto`
- `grid-cols-1-auto-1` → `1fr auto 1fr`
- `grid-cols-1-auto-auto` → `1fr auto auto`
- `grid-cols-auto-1` → `auto 1fr`
- `grid-cols-auto-1-1` → `auto 1fr 1fr`
- `grid-cols-auto-1-auto` → `auto 1fr auto`
- `grid-cols-auto-auto` → `auto auto`

### Row Templates
- `grid-rows-1-1` → `1fr 1fr`
- `grid-rows-1-auto` → `1fr auto`
- `grid-rows-1-auto-1` → `1fr auto 1fr`
- `grid-rows-1-auto-auto` → `1fr auto auto`
- `grid-rows-auto-1` → `auto 1fr`
- `grid-rows-auto-1-1` → `auto 1fr 1fr`
- `grid-rows-auto-1-auto` → `auto 1fr auto`
- `grid-rows-auto-auto` → `auto auto`

Usage example:

```blade
<x-dashboard-tile :position="$position">
    <div class="grid grid-rows-auto-1 h-full">
        <div>Main content</div>
        <div class="self-end text-xs text-dimmed">Footer</div>
    </div>
</x-dashboard-tile>
```
