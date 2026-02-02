<?php

use Spatie\Dashboard\Models\Tile;

beforeEach(function () {
    $this->tile = Tile::firstOrCreateForName('dummy');
});

it('can add data', function () {
    $data = ['a' => 1, 'b' => 2];

    $this->tile->putData('test', $data);

    expect($this->tile->getData('test'))->toBe($data);
});

it('will not create duplicate rows for the same tile name', function () {
    Tile::firstOrCreateForName('dummy');

    expect(Tile::get())->toHaveCount(1);
});

it('will return null for a non existing key', function () {
    expect($this->tile->getData('non-existing-key'))->toBeNull();
});
