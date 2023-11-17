<?php

namespace App\Livewire\Leave;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('Leave Dashboard')]
#[Layout('layouts.dashboard-app')] 
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.leave.dashboard');
    }
}
