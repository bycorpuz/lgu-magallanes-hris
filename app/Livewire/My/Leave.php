<?php

namespace App\Livewire\My;

use App\Models\HrLeave;
use App\Models\HrLeaveCreditsAvailable;
use App\Models\LibSignatory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('My Leave')]
#[Layout('layouts.dashboard-app')] 
class Leave extends Component
{
    use WithPagination;

    protected $tableList;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch = false;
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

    public $id, $tracking_code, $leave_type_id, $user_id,
           $days, $date_from, $date_to, $is_with_pay, $remarks,
           $date_approved, $date_disapproved, $date_cancelled, $date_processing,
           $details_b1, $details_b1_name, $details_b2, $details_b2_name,
           $details_b3_name, $details_b4, $details_b5, $details_d1 = '';
    public $status = 'Pending';

    public $isUpdateMode = false;
    public $deleteId = '';

    public $printViewFileUrl;
    public $signatory_id, $param1_signatory, $param1_designation,
           $param2_signatory, $param2_designation,
           $param3_signatory, $param3_designation;

    public $myLeaveCreditsAvailable = '';

    public function calculateDays(){
        if ($this->date_from && $this->date_to) {
            $start = Carbon::parse($this->date_from);
            $end = Carbon::parse($this->date_to);

            $this->days = $end->diffInDays($start) + 1;
        } else {
            $this->days = 1;
        }
    }

    public function openCreateUpdateModal(){
        $this->dispatch('openCreateUpdateModal');
    }

    private function resetInputFields(){
        $this->tracking_code = '';
        $this->leave_type_id = '';
        $this->user_id = '';
        $this->days = '';
        $this->date_from = '';
        $this->date_to = '';
        $this->is_with_pay = '';
        $this->remarks = '';
        $this->date_approved = '';
        $this->date_disapproved = '';
        $this->date_cancelled = '';
        $this->date_processing = '';
        $this->details_b1 = '';
        $this->details_b1_name = '';
        $this->details_b2 = '';
        $this->details_b2_name = '';
        $this->details_b3_name = '';
        $this->details_b4 = '';
        $this->details_b5 = '';
        $this->details_d1 = '';
        artisanClear();
    }

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

    public function closeModal(){
        $this->isUpdateMode = false;
        $this->resetInputFields();
        $this->dispatch('closeModal');
    }

    public function generateTrackingCode(){
        $latestData = HrLeave::orderBy('id', 'DESC')->first();
        $currYear = date('Y');
        $trackingCode = '';
        if ($latestData) {
            $latestCode = explode('-', $latestData->tracking_code);
            $latestYear = $latestCode[0];
            $latestSerial = intval($latestCode[1]);

            if ($latestYear == $currYear) {
                $newSerial = $latestSerial + 1;
                $trackingCode = $currYear . '-' . sprintf('%05d', $newSerial);
            } else {
                $trackingCode = $currYear . '-00001';
            }
        } else {
            $trackingCode = $currYear . '-00001';
        }
        return $trackingCode;
    }

    public function store(){
        $this->validate([
            'leave_type_id' => 'required',
            'days' => 'required|numeric',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'is_with_pay' => 'required|in:Yes,No'
        ]);

        $table = new HrLeave();
        $table->tracking_code = $this->generateTrackingCode();
        $table->leave_type_id = $this->leave_type_id;
        $table->user_id = Auth::user()->id;
        $table->days = $this->days;
        $table->date_from = $this->date_from;
        $table->date_to = $this->date_to;
        $table->is_with_pay = $this->is_with_pay;
        $table->status = $this->status;
        $table->remarks = $this->remarks;
        
        $table->details_b1 = !empty($this->details_b1) ? $this->details_b1 : 'N/A';
        $table->details_b1_name = $this->details_b1_name;
        $table->details_b2 = !empty($this->details_b2) ? $this->details_b2 : 'N/A';
        $table->details_b2_name = $this->details_b2_name;
        $table->details_b3_name = $this->details_b3_name;
        $table->details_b4 = !empty($this->details_b4) ? $this->details_b4 : 'N/A';
        $table->details_b5 = !empty($this->details_b5) ? $this->details_b5 : 'N/A';
        $table->details_d1 = !empty($this->details_d1) ? $this->details_d1 : 'No';
        
        if ($table->save()) {
            $this->resetInputFields();
            $this->dispatch('closeModal');

            doLog($table, request()->ip(), 'My Leave', 'Created');
            $this->js("showNotification('success', 'My Leave data has been saved successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function edit($id){
        $this->isUpdateMode = true;
        $this->resetInputFields();
        $this->dispatch('openCreateUpdateModal');

        $table = HrLeave::find($id);
        $this->id = $table->id;
        $this->leave_type_id = $table->leave_type_id;
        $this->days = $table->days;
        $this->date_from = $table->date_from;
        $this->date_to = $table->date_to;
        $this->is_with_pay = $table->is_with_pay;
        $this->remarks = $table->remarks;
        $this->details_b1 = $table->details_b1;
        $this->details_b1_name = $table->details_b1_name;
        $this->details_b2 = $table->details_b2;
        $this->details_b2_name = $table->details_b2_name;
        $this->details_b3_name = $table->details_b3_name;
        $this->details_b4 = $table->details_b4;
        $this->details_b5 = $table->details_b5;
        $this->details_d1 = $table->details_d1;
    }

    public function update(){
        $this->validate([
            'leave_type_id' => 'required',
            'days' => 'required|numeric',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'is_with_pay' => 'required|in:Yes,No'
        ]);

        $table = HrLeave::find($this->id);
        $table->leave_type_id = $this->leave_type_id;
        $table->days = $this->days;
        $table->date_from = $this->date_from;
        $table->date_to = $this->date_to;
        $table->is_with_pay = $this->is_with_pay;
        $table->remarks = $this->remarks;
        
        $table->details_b1 = !empty($this->details_b1) ? $this->details_b1 : 'N/A';
        $table->details_b1_name = $this->details_b1_name;
        $table->details_b2 = !empty($this->details_b2) ? $this->details_b2 : 'N/A';
        $table->details_b2_name = $this->details_b2_name;
        $table->details_b3_name = $this->details_b3_name;
        $table->details_b4 = !empty($this->details_b4) ? $this->details_b4 : 'N/A';
        $table->details_b5 = !empty($this->details_b5) ? $this->details_b5 : 'N/A';
        $table->details_d1 = !empty($this->details_d1) ? $this->details_d1 : 'No';
        
        if ($table->update()) {
            $this->resetInputFields();
            $this->dispatch('closeModal');

            doLog($table, request()->ip(), 'My Leave', 'Updated');
            $this->js("showNotification('success', 'My Leave data has been updated successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong')");
        }
    }

    public function toBeDeleted($id){
        $this->deleteId = $id;
        $this->dispatch('openDeletionModal');

        $table = HrLeave::find($id);
        $this->id = $table->id;
        $this->tracking_code = $table->tracking_code;
        $this->leave_type_id = $table->leave_type_id;
        $this->days = $table->days;
        $this->date_from = $table->date_from;
        $this->date_to = $table->date_to;
        $this->is_with_pay = $table->is_with_pay;
        $this->status = $table->status;
        $this->remarks = $table->remarks;
        $this->details_b1 = $table->details_b1;
        $this->details_b1_name = $table->details_b1_name;
        $this->details_b2 = $table->details_b2;
        $this->details_b2_name = $table->details_b2_name;
        $this->details_b3_name = $table->details_b3_name;
        $this->details_b4 = $table->details_b4;
        $this->details_b5 = $table->details_b5;
        $this->details_d1 = $table->details_d1;
    }

    public function delete(){
        $oldTable = HrLeave::from('hr_leaves as hl')
            ->select(
                'hl.*',
                'upi.*'
            )
            ->leftJoin('user_personal_informations as upi', 'hl.user_id', '=', 'upi.user_id')
            ->where('hl.id', $this->deleteId)
            ->first();

        $table = HrLeave::find($this->deleteId);
        if ($table->delete()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($oldTable, request()->ip(), 'My Leave', 'Deleted');
            $this->js("showNotification('success', 'The selected My Leave has been deleted successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function mount(){
        $this->signatories();
    }

    public function signatories(){
        $table = LibSignatory::where([
            ['user_id', Auth::user()->id],
            ['for', 'Leave']
        ])->first();

        if (!$table){
            $table = new LibSignatory();
            $table->user_id = Auth::user()->id;
            $table->for = 'Leave';
            $table->save();
        }
        
        $this->signatory_id = $table->id;
        $this->param1_signatory = $table->param1_signatory;
        $this->param1_designation = $table->param1_designation;
        $this->param2_signatory = $table->param2_signatory;
        $this->param2_designation = $table->param2_designation;
        $this->param3_signatory = $table->param3_signatory;
        $this->param3_designation = $table->param3_designation;
    }

    public function openCreateUpdateSignatoriesModal(){
        $this->signatories();
        $this->dispatch('openCreateUpdateSignatoriesModal');
    }

    public function updatesignatories(){
        $table = LibSignatory::find($this->signatory_id);
        $table->param1_signatory = $this->param1_signatory;
        $table->param1_designation = $this->param1_designation;
        $table->param2_signatory = $this->param2_signatory;
        $table->param2_designation = $this->param2_designation;
        $table->param3_signatory = $this->param3_signatory;
        $table->param3_designation = $this->param3_designation;
        
        if ($table->update()) {
            $this->dispatch('closeModal');

            doLog($table, request()->ip(), 'My Leave', 'Updated');
            $this->js("showNotification('success', 'My Leave - Signatories data has been updated successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong')");
        }
    }

    public function print($id){
        $this->printViewFileUrl = 'my-leave-print/'.$id;
        $this->dispatch('openNewWindow', ['viewFileUrl' => $this->printViewFileUrl]);
    }

    public function printleave($id){
        $data = HrLeave::find( $id );
        if ($data->days > 1){
            $days = 'Days';
        } else {
            $days = 'Day';
        }

        if ($data->date_from == $data->date_to){
            $inclusive_dates = date_format(date_create($data->date_from), 'm/d/Y');
        } else {
            $inclusive_dates = date_format(date_create($data->date_from), 'm/d/Y') . ' - ' . date_format(date_create($data->date_to), 'm/d/Y');
        }

        $signatories = LibSignatory::where([
            ['user_id', $data->user_id],
            ['for', 'Leave']
        ])->first();

        return view('livewire.my.print-form-6-r2020', compact(
            'data', 'days', 'inclusive_dates', 'signatories'
        )); 
    }
    
    public function selectedValuePerPage(){
        $this->perPage;
    }

    public function sortBy($field){
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        
        $this->sortField = $field;
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
        ->where('hl.user_id', '=', Auth::user()->id)
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
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
        ->where('hl.user_id', '=', Auth::user()->id)
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);
    
        $this->resetPage();

        $this->totalTableDataCount = $this->tableList->count();
    }

    public function myLeaveCreditsAvailable(){
        $this->myLeaveCreditsAvailable = HrLeaveCreditsAvailable::where('user_id', Auth::user()->id)->get();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }

        $this->myLeaveCreditsAvailable();

        return view('livewire.my.leave', [
            'tableList' => $this->tableList,
        ]);
    }
}
