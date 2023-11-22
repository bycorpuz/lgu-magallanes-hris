<?php

namespace App\Livewire\Leave;

use App\Models\HrLeave;
use App\Models\HrLeaveCreditsAvailable;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Leaves')]
#[Layout('layouts.dashboard-app')] 
class Leaves extends Component
{
    use WithPagination;

    protected $tableList, $tableList2;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch, $showAdvancedSearch2 = false;
    public $trackingCodeAdvancedSearchField, $leaveTypeIdAdvancedSearchField,
           $userIdAdvancedSearchField, $daysAdvancedSearchField,
           $dateFromAdvancedSearchField, $dateToAdvancedSearchField,
           $isWithPayAdvancedSearchField, $statusAdvancedSearchField,
           $remarksAdvancedSearchField, $dateCreatedAdvancedSearchField,
           $dateApprovedAdvancedSearchField, $dateDisapprovedAdvancedSearchField,
           $dateCancelledAdvancedSearchField, $dateProcessingAdvancedSearchField,
           $detailsB1AdvancedSearchField, $detailsB1NameAdvancedSearchField,
           $detailsB2AdvancedSearchField, $detailsB2NameAdvancedSearchField,
           $detailsB3NameAdvancedSearchField, $detailsB4AdvancedSearchField,
           $detailsB5AdvancedSearchField, $detailsD1AdvancedSearchField = '';
    public $counter = 0;
    public $totalTableDataCount = 0;
    
    public $sortField2 = 'created_at';
    public $sortDirection2 = 'desc';
    public $availableAdvancedSearchField2, $usedAdvancedSearchField2,
           $balanceAdvancedSearchField2, $dateCreatedAdvancedSearchField2 = '';
    public $counter2 = 0;
    public $month2, $year2, $value2, $date_from2, $date_to2, $remarks2, $modal_title2= '';

    private function resetAdvancedSearchFields(){
        $this->trackingCodeAdvancedSearchField = '';
        $this->leaveTypeIdAdvancedSearchField = '';
        $this->userIdAdvancedSearchField = '';
        $this->daysAdvancedSearchField = '';
        $this->dateFromAdvancedSearchField = '';
        $this->dateToAdvancedSearchField = '';
        $this->isWithPayAdvancedSearchField = '';
        $this->statusAdvancedSearchField = '';
        $this->remarksAdvancedSearchField = '';
        $this->dateCreatedAdvancedSearchField = '';
        $this->dateApprovedAdvancedSearchField = '';
        $this->dateDisapprovedAdvancedSearchField = '';
        $this->dateCancelledAdvancedSearchField = '';
        $this->dateProcessingAdvancedSearchField = '';
        $this->detailsB1AdvancedSearchField = '';
        $this->detailsB1NameAdvancedSearchField = '';
        $this->detailsB2AdvancedSearchField = '';
        $this->detailsB2NameAdvancedSearchField = '';
        $this->detailsB3NameAdvancedSearchField = '';
        $this->detailsB4AdvancedSearchField = '';
        $this->detailsB5AdvancedSearchField = '';
        $this->detailsD1AdvancedSearchField = '';
    }

    public function addleavecredits($id){
        $hlca = HrLeaveCreditsAvailable::find($id);

        $this->modal_title2 = $hlca->leaveType->name;

        $this->dispatch('openModelAddLeaveCreditsModal');
    }

    public function closeModal(){
        $this->dispatch('closeModal');
    }
    
    public function selectedValuePerPage(){
        $this->perPage;
    }

    public function sortBy($alias, $field){
        if ($alias == 'hl'){
            if ($this->sortField === $field) {
                $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                $this->sortDirection = 'asc';
            }
            $this->sortField = $field;
        }

        if ($alias == 'hlca'){
            if ($this->sortField2 === $field) {
                $this->sortDirection2 = $this->sortDirection2 === 'asc' ? 'desc' : 'asc';
            } else {
                $this->sortDirection2 = 'asc';
            }
            $this->sortField2 = $field;
        }
    }

    public function toggleAdvancedSearch(){
        $this->showAdvancedSearch = !$this->showAdvancedSearch;
        $this->search = '';
        $this->resetAdvancedSearchFields();
    }

    public function performGlobalSearch(){
        $this->tableList = HrLeave::from('hr_leaves as hl')
        ->select(
            'hl.*',
            DB::raw("DATE_FORMAT(hl.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'upi.firstname as upi_firstname',
            'upi.middlename as upi_middlename',
            'upi.lastname as upi_lastname',
            'upi.extname as upi_extname',
            'llt.name as llt_name'
        )
        ->leftJoin('user_personal_informations as upi', 'hl.user_id', '=', 'upi.user_id')
        ->leftJoin('lib_leave_types as llt', 'hl.leave_type_id', '=', 'llt.id')
        ->where(function ($query) {
            $query->where('llt.name', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.tracking_code', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.leave_type_id', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.days', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.date_from', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.date_to', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.is_with_pay', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.status', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.remarks', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.details_b1', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.details_b1_name', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.details_b2', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.details_b2_name', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.details_b3_name', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.details_b4', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.details_b5', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.details_d1', 'like', '%'.trim($this->search).'%')
                ->orWhere('upi.firstname', 'like', '%'.trim($this->search).'%')
                ->orWhere('upi.middlename', 'like', '%'.trim($this->search).'%')
                ->orWhere('upi.lastname', 'like', '%'.trim($this->search).'%')
                ->orWhere('upi.extname', 'like', '%'.trim($this->search).'%')
                ->orWhere('hl.created_at', 'like', '%'.trim($this->search).'%');
        })
        ->where('hl.user_id', '=', $this->userIdAdvancedSearchField)
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
        
        $this->totalTableDataCount = $this->tableList->count();
    }

    public function performAdvancedSearch(){
        if ($this->remarksAdvancedSearchField){
            $remarksCondition = function ($query) {
                $query->where('hl.remarks', 'like', '%' . trim($this->remarksAdvancedSearchField) . '%');
            };
        } else {
            $remarksCondition = function ($query) {
                $query->where('hl.remarks', 'like', '%' . trim($this->remarksAdvancedSearchField) . '%')
                    ->orWhereNull('hl.remarks');
            };
        }

        $this->tableList = HrLeave::from('hr_leaves as hl')
        ->select(
            'hl.*',
            DB::raw("DATE_FORMAT(hl.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'upi.firstname as upi_firstname',
            'upi.middlename as upi_middlename',
            'upi.lastname as upi_lastname',
            'upi.extname as upi_extname',
            'llt.name as llt_name'
        )
        ->leftJoin('user_personal_informations as upi', 'hl.user_id', '=', 'upi.user_id')
        ->leftJoin('lib_leave_types as llt', 'hl.leave_type_id', '=', 'llt.id')
        ->where('hl.tracking_code', 'like', '%'.trim($this->trackingCodeAdvancedSearchField).'%')
        ->where('hl.leave_type_id', 'like', '%'.trim($this->leaveTypeIdAdvancedSearchField).'%')
        ->where('hl.days', 'like', '%'.trim($this->daysAdvancedSearchField).'%')
        ->where('hl.date_from', 'like', '%'.trim($this->dateFromAdvancedSearchField).'%')
        ->where('hl.date_to', 'like', '%'.trim($this->dateToAdvancedSearchField).'%')
        ->where('hl.is_with_pay', 'like', '%'.trim($this->isWithPayAdvancedSearchField).'%')
        ->where('hl.status', 'like', '%'.trim($this->statusAdvancedSearchField).'%')
        ->where($remarksCondition)
        ->where('hl.created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField).'%')
        ->where('hl.user_id', '=', $this->userIdAdvancedSearchField)
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);
    
        $this->resetPage();
        
        $this->totalTableDataCount = $this->tableList->count();
    }

    public function performAdvancedSearch2(){
        $this->tableList2 = HrLeaveCreditsAvailable::from('hr_leave_credits_available as hlca')
        ->select(
            'hlca.*',
            DB::raw("DATE_FORMAT(hlca.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'llt.name as llt_name'
        )
        ->leftJoin('lib_leave_types as llt', 'hlca.leave_type_id', '=', 'llt.id')
        ->where('hlca.available', 'like', '%'.trim($this->availableAdvancedSearchField2).'%')
        ->where('hlca.used', 'like', '%'.trim($this->usedAdvancedSearchField2).'%')
        ->where('hlca.balance', 'like', '%'.trim($this->balanceAdvancedSearchField2).'%')
        ->where('hlca.created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField2).'%')
        ->where('hlca.user_id', '=', $this->userIdAdvancedSearchField)
        ->orderBy($this->sortField2, $this->sortDirection2)
        ->get();
    
        $this->resetPage();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }

        $this->performAdvancedSearch2();

        return view('livewire.leave.leaves', [
            'tableList' => $this->tableList,
            'tableList2' => $this->tableList2,
        ]);
    }
}