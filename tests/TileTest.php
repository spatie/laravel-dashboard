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

it('can update existing data key', function () {
    $this->tile->putData('key', 'original');
    $this->tile->putData('key', 'updated');

    expect($this->tile->getData('key'))->toBe('updated');
});

it('can store nested data structures', function () {
    $nested = ['level1' => ['level2' => ['value' => 'deep']]];

    $this->tile->putData('nested', $nested);

    expect($this->tile->getData('nested'))->toBe($nested);
});

it('can store empty array', function () {
    $this->tile->putData('empty', []);

    expect($this->tile->getData('empty'))->toBe([]);
});
