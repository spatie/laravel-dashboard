---
title: Creating your own tile
weight: 2
---

If you have knowledge of Laravel, creating a new component is a straightforward process.

### Creating a minimal tile

At the minimum a tile consist of a Livewire component class and a view. If you have never worked with Livewire before, we recommend to first read [the documentation of Livewire](https://laravel-livewire.com/docs/quickstart), especially the part on [making components](https://laravel-livewire.com/docs/making-components). Are you a visual learner? Then you'll be happy to know there's also [a free video course](https://laravel-livewire.com/screencasts/installation) to get you started.

This is the most minimal Tile component you can create.

```php
namespace App\Tiles;

use Livewire\Component;

class DummyComponent extends Component
{
    /** @var string */
    public $position;

    public function mount(string $position)
    {
        $this->position = $position;
    }

    public function render()
    {
        return view('tiles.dummy');
    }
}
```

You should always accept a `position` via the mount function. This position will used [to position tiles on the dashboard](TODO: add link).

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

Because we are using Livewire components, refreshing is easy. All you need to do is to add `wire:poll` to your view. In this example the component will be refreshed every 60 seconds.

```html
<x-dashboard-tile :position="$position">
    <div wire:poll.60s>
        <h1>Dummy</h1>

        {{-- display the $data --}}
    </div>
</x-dashboard-tile>
```

## Packaging up your component

If you have created a tile that could be beneficial to others, consider sharing your awesome tile with the community by packaging it up.

[This repo](https://github.com/spatie/laravel-dashboard-skeleton-tile) contains a skeleton that can help you kick start your tile package.

When you have published you package, let us know by sending a mail to info@spatie.be, and we'll mention your tile in our docs.



