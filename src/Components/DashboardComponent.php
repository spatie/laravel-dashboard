<?php

namespace Spatie\Dashboard\Components;

use Illuminate\Support\HtmlString;
use Illuminate\View\Component;
use Spatie\Dashboard\Dashboard;

class DashboardComponent extends Component
{
    public string $pageTitle = '';

    public string $theme = '';

    public string $initialMode = '';

    public ?HtmlString $assets = null;

    public function __construct(Dashboard $dashboard, string $pageTitle = 'Dashboard')
    {
        $this->theme = $dashboard->getTheme();

        $this->initialMode = $dashboard->getMode();

        $this->assets = $dashboard->assets();

        $this->pageTitle = $pageTitle;
    }

    public function render()
    {
        return view('dashboard::dashboard');
    }
}
