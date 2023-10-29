<?php

namespace App\Livewire\DashboardPage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('Dashboard')]
#[Layout('layouts.dashboard-app')] 
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard-page.dashboard');
    }
}
