<?php

namespace Spatie\Dashboard\Tests;

use Spatie\Snapshots\MatchesSnapshots;

class DashboardTileComponentTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function it_can_render_a_tile_component()
    {
        $renderedHtml = $this->renderBladeString('<x-dashboard-tile position="a1">Test</x-dashboard-tile>');

        $this->assertMatchesSnapshot($renderedHtml);
    }
}
