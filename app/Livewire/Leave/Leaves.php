<?php

namespace App\Livewire\Leave;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('Leaves')]
#[Layout('layouts.dashboard-app')] 
class Leaves extends Component
{
    public function render()
    {
        return view('livewire.leave.leaves');
    }
}
