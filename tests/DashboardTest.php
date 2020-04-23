<?php

namespace Spatie\Dashboard\Tests;

use Spatie\Dashboard\Dashboard;
use Spatie\Snapshots\MatchesSnapshots;

class DashboardTest extends TestCase
{
    use MatchesSnapshots;

    private Dashboard $dashboard;

    public function setUp(): void
    {
        parent::setUp();

        $this->dashboard = new Dashboard();
    }

    /** @test */
    public function it_can_return_all_assets_as_html()
    {
        $html = $this->dashboard
            ->script('https://example.com/app.js')
            ->inlineScript('console.log("hey")')
            ->stylesheet('https://example.com/app.css')
            ->inlineStylesheet('style')
            ->assets()
            ->toHtml();

        $this->assertMatchesSnapshot($html);
    }

    /** @test */
    public function it_can_get_the_default_theme()
    {
        $this->assertEquals('light', $this->dashboard->getTheme());
    }

    /** @test */
    public function it_can_get_the_default_mode()
    {
        $this->assertEquals('light', $this->dashboard->getMode());
    }
}
