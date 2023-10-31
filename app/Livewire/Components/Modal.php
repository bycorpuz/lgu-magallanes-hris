<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Modal extends Component
{
    public $showModal = false;
    public $modalTitle = '';
    public $modalSize = '';
    public $modalAction = '';

    protected $listeners = [
        'showModalListener' => 'show',
        'closeModalListener' => 'close'
    ];

    public function show($modalTitle, $modalSize, $modalAction){
        $this->showModal = true;
        $this->modalTitle = $modalTitle;
        $this->modalSize = $modalSize;
        $this->modalAction = $modalAction;
    }
    
    public function close() {
        $this->showModal = false;
    }
}
