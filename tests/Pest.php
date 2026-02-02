<?php

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Spatie\Dashboard\Tests\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

uses(TestCase::class)->in(__DIR__);
uses(MatchesSnapshots::class)->in('DashboardTest.php');
uses(InteractsWithViews::class)->in('DashboardTileComponentTest.php');
