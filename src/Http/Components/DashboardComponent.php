<?php

namespace Spatie\Dashboard\Http\Components;

use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;
use Spatie\Dashboard\Dashboard;
use Spatie\Dashboard\Sunrise;

class DashboardComponent extends Component
{
    const THEMES = ['auto', 'device', 'light', 'dark'];

    public string $theme;

    public string $initialMode;

    public HtmlString $assets;

    public function __construct(Dashboard $dashboard, Request $request, Sunrise $sunrise, string $defaultTheme)
    {
        $this->theme = in_array($request->query('theme'), self::THEMES, true)
            ? $request->query('theme')
            : $defaultTheme;

        switch ($this->theme) {
            case 'auto':
                $this->initialMode = $sunrise->sunIsUp()
                    ? 'light'
                    : 'dark';
                break;
            case 'dark':
                $this->initialMode = 'dark';
                break;
            default:
                $this->initialMode = 'light';
                break;
        }

        $this->assets = $dashboard->assets();
    }

    public function render()
    {
        return view('dashboard::dashboard');
    }
}
