<?php

namespace Spatie\Dashboard\Http\Components;

use Livewire\Component;
use Spatie\Dashboard\Dashboard;

class UpdateModeComponent extends Component
{
    public function render()
    {
        /** @var \Spatie\Dashboard\Dashboard $dashboard */
        $dashboard = app(Dashboard::class);

        $this->emit('updateMode', $dashboard->getMode());

        return view('dashboard::components.updateMode');
    }
}
