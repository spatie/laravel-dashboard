<?php

namespace Spatie\Dashboard\Tests;

use Spatie\Dashboard\Models\Tile;

class TileTest extends TestCase
{
    private Tile $tile;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tile = Tile::firstOrCreateForName('dummy');
    }

    /** @test */
    public function it_can_add_data()
    {
        $data = ['a' => 1, 'b' => 2];

        $this->tile->putData('test', $data);

        $actualData = $this->tile->getData('test');

        $this->assertEquals($data, $actualData);
    }

    /** @test */
    public function it_will_not_create_duplicate_rows_for_the_same_tile_name()
    {
        Tile::firstOrCreateForName('dummy');

        $this->assertCount(1, Tile::get());
    }

    /** @test */
    public function it_will_return_null_for_a_non_existing_key()
    {
        $data = $this->tile->getData('non-existing-key');

        $this->assertNull($data);
    }
}
