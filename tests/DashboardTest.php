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
