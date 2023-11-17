<?php

namespace App\Livewire\Leave;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('Leave Earnings')]
#[Layout('layouts.dashboard-app')] 
class LeaveEarnings extends Component
{
    public function render()
    {
        return view('livewire.leave.leave-earnings');
    }
}
