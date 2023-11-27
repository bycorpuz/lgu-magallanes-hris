<?php

namespace App\Livewire\Leave;

use App\Models\HrLeave;
use App\Models\HrLeaveCreditsAvailable;
use App\Models\HrLeaveCreditsAvailableList;
use Carbon\Carbon;
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

    public $hlId, $tracking_code, $leave_type_id, $user_id,
           $days, $date_from, $date_to, $is_with_pay, $remarks,
           $date_approved, $date_disapproved, $date_cancelled, $date_processing,
           $details_b1, $details_b1_name, $details_b2, $details_b2_name,
           $details_b3_name, $details_b4, $details_b5, $details_d1 = '';
    public $isUpdateMode = false;

    public $printViewFileUrl2;
    protected $tableList2;
    public $sortField2 = 'created_at';
    public $sortDirection2 = 'desc';
    public $availableAdvancedSearchField2, $usedAdvancedSearchField2,
           $balanceAdvancedSearchField2, $dateCreatedAdvancedSearchField2 = '';
    public $counter2 = 0;
    public $hlcaId, $month2, $year2, $value2, $date_from2, $date_to2, $remarks2, $modal_title2, $status2 = '';
    public $isUpdateMode2 = false;

    protected $tableList3;
    public $search3 = '';
    public $sortField3 = 'created_at';
    public $sortDirection3 = 'desc';
    public $showAdvancedSearch3 = false;
    public $userIdAdvancedSearchField3, $leaveTypeIdAdvancedSearchField3, $monthAdvancedSearchField3, $yearAdvancedSearchField3,
           $valueAdvancedSearchField3, $dateFromAdvancedSearchField3, $dateToAdvancedSearchField3,
           $remarksAdvancedSearchField3, $dateCreatedAdvancedSearchField3 = '';
    public $counter3 = 0;
    public $totalTableDataCount3 = 0;
    public $hlcalId, $month3, $year3, $value3, $date_from3, $date_to3, $remarks3, $modal_title3= '';
    public $deleteId3;

    private function resetAdvancedSearchFields(){
        $this->trackingCodeAdvancedSearchField = '';
        $this->leaveTypeIdAdvancedSearchField = '';
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

    private function resetAdvancedSearchFields3(){
        $this->userIdAdvancedSearchField3 = '';
        $this->leaveTypeIdAdvancedSearchField3 = '';
        $this->monthAdvancedSearchField3 = '';
        $this->yearAdvancedSearchField3 = '';
        $this->valueAdvancedSearchField3 = '';
        $this->dateFromAdvancedSearchField3 = '';
        $this->dateToAdvancedSearchField3 = '';
        $this->remarksAdvancedSearchField3 = '';
        $this->dateCreatedAdvancedSearchField3 = '';
    }

    public function closeModal(){
        $this->isUpdateMode = false;
        $this->isUpdateMode2 = false;
        $this->resetInputFields();
        $this->resetInputFields2();
        $this->dispatch('closeModal');
    }

    public function closeDeletionModal(){
        $this->resetInputFields2();
        $this->dispatch('closeDeletionModal');
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

    private function resetInputFields2(){
        $this->month2 = '';
        $this->year2 = '';
        $this->value2 = '';
        $this->date_from2 = '';
        $this->date_to2 = '';
        $this->remarks2 = '';
        artisanClear();
    }

    public function calculateDays(){
        if ($this->date_from && $this->date_to) {
            $start = Carbon::parse($this->date_from);
            $end = Carbon::parse($this->date_to);

            $this->days = $end->diffInDays($start) + 1;
        } else {
            $this->days = 1;
        }
    }

    public function edit($id){
        $this->isUpdateMode = true;
        $this->resetInputFields();
        $this->dispatch('openCreateUpdateModal');

        $table = HrLeave::find($id);
        $this->hlId = $table->id;
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

    public function updateleave(){
        $this->validate([
            'leave_type_id' => 'required',
            'days' => 'required|numeric',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'is_with_pay' => 'required|in:Yes,No'
        ]);

        $table = HrLeave::find($this->hlId);
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

            doLog($table, request()->ip(), 'Leaves', 'Updated');
            $this->js("showNotification('success', 'Leave data has been updated successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong')");
        }
    }

    public function addleavecredits($id){
        $this->hlcaId = $id;
        $hlca = HrLeaveCreditsAvailable::find($this->hlcaId);
        $this->modal_title2 = $hlca->leaveType->name;

        $this->dispatch('openModelAddLeaveCreditsModal');
    }

    public function addleavecreditsform(){
        $this->validate([
            'month2' => 'required|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'year2' => 'required|digits:4',
            'value2' => 'required|numeric',
            'date_from2' => 'required|date',
            'date_to2' => 'required|date',
            'remarks2' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $table = new HrLeaveCreditsAvailableList();
            $table->leave_credits_available_id = $this->hlcaId;
            $table->month = $this->month2;
            $table->year = $this->year2;
            $table->value = $this->value2;
            $table->date_from = $this->date_from2;
            $table->date_to = $this->date_to2;
            $table->remarks = $this->remarks2;
            
            if ($table->save()) {
                $table2 = HrLeaveCreditsAvailable::find($this->hlcaId);
                $table2->available += $this->value2;
                $table2->balance += $this->value2;
                $table2->update();

                DB::commit();

                $this->resetInputFields2();

                doLog($table, request()->ip(), 'Leaves', 'Created');
                $this->js("showNotification('success', 'Leave Credits data has been saved successfully.')");
            } else {
                $this->js("showNotification('error', 'Something went wrong.')");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->js("showNotification('error', 'Something went wrong.");
        }
    }

    public function editleavecredits($id){
        $this->isUpdateMode2 = true;
        $this->resetInputFields2();

        $table = HrLeaveCreditsAvailableList::find($id);
        $this->hlcalId = $table->id;
        $this->month2 = $table->month;
        $this->year2 = $table->year;
        $this->value2 = $table->value;
        $this->date_from2 = $table->date_from;
        $this->date_to2 = $table->date_to;
        $this->remarks2 = $table->remarks;
        
        $this->showAdvancedSearch3 = false;
        $this->search3 = '';
        $this->resetAdvancedSearchFields3();
    }

    public function updateleavecreditsform(){
        $this->validate([
            'month2' => 'required|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'year2' => 'required|digits:4',
            'value2' => 'required|numeric',
            'date_from2' => 'required|date',
            'date_to2' => 'required|date',
            'remarks2' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $table = HrLeaveCreditsAvailableList::find($this->hlcalId);
            $oldValue = $table->value;
            $table->month = $this->month2;
            $table->year = $this->year2;
            $table->value = $this->value2;
            $table->date_from = $this->date_from2;
            $table->date_to = $this->date_to2;
            $table->remarks = $this->remarks2;

            if ($oldValue < 0) {
                $this->js("showNotification('error', 'Editing of negative values is restricted. Kindly consult with the system administrator for further assistance.')");
                $this->resetInputFields2();
                return;
            } else {
                $table2 = HrLeaveCreditsAvailable::find($this->hlcaId);
                $prevAvailable = $table2->available - $oldValue;
                $prevBalance = $table2->balance - $oldValue;

                $table2->available = $prevAvailable + $this->value2;
                $table2->balance = $prevBalance + $this->value2;
            }
            
            if ($table->update()) {
                $table2->update();
                DB::commit();

                $this->isUpdateMode2 = false;
                $this->resetInputFields2();

                doLog($table, request()->ip(), 'Leaves', 'Updated');
                $this->js("showNotification('success', 'Leave data has been updated successfully.')");
            } else {
                $this->js("showNotification('error', 'Something went wrong.')");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->js("showNotification('error', 'Something went wrong.");
        }
    } 

    public function print($id){
        $this->printViewFileUrl2 = 'my-leave-print/'.$id;
        $this->dispatch('openNewWindow', ['viewFileUrl' => $this->printViewFileUrl2]);
    }

    public function changestatus($action, $id){
        $flag = 0;
        $table = HrLeave::find($id);

        if ($table){
            // check if selected leave is with pay to proceed to deduction
            if ($table->is_with_pay == 'Yes'){

                $table2 = HrLeaveCreditsAvailable::where([
                    ['user_id', '=', $table->user_id],
                    ['leave_type_id', '=', $table->leave_type_id]
                ])->first();

                // check if selected leave exists
                if ($table2){

                    // check if what action is being selected
                    if ($action == 'Approved'){
                        // check whether to deduct or add selected leave credits
                        if ($table->status == 'Approved'){
                            $flag = 1;
                        } else {
                            $requestedLeave = $table->days;
                            $leaveBalance = $table2->balance;
                            $leaveUsed = $table2->used;

                            // check if selected leave has available leave credits (deduct requested leave to balance and add to used)
                            if ($requestedLeave > $leaveBalance){
                                $this->js("showNotification('error', 'Selected Leave number of days is greater than Leave Balance.')");
                                return;
                            } else {
                                $newBalance = $leaveBalance - $requestedLeave;
                                $used = $leaveUsed + $requestedLeave;

                                $table2->balance = $newBalance;
                                $table2->used = $used;
                                
                                if ($table2->update()){
                                    $flag = 1;
                                }
                            }
                        }
                    } else {
                        // check whether to deduct or add selected leave credits (add back the requested leave to balance and deduct to used)
                        if ($table->status == 'Approved'){
                            $requestedLeave = $table->days;
                            $leaveBalance = $table2->balance;
                            $leaveUsed = $table2->used;

                            $newBalance = $leaveBalance + $requestedLeave;
                            $used = $leaveUsed - $requestedLeave;

                            $table2->balance = $newBalance;
                            $table2->used = $used;

                            if ($table2->update()){
                                $flag = 1;
                            }
                        } else {
                            $flag = 1;
                        }
                    }

                } else {
                    $this->js("showNotification('error', 'Selected Leave is not yet created. Create Leave Type to proceed.')");
                    return;
                }
            } else {
                $flag = 1;
            }

            if ($flag == 1){
                // updating selected leave status purposes

                $date_approved      = $table->date_approved;
                $date_disapproved   = $table->date_disapproved;
                $date_cancelled     = $table->date_cancelled;
                $date_processing    = $table->date_processing;

                if ($action == 'Approved'){
                    $status = 'Approved';
                    $date_approved = date('Y-m-d H:i:s');
                    $date_disapproved = Null;
                    $date_cancelled = Null;

                } elseif ($action == 'Disapproved'){
                    $status = 'Disapproved';
                    $date_disapproved = date('Y-m-d H:i:s');
                    $date_approved = Null;
                    $date_cancelled = Null;

                } elseif ($action == 'Cancelled'){
                    $status = 'Cancelled';
                    $date_cancelled = date('Y-m-d H:i:s');
                    $date_approved = Null;
                    $date_disapproved = Null;

                } elseif ($action == 'Processing'){
                    $status = 'Processing';
                    $date_processing = date('Y-m-d H:i:s');

                } else {
                    $status = 'Pending';
                }

                $table->status = $status;
                $table->date_approved = $date_approved;
                $table->date_disapproved = $date_disapproved;
                $table->date_cancelled = $date_cancelled;
                $table->date_processing = $date_processing;

                if ($table->update()){
                    doLog($table, request()->ip(), 'Leaves', 'Updated');
                    $this->js("showNotification('success', 'Leave Status has been updated successfully.')");
                } else {
                    $this->js("showNotification('error', 'Leave Status not updated.')");
                }
            } else {
                $this->js("showNotification('error', 'Server Query Error.')");
            }

        } else {
            $this->js("showNotification('error', 'Selected Leave not found.')");
        }
    }

    public function toBeDeleted($id){
        $this->deleteId3 = $id;
        $this->dispatch('openDeletionModal');

        $table = HrLeaveCreditsAvailableList::from('hr_leave_credits_available_list as hlcal')
        ->select(
            'hlcal.*',
            'llt.name as llt_name',
            'hlca.user_id as hlca_user_id'
        )
        ->leftJoin('hr_leave_credits_available as hlca', 'hlcal.leave_credits_available_id', '=', 'hlca.id')
        ->leftJoin('lib_leave_types as llt', 'hlca.leave_type_id', '=', 'llt.id')
        ->leftJoin('user_personal_informations as upi', 'hlca.user_id', '=', 'upi.user_id')
        ->where('hlcal.id', $this->deleteId3)
        ->first();

        $this->hlcalId = $table->llt_name;
        $this->month3 = $table->month;
        $this->year3 = $table->year;
        $this->value3 = $table->value;
        $this->date_from3 = $table->date_from;
        $this->date_to3 = $table->date_to;
        $this->remarks3 = $table->remarks;
    }

    public function deleteleavecredits(){
        $oldTable = HrLeaveCreditsAvailableList::find($this->deleteId3);

        $table2 = HrLeaveCreditsAvailable::find($oldTable->leave_credits_available_id);
        $prevAvailable = $table2->available - $oldTable->value;
        $prevBalance = $table2->balance - $oldTable->value;
        $table2->available = $prevAvailable;
        $table2->balance = $prevBalance;
        if ($table2->available < $table2->used){
            $this->js("showNotification('error', 'Deletion is restricted due to a detected negative balance outcome.')");
            return;
        }

        $table = HrLeaveCreditsAvailableList::find($this->deleteId3);
        if ($table->delete()){
            $table2->update();
            
            $this->dispatch('closeDeletionModal');
            
            doLog($oldTable, request()->ip(), 'Leave Earnings', 'Deleted');
            $this->js("showNotification('success', 'The selected Leave Earning has been deleted successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
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

        if ($alias == 'hlcal'){
            if ($this->sortField3 === $field) {
                $this->sortDirection3 = $this->sortDirection3 === 'asc' ? 'desc' : 'asc';
            } else {
                $this->sortDirection3 = 'asc';
            }
            $this->sortField3 = $field;
        }
    }

    public function toggleAdvancedSearch(){
        $this->showAdvancedSearch = !$this->showAdvancedSearch;
        $this->search = '';
        $this->resetAdvancedSearchFields();
    }

    public function toggleAdvancedSearch3(){
        $this->showAdvancedSearch3 = !$this->showAdvancedSearch3;
        $this->search3 = '';
        $this->resetAdvancedSearchFields3();
        $this->isUpdateMode2 = false;
        $this->resetInputFields2();
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

    public function performGlobalSearch3(){
        $this->tableList3 = HrLeaveCreditsAvailableList::from('hr_leave_credits_available_list as hlcal')
        ->select(
            'hlcal.*',
            DB::raw("DATE_FORMAT(hlcal.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'llt.name as llt_name',
            'upi.firstname as upi_firstname',
            'upi.lastname as upi_lastname'
        )
        ->leftJoin('hr_leave_credits_available as hlca', 'hlcal.leave_credits_available_id', '=', 'hlca.id')
        ->leftJoin('lib_leave_types as llt', 'hlca.leave_type_id', '=', 'llt.id')
        ->leftJoin('user_personal_informations as upi', 'hlca.user_id', '=', 'upi.user_id')
        ->where(function ($query) {
            $query->where('upi.firstname', 'like', '%'.trim($this->search3).'%')
                ->orWhere('upi.lastname', 'like', '%'.trim($this->search3).'%')
                ->orWhere('llt.name', 'like', '%'.trim($this->search3).'%')
                ->orWhere('hlcal.month', 'like', '%'.trim($this->search3).'%')
                ->orWhere('hlcal.year', 'like', '%'.trim($this->search3).'%')
                ->orWhere('hlcal.value', 'like', '%'.trim($this->search3).'%')
                ->orWhere('hlcal.date_from', 'like', '%'.trim($this->search3).'%')
                ->orWhere('hlcal.date_to', 'like', '%'.trim($this->search3).'%')
                ->orWhere('hlcal.remarks', 'like', '%'.trim($this->search3).'%')
                ->orWhere('hlcal.created_at', 'like', '%'.trim($this->search3).'%');
        })
        ->where('hlca.id', '=', $this->hlcaId)
        ->orderBy($this->sortField3, $this->sortDirection3)
        ->paginate($this->perPage);

        $this->resetPage();
        
        $this->totalTableDataCount3 = $this->tableList3->count();
    }

    public function performAdvancedSearch3(){
        $this->tableList3 = HrLeaveCreditsAvailableList::from('hr_leave_credits_available_list as hlcal')
        ->select(
            'hlcal.*',
            DB::raw("DATE_FORMAT(hlcal.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'llt.name as llt_name',
            'upi.firstname as upi_firstname',
            'upi.lastname as upi_lastname'
        )
        ->leftJoin('hr_leave_credits_available as hlca', 'hlcal.leave_credits_available_id', '=', 'hlca.id')
        ->leftJoin('lib_leave_types as llt', 'hlca.leave_type_id', '=', 'llt.id')
        ->leftJoin('user_personal_informations as upi', 'hlca.user_id', '=', 'upi.user_id')
        ->where('hlca.user_id', 'like', '%'.trim($this->userIdAdvancedSearchField3).'%')
        ->where('llt.id', 'like', '%'.trim($this->leaveTypeIdAdvancedSearchField3).'%')
        ->where('hlcal.month', 'like', '%'.trim($this->monthAdvancedSearchField3).'%')
        ->where('hlcal.year', 'like', '%'.trim($this->yearAdvancedSearchField3).'%')
        ->where('hlcal.value', 'like', '%'.trim($this->valueAdvancedSearchField3).'%')
        ->where('hlcal.date_from', 'like', '%'.trim($this->dateFromAdvancedSearchField3).'%')
        ->where('hlcal.date_to', 'like', '%'.trim($this->dateToAdvancedSearchField3).'%')
        ->where('hlcal.remarks', 'like', '%'.trim($this->remarksAdvancedSearchField3).'%')
        ->where('hlcal.created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField3).'%')
        ->where('hlca.id', '=', $this->hlcaId)
        ->orderBy($this->sortField3, $this->sortDirection3)
        ->paginate($this->perPage);
    
        $this->resetPage();
        
        $this->totalTableDataCount3 = $this->tableList3->count();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }

        $this->performAdvancedSearch2();

        
        if ($this->search3){
            $this->performGlobalSearch3();
        } else {
            $this->performAdvancedSearch3();
        }
        

        return view('livewire.leave.leaves', [
            'tableList' => $this->tableList,
            'tableList2' => $this->tableList2,
            'tableList3' => $this->tableList3,
        ]);
    }
}