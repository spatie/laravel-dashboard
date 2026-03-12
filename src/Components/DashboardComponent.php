<?php

namespace Spatie\Dashboard\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;
use Spatie\Dashboard\Dashboard;
use Spatie\Dashboard\Enums\Mode;
use Spatie\Dashboard\Enums\Theme;

class DashboardComponent extends Component
{
    public Theme $theme;

    public Mode $initialMode;

    public ?HtmlString $assets = null;

    public function __construct(Dashboard $dashboard, public string $pageTitle = 'Dashboard')
    {
        $this->theme = $dashboard->getTheme();

        $this->initialMode = $dashboard->getMode();

        $this->assets = $dashboard->assets();
    }

    public function render(): View
    {
        return view('dashboard::dashboard');
    }
}
