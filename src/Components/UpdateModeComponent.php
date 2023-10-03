<?php

namespace Spatie\Dashboard\Components;

use Livewire\Component;
use Spatie\Dashboard\Dashboard;

class UpdateModeComponent extends Component
{
    public function render()
    {
        /** @var \Spatie\Dashboard\Dashboard $dashboard */
        $dashboard = app(Dashboard::class);

        $this->dispatch('updateMode', $dashboard->getMode());

        return view('dashboard::components.updateMode');
    }
}
