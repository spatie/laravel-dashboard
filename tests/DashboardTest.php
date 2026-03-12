<?php

use Spatie\Dashboard\Dashboard;
use Spatie\Dashboard\Enums\Mode;
use Spatie\Dashboard\Enums\Theme;

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
    expect($this->dashboard->getTheme())->toBe(Theme::Light);
});

it('can get the default mode', function () {
    expect($this->dashboard->getMode())->toBe(Mode::Light);
});

it('uses theme from query parameter', function () {
    request()->merge(['theme' => 'dark']);

    expect($this->dashboard->getTheme())->toBe(Theme::Dark);
});

it('accepts all valid themes via query parameter', function (Theme $theme) {
    request()->merge(['theme' => $theme->value]);

    expect($this->dashboard->getTheme())->toBe($theme);
})->with([Theme::Light, Theme::Dark, Theme::Auto, Theme::Device]);

it('ignores invalid theme query parameter', function () {
    request()->merge(['theme' => 'invalid']);

    expect($this->dashboard->getTheme())->toBe(Theme::Light);
});

it('returns light mode for light theme', function () {
    request()->merge(['theme' => 'light']);

    expect($this->dashboard->getMode())->toBe(Mode::Light);
});

it('returns dark mode for dark theme', function () {
    request()->merge(['theme' => 'dark']);

    expect($this->dashboard->getMode())->toBe(Mode::Dark);
});

it('returns light as initial mode for device theme', function () {
    request()->merge(['theme' => 'device']);

    // Device theme detection is handled client-side, server returns 'light' as initial mode
    expect($this->dashboard->getMode())->toBe(Mode::Light);
});
