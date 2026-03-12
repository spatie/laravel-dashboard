<?php

namespace Spatie\Dashboard;

use Illuminate\Support\HtmlString;
use Spatie\Dashboard\Enums\Mode;
use Spatie\Dashboard\Enums\Theme;
use Spatie\Sun\Sun;

class Dashboard
{
    /** @var array<int, string> */
    public array $scripts = [];

    /** @var array<int, string> */
    public array $inlineScripts = [];

    /** @var array<int, string> */
    public array $stylesheets = [];

    /** @var array<int, string> */
    public array $inlineStylesheets = [];

    public function script(string $url): static
    {
        $this->scripts[] = $url;

        return $this;
    }

    public function inlineScript(string $script): static
    {
        $this->inlineScripts[] = $script;

        return $this;
    }

    public function stylesheet(string $url): static
    {
        $this->stylesheets[] = $url;

        return $this;
    }

    public function inlineStylesheet(string $stylesheet): static
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
            $assets[] = "<script>$inlineScript</script>";
        }

        foreach ($this->stylesheets as $stylesheet) {
            $assets[] = "<link rel=\"stylesheet\" href=\"$stylesheet\">";
        }

        foreach ($this->inlineStylesheets as $inlineStylesheet) {
            $assets[] = "<style>$inlineStylesheet</style>";
        }

        return new HtmlString(implode('', $assets));
    }

    public function getTheme(): Theme
    {
        $defaultTheme = Theme::from(config('dashboard.theme'));

        $requestedTheme = request()->query('theme') ?? '';

        return Theme::tryFrom($requestedTheme) ?? $defaultTheme;
    }

    public function getMode(): Mode
    {
        $theme = $this->getTheme();

        return match ($theme) {
            Theme::Auto => app(Sun::class)->sunIsUp() ? Mode::Light : Mode::Dark,
            Theme::Dark => Mode::Dark,
            default => Mode::Light,
        };
    }
}
