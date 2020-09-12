---
title: Creating your first dashboard
weight: 2
---

In your Laravel app, create a new route and view. The url and view name can be whatever you want.

```php
Route::view('dashboard-url', 'dashboard-blade-view');
```

In your Blade view, use the `dashboard` Blade view component.

```html
<x-dashboard>
    {{-- replace this by any tiles --}}
</x-dashboard>
```

Inside the `x-dashboard` tag, you can use any of [available tiles](/docs/laravel-dashboard/v2/adding-tiles/overview). You can also [create your own tile](/docs/laravel-dashboard/v2/adding-tiles/creating-your-own-tile/).

Here's an example

```html
<x-dashboard>
    <livewire:twitter-tile position="a1:a4"/>
    <livewire:calendar-tile position="b1:b4" />
</x-dashboard>
```
