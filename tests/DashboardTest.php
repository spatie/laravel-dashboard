<?php

use Spatie\Dashboard\Dashboard;

beforeEach(function () {
    $this->dashboard = new Dashboard;
});

it('can return all assets as html', function () {
    $html = $this->dashboard
        ->script('https://example.com/app.js')
        ->inlineScript('console.log("hey")')
        ->stylesheet('https://example.com/app.css')
        ->inlineStylesheet('style')
        ->assets()
        ->toHtml();

    $this->assertMatchesSnapshot($html);
});

it('can get the default theme', function () {
    expect($this->dashboard->getTheme())->toBe('light');
});

it('can get the default mode', function () {
    expect($this->dashboard->getMode())->toBe('light');
});

it('uses theme from query parameter', function () {
    request()->merge(['theme' => 'dark']);

    expect($this->dashboard->getTheme())->toBe('dark');
});

it('accepts all valid themes via query parameter', function (string $theme) {
    request()->merge(['theme' => $theme]);

    expect($this->dashboard->getTheme())->toBe($theme);
})->with(['light', 'dark', 'auto', 'device']);

it('ignores invalid theme query parameter', function () {
    request()->merge(['theme' => 'invalid']);

    expect($this->dashboard->getTheme())->toBe('light');
});

it('returns light mode for light theme', function () {
    request()->merge(['theme' => 'light']);

    expect($this->dashboard->getMode())->toBe('light');
});

it('returns dark mode for dark theme', function () {
    request()->merge(['theme' => 'dark']);

    expect($this->dashboard->getMode())->toBe('dark');
});

it('returns light as initial mode for device theme', function () {
    request()->merge(['theme' => 'device']);

    // Device theme detection is handled client-side, server returns 'light' as initial mode
    expect($this->dashboard->getMode())->toBe('light');
});
