<?php

namespace App\Livewire\My;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('My Profile')]
#[Layout('layouts.dashboard-app')] 
class Profile extends Component
{
    public function render()
    {
        return view('livewire.my.profile');
    }
}
