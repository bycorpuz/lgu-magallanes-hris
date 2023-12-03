<?php

namespace App\Livewire\DashboardPage;

use Livewire\Component;

class SidebarWrapperHeader extends Component
{
    public $listeners = [
        'refreshSidebarWrapperHeader' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.dashboard-page.sidebar-wrapper-header');
    }
}
