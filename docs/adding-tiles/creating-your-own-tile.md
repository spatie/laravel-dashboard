---
title: Creating your own tile
weight: 2
---

If you have knowledge of Laravel, creating a new component is a straightforward process.

### Creating a minimal tile

At the minimum a tile consist of a Livewire component class and a view. If you have never worked with Livewire before, we recommend to first read [the documentation of Livewire](https://livewire.laravel.com/docs), especially the part on [making components](https://livewire.laravel.com/docs/components). Are you a visual learner? Then you'll be happy to know there's also [a free video course](https://livewire.laravel.com/screencasts/installation) to get you started.

The recommended way to create a tile is to extend `BaseTileComponent`. This abstract class provides a `$position` property, the `#[Defer]` attribute for lazy-loading, and a skeleton placeholder out of the box.

```php
namespace App\Tiles;

use Spatie\Dashboard\Components\BaseTileComponent;

class DummyComponent extends BaseTileComponent
{
    public function render()
    {
        return view('tiles.dummy');
    }
}
```

Alternatively, you can extend `Livewire\Component` directly and accept the `position` yourself:

```php
namespace App\Tiles;

use Livewire\Component;

class DummyComponent extends Component
{
    public string $position;

    public function render()
    {
        return view('tiles.dummy');
    }
}
```

The `position` will be used [to position tiles on the dashboard](/docs/laravel-dashboard/v4/basic-usage/positioning-tiles).

Here's how that `tiles.dummy` view could look like

```html
<x-dashboard-tile :position="$position">
    <h1>Dummy</h1>
</x-dashboard-tile>
```

In your view you should always use `x-dashboard-tile` and pass it the `position` your component accepted.

## Fetching and storing data

The most common way to feed a component data is via a scheduled command. Inside that scheduled command you can perform any API request you want. You can also store fetched data and retrieve in your component however you want. To help you with this, the dashboard provides a `Tile` model that can be used to store and retrieve data.

Let's take a look at a simple example.

```php
namespace App\Commands;

use Illuminate\Console\Command;
use Spatie\Dashboard\Models\Tile;

class FetchDataForDummyComponentCommand extends Command
{
    protected $signature = 'dashboard:fetch-data-for-dummy-component';

    protected $description = 'Fetch data for dummy component';

    public function handle()
    {
            $data = Http::get(<some-fancy-api-endpoint>)->json();

            // this will store your data in the database
            Tile::firstOrCreateForName('dummy')->putData('my_data', $data);
    }
}
```

This command could [be scheduled](https://laravel.com/docs/master/scheduling#scheduling-artisan-commands) to run at any frequency you want.

In your component class, you can fetch the stored data using the `getData` function on the `Tile` model:

```php
// inside your component

public function render()
{
    return view('tiles.dummy', [
       'data' => Spatie\Dashboard\Models\Tile::firstOrCreateForName('dummy')->getData('my_data')
    ]);
}
```

In your view, you can do with the data whatever you want.

## Refreshing the component

To refresh a tile, you should pass an amount of seconds to the `refresh-interval` prop of `x-dashboard-tile`.  In this example the component will be refreshed every 60 seconds.

```html
<x-dashboard-tile :position="$position" refresh-interval="60">
    <h1>Dummy</h1>

    {{-- display the $data --}}
</x-dashboard-tile>
```

If your component only needs to be refreshed partially, you can add `wire:poll` to your view (instead of using the `refresh-interval` prop).

```html
<x-dashboard-tile :position="$position" >
    <h1>Dummy</h1>

     <div wire:poll.60s>
        Only this part will be refreshed
    </div>
</x-dashboard-tile>
```

## Lazy loading

The `<x-dashboard-tile>` component supports `lazy` and `defer` boolean props for controlling Livewire's lazy-loading behavior:

```html
<x-dashboard-tile :position="$position" :lazy="true">
    <h1>Dummy</h1>
</x-dashboard-tile>
```

If you extend `BaseTileComponent`, the `#[Defer]` attribute is already applied, so your tile will be deferred automatically.

## Styling your component

The dashboard is styled using [Tailwind CSS 4](https://tailwindcss.com). In your component you can use any of the classes Tailwind provides.

In addition to Tailwind, the dashboard defines these extra colors for you to use: `default`, `invers`, `dimmed`, `accent`, `canvas`, `tile`, `success`, `warning`, `error`.

By default, these colors are automatically shared by the `textColor`, `borderColor`, and `backgroundColor` utilities, so you can use utility classes like `text-canvas`, `border-error`, and `bg-dimmed`.

These colors have a separate value for light and dark mode, so your component will also look beautiful in dark mode.

## Adding extra JavaScript / CSS

If your tile needs to load extra JavaScript or CSS, you can do so using `Spatie\Dashboard\Facades\Dashboard` facade.

```php
Dashboard::script($urlToScript);
Dashboard::inlineScript($extraJavaScript);

Dashboard::stylesheet($urlToStyleSheet);
Dashboard::inlineStylesheet($extraCss);
```

## Packaging up your component

If you have created a tile that could be beneficial to others, consider sharing your awesome tile with the community by packaging it up.

[This repo](https://github.com/spatie/laravel-dashboard-skeleton-tile) contains a skeleton that can help you kick start your tile package.

When you have published you package, let us know by sending a mail to info@spatie.be, and we'll mention your tile in our docs.
