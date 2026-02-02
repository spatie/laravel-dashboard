<?php

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

uses(InteractsWithViews::class);

it('renders the dashboard component', function () {
    $this->blade('<x-dashboard>Content</x-dashboard>')
        ->assertSee('x-data="theme(', false);
});

it('uses default page title', function () {
    $this->blade('<x-dashboard>Content</x-dashboard>')
        ->assertSee('<title>Dashboard</title>', false);
});

it('accepts a custom page title', function () {
    $this->blade('<x-dashboard pageTitle="Custom Title">Content</x-dashboard>')
        ->assertSee('<title>Custom Title</title>', false);
});

it('passes theme to alpine component', function () {
    request()->merge(['theme' => 'dark']);

    $this->blade('<x-dashboard>Content</x-dashboard>')
        ->assertSee("theme('dark',", false);
});
