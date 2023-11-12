<?php

namespace App\Livewire\DashboardPage;

use Livewire\Component;

class SidebarWrapper extends Component
{
    public $listeners = [
        'refreshSidebarWrapper' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.dashboard-page.sidebar-wrapper');
    }
}
