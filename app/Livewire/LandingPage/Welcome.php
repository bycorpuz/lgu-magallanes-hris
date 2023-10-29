<?php

namespace App\Livewire\LandingPage;

use Livewire\Component;

class Welcome extends Component
{
    public function render()
    {
        return view('livewire.landing-page.welcome')->extends('layouts.landing-page-app')->section('body');
    }
}
