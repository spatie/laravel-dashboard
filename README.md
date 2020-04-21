# Create beautiful dashboards powered by Livewire

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-dashboard.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-dashboard-calendar-tile)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-dashboard/run-tests?label=tests)](https://github.com/spatie/laravel-dashboard-calendar-tile/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-dashboard.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-dashboard-calendar-tile)

Using this package you can create a beautiful dashboard Like this one.

![Screenshot of dashboard]()

The dashboard consists of tile which are, under the hood, Livewire components that can update themselves via polling. 

This package contains the base functionality. It contains:

- the base css
- a `dashboard` view component
- a `tile` view component to position stuff on the dashboard
- a `Tile` model to persist fetched data that tiles can use to store fetched data

## Support us

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us). 

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-dashboard
```

To create the `dashboard_tiles` table, you must create and run the migration.

```bash
php artisan vendor:publish --provider="Spatie\Dashboard\DashboardServiceProvider" --tag="mailcoach-migrations"
php artisan migrate
```

## Usage

In your Laravel app, create a new route and view. The url and view name can be whatever you want.

```php
Route::view('dashboard-url', 'dashboard-blade-view')
```

In your Blade view, use the `dashboard` Blade view component.

```html
<x-dashboard>
    {{-- replace this by any tiles --}}
</x-dashboard>
```

Inside the `x-dashboard` tag, you can use any of [available tiles](TODO: add link). You can also [create your own tile](TODO: add link).

Here's an example

```html
<x-dashboard>
    <livewire:twitter-tile position="a1:a4"/>
    <livewire:calendar-tile position="b1:b4" />
</x-dashboard>
```

## Positioning tiles

Most tiles accept a position property. You can pass a single position like `a1`. You should image the dashboard as an excel like layout. The columns are represented by letters, the rows by number. The first letter, `a`, represent the first column. The `1` represents the first row. You an also pass ranges. Here are a few examples.

- `a1`: display the tile in the top left corner
- `b2`: display a tile in the second row of the second column
- `a1:a3`: display a tile over the three first rows of the first column
- `b1:c2`: display the tile as a square starting at the first row of the second column to the second row of the third column

The dashboard is being rendered using css grid. Behind the scenes, these coordinates will be converted to grid classes. The grid will grow automatically. If a `c` is the "highest" letter used on the dashboard, it will have 3 columns, if a `e` is used on any tile, the dashboard will have 5 columns. The same applies with the rows.

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
