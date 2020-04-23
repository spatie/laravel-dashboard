<?php

namespace Spatie\Dashboard\Http\Components;

use Illuminate\Support\HtmlString;
use Illuminate\View\Component;
use Spatie\Dashboard\Dashboard;

class DashboardComponent extends Component
{
    public string $theme;

    public string $initialMode;

    public HtmlString $assets;

    public function __construct(Dashboard $dashboard)
    {
        $this->theme = $dashboard->getTheme();

        $this->initialMode = $dashboard->getMode();

        $this->assets = $dashboard->assets();
    }

    public function render()
    {
        return view('dashboard::dashboard');
    }
}
