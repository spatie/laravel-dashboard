<?php

namespace Spatie\Dashboard\Components;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Spatie\Dashboard\Dashboard;

class UpdateModeComponent extends Component
{
    public function render(): View
    {
        /** @var Dashboard $dashboard */
        $dashboard = app(Dashboard::class);

        $this->dispatch('updateMode', $dashboard->getMode());

        return view('dashboard::components.updateMode');
    }
}
