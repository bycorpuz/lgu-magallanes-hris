<?php

namespace App\Livewire\My;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('My Leave')]
#[Layout('layouts.dashboard-app')] 
class Leave extends Component
{
    public function render()
    {
        return view('livewire.my.leave');
    }
}
