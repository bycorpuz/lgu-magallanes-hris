<?php

namespace App\Livewire\Leave;

use App\Models\HrLeave;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('Leave Dashboard')]
#[Layout('layouts.dashboard-app')] 
class Dashboard extends Component
{
    public $leaveCounter = 0;
    public $leavePendingCounter = 0;
    public $leaveProcessingCounter = 0;
    public $leaveCancelledCounter = 0;
    public $leaveDisapprovedCounter = 0;
    public $leaveApprovedCounter = 0;

    public function mount(){
        $this->leaveDataCounter('');
        $this->leaveDataCounter('Pending');
        $this->leaveDataCounter('Processing');
        $this->leaveDataCounter('Cancelled');
        $this->leaveDataCounter('Disapproved');
        $this->leaveDataCounter('Approved');
    }

    public function leaveDataCounter($status){
        if ($status == 'Pending'){
            $this->leavePendingCounter = HrLeave::where('status', $status)->count();
        } else if ($status == 'Processing'){
            $this->leaveProcessingCounter = HrLeave::where('status', $status)->count();
        } else if ($status == 'Cancelled'){
            $this->leaveCancelledCounter = HrLeave::where('status', $status)->count();
        } else if ($status == 'Disapproved'){
            $this->leaveDisapprovedCounter = HrLeave::where('status', $status)->count();
        } else if ($status == 'Approved'){
            $this->leaveApprovedCounter = HrLeave::where('status', $status)->count();
        } else {
            $this->leaveCounter = HrLeave::count();
        }
    }

    public function render()
    {
        return view('livewire.leave.dashboard');
    }
}
