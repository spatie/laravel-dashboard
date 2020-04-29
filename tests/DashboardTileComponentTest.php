<?php

namespace Spatie\Dashboard\Tests;

class DashboardTileComponentTest extends TestCase
{
    /** @test */
    public function it_correctly_translates_a_single_position_to_grid_css_styles()
    {
        $renderedHtml = $this->renderBladeString('<x-dashboard-tile position="a1">Test</x-dashboard-tile>');

        $this->assertStringContainsString('grid-area: 1 / 1;', $renderedHtml);
    }

    /** @test */
    public function it_correctly_translates_a_range_position_to_grid_css_styles()
    {
        $renderedHtml = $this->renderBladeString('<x-dashboard-tile position="a1:b2">Test</x-dashboard-tile>');

        $this->assertStringContainsString('1 / 1 / 3 / 3;', $renderedHtml);
    }
}
