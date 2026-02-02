<?php

namespace Spatie\Dashboard\Components;

use Livewire\Attributes\Defer;
use Livewire\Component;

#[Defer]
abstract class BaseTileComponent extends Component
{
    public string $position;

    public function placeholder(): string
    {
        return <<<'HTML'
        <div class="h-full w-full animate-pulse p-4">
            <div class="h-10 w-10 rounded-full bg-white/20"></div>
            <div class="mt-4 space-y-3">
                <div class="h-4 bg-white/10 rounded w-1/3"></div>
                <div class="h-3 bg-white/10 rounded w-full"></div>
                <div class="h-3 bg-white/10 rounded w-full"></div>
            </div>
        </div>
        HTML;
    }
}
