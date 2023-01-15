<?php

namespace Spatie\Dashboard\Http\Components;

use Illuminate\View\Component;

class DashboardTileComponent extends Component
{
    public string $gridArea;

    public ?int $refreshIntervalInSeconds;

    public ?string $title;

    public bool $fade;

    public bool $show;

    public function __construct(
        string $position,
        ?int $refreshInterval = null,
        ?string $title = null,
        bool $fade = true,
        bool $show = true
    ) {
        $this->gridArea = $this->convertToGridArea($position);

        $this->refreshIntervalInSeconds = $refreshInterval;

        $this->title = $title;

        $this->fade = $fade;

        $this->show = $show;
    }

    public function render()
    {
        return view('dashboard::tile');
    }

    protected function convertToGridArea(string $position): string
    {
        $parts = explode(':', $position);

        $from = $parts[0];
        $to = $parts[1] ?? null;

        if (strlen($from) < 2 || ($to && strlen($to) < 2)) {
            return '';
        }

        $fromColumnNumber = substr($from, 1);
        $areaFrom = "{$fromColumnNumber} / {$this->indexInAlphabet($from[0])}";

        if (! $to) {
            return $areaFrom;
        }

        $toStart = ((int) substr($to, 1)) + 1;

        $toEnd = ((int) $this->indexInAlphabet($to[0])) + 1;

        return "{$areaFrom} / {$toStart} / {$toEnd}";
    }

    private function indexInAlphabet(string $character): int
    {
        $alphabet = range('a', 'z');

        $index = array_search(strtolower($character), $alphabet);

        return $index + 1;
    }
}
