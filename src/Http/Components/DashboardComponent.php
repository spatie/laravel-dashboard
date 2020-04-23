<?php

namespace Spatie\Dashboard\Http\Components;

use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;
use Spatie\Dashboard\Dashboard;
use Spatie\Sun\Sun;

class DashboardComponent extends Component
{
    const THEMES = ['auto', 'device', 'light', 'dark'];

    public string $theme;

    public string $initialMode;

    public HtmlString $assets;

    public function __construct(Dashboard $dashboard, Request $request, string $defaultTheme)
    {
        $requestedTheme = $request->query('theme') ?? '';

        $this->theme = $this->isValidTheme($requestedTheme)
            ? $requestedTheme
            : $defaultTheme;

        $this->initialMode = $this->determineMode($this->theme);

        $this->assets = $dashboard->assets();
    }

    public function render()
    {
        return view('dashboard::dashboard');
    }

    protected function isValidTheme(string $theme): bool
    {
        return in_array($theme, self::THEMES);
    }

    protected function determineMode(string $theme): string
    {
        if ($theme === 'auto') {
            return app(Sun::class)->sunIsUp() ? 'light' : 'dark';
        }

        if ($theme === 'dark') {
            return 'dark';
        }

        return 'light';
    }
}
