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
