<?php

use Livewire\Livewire;
use Spatie\Dashboard\Components\UpdateModeComponent;

it('renders the update mode component', function () {
    Livewire::test(UpdateModeComponent::class)
        ->assertStatus(200);
});

it('dispatches updateMode event with current mode', function () {
    Livewire::test(UpdateModeComponent::class)
        ->assertDispatched('updateMode', 'light');
});
