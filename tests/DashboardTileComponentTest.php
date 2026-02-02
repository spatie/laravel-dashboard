<?php

it('correctly translates a single position to grid css styles', function () {
    $this
        ->blade('<x-dashboard-tile position="a1">Test</x-dashboard-tile>')
        ->assertSee('grid-area: 1 / 1;');
});

it('correctly translates a range position to grid css styles', function () {
    $this
        ->blade('<x-dashboard-tile position="a1:b2">Test</x-dashboard-tile>')
        ->assertSee('1 / 1 / 3 / 3;');
});

it('renders with refresh interval attribute', function () {
    $this
        ->blade('<x-dashboard-tile position="a1" :refresh-interval="5">Test</x-dashboard-tile>')
        ->assertSee('wire:poll.5s');
});

it('can hide a tile', function () {
    $this
        ->blade('<x-dashboard-tile position="a1" :show="false">Test</x-dashboard-tile>')
        ->assertSee('display:none');
});

it('handles multi-letter column positions', function () {
    $this
        ->blade('<x-dashboard-tile position="z1">Test</x-dashboard-tile>')
        ->assertSee('grid-area: 1 / 26;');
});

it('returns empty grid area for invalid position', function () {
    $this
        ->blade('<x-dashboard-tile position="a">Test</x-dashboard-tile>')
        ->assertSee('grid-area: ;');
});
