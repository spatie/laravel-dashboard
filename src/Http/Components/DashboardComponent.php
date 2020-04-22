<?php

namespace Spatie\Dashboard\Http\Components;

use Illuminate\Http\Request;
use Illuminate\View\Component;
use Spatie\Dashboard\Sunrise;

class DashboardComponent extends Component
{
    const THEMES = ['auto', 'device', 'light', 'dark'];

    public string $theme;

    public string $initialMode;

    public function __construct(Request $request, Sunrise $sunrise, string $defaultTheme)
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
    }

    public function render()
    {
        return view('dashboard::dashboard');
    }
}
