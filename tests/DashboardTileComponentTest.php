<?php

namespace Spatie\Dashboard\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

class DashboardTileComponentTest extends TestCase
{
    use InteractsWithViews;

    /** @test */
    public function it_correctly_translates_a_single_position_to_grid_css_styles()
    {
        $this
            ->blade('<x-dashboard-tile position="a1">Test</x-dashboard-tile>')
            ->assertSee('grid-area: 1 / 1;');
    }

    /** @test */
    public function it_correctly_translates_a_range_position_to_grid_css_styles()
    {
        $this
            ->blade('<x-dashboard-tile position="a1:b2">Test</x-dashboard-tile>')
            ->assertSee('1 / 1 / 3 / 3;');
    }
}
