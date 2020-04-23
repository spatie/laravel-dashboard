<?php

namespace Spatie\Dashboard;

use Illuminate\Support\HtmlString;
use Spatie\Sun\Sun;

class Dashboard
{
    const THEMES = ['auto', 'device', 'light', 'dark'];

    public array $scripts = [];

    public array $inlineScripts = [];

    public array $stylesheets = [];

    public array $inlineStylesheets = [];

    public function script(string $url): self
    {
        $this->scripts[] = $url;

        return $this;
    }

    public function inlineScript(string $script): self
    {
        $this->inlineScripts[] = $script;

        return $this;
    }

    public function stylesheet(string $url): self
    {
        $this->stylesheets[] = $url;

        return $this;
    }

    public function inlineStylesheet(string $stylesheet): self
    {
        $this->inlineStylesheets[] = $stylesheet;

        return $this;
    }

    public function assets(): HtmlString
    {
        $assets = [];

        foreach ($this->scripts as $script) {
            $assets[] = "<script src=\"{$script}\" defer></script>";
        }

        foreach ($this->inlineScripts as $inlineScript) {
            $assets[] = "<script>{$inlineScript}</script>";
        }

        foreach ($this->stylesheets as $stylesheet) {
            $assets[] = "<link rel=\"stylesheet\" href=\"{$stylesheet}\">";
        }

        foreach ($this->inlineStylesheets as $inlineStylesheet) {
            $assets[] = "<style>{$inlineStylesheet}</style>";
        }

        return new HtmlString(implode('', $assets));
    }

    public function getTheme(): string
    {
        $defaultTheme = config('dashboard.theme');

        $requestedTheme = request()->query('theme') ?? '';

        return $this->isValidTheme($requestedTheme)
            ? $requestedTheme
            : $defaultTheme;
    }

    public function getMode(): string
    {
        $theme = $this->getTheme();

        if ($theme === 'auto') {
            return app(Sun::class)->sunIsUp() ? 'light' : 'dark';
        }

        if ($theme === 'dark') {
            return 'dark';
        }

        return 'light';
    }

    protected function isValidTheme(string $theme): bool
    {
        return in_array($theme, self::THEMES);
    }
}
