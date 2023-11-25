<?php

namespace App\Livewire\Leave;

use App\Models\HrLeaveCreditsAvailable;
use App\Models\HrLeaveCreditsAvailableList;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Leave Earnings')]
#[Layout('layouts.dashboard-app')] 
class LeaveEarnings extends Component
{
    use WithPagination;

    protected $tableList;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch = false;
    public $userIdAdvancedSearchField, $leaveTypeIdAdvancedSearchField, $monthAdvancedSearchField,
           $yearAdvancedSearchField, $valueAdvancedSearchField,
           $dateFromAdvancedSearchField, $dateToAdvancedSearchField,
           $remarksAdvancedSearchField, $dateCreatedAdvancedSearchField = '';

    public $counter = 0;
    public $totalTableDataCount = 0;
    public $id, $user_id, $leave_credits_available_id, $month, $year,
           $hlcalValue, $date_from, $date_to, $remarks;

    public $isUpdateMode = false;
    public $deleteId = '';

    public function openCreateUpdateModal(){
        $this->dispatch('openCreateUpdateModal');
    }

    private function resetInputFields(){
        $this->user_id = '';
        $this->leave_credits_available_id = '';
        $this->month = '';
        $this->year = '';
        $this->hlcalValue = '';
        $this->date_from = '';
        $this->date_to = '';
        $this->remarks = '';
        artisanClear();
    }

    private function resetAdvancedSearchFields(){
        $this->userIdAdvancedSearchField = '';
        $this->leaveTypeIdAdvancedSearchField = '';
        $this->monthAdvancedSearchField = '';
        $this->yearAdvancedSearchField = '';
        $this->valueAdvancedSearchField = '';
        $this->dateFromAdvancedSearchField = '';
        $this->dateToAdvancedSearchField = '';
        $this->remarksAdvancedSearchField = '';
        $this->dateCreatedAdvancedSearchField = '';
    }

    public function closeModal(){
        $this->isUpdateMode = false;
        $this->resetInputFields();
        $this->dispatch('closeModal');
    }

    // public function store(){
    //     $this->validate([
    //         'month' => 'required|in:January,February,March,April,May,June,July,August,September,October,November,December',
    //         'year' => 'required|digits:4',
    //         'value' => 'required|numeric',
    //         'date_from' => 'required|date',
    //         'date_to' => 'required|date',
    //         'remarks' => 'required'
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         $credit = 1.25;

    //         $successNewCounter = 0;
    //         $noLeaveCounter = 0;
    //         $inHlclCounter = 0;

    //         // removing duplicate ids
    //         $user_ids = implode(',',array_unique(explode(',', $request['user_ids'])));

    //         // uses to loop in multiple data
    //         $userIds = explode(',', $user_ids);
    //         $leaveIds = $request['leave_types'];

    //         foreach ($leaveIds as $leaveId){
    //             foreach ($userIds as $userId){
    //                 // check if exist in credit available table
    //                 $hlca = HrLeaveCreditsAvailable::where([
    //                     ['leave_id', '=', $leaveId],
    //                     ['user_id', '=', $userId],
    //                     ['year', '=', $request['year']]
    //                 ])->first();

    //                 if ($hlca){
    //                     // check if exist in credit list table
    //                     $hlcl = HrLeaveCreditsList::where([
    //                         ['leave_credits_available_id', '=', $hlca->id],
    //                         ['month', '=', $request['month']],
    //                         ['year', '=', $request['year']]
    //                     ])->first();

    //                     if ($hlcl){
    //                         // exists
    //                         $inHlclCounter ++;
    //                     } else {
    //                         // not exists | create
    //                         $table = new HrLeaveCreditsList();

    //                         $query_date = $request['year'] . '-' . month2($request['month']) . '-01';
    //                         $date_from = date('Y-m-01', strtotime($query_date));
    //                         $date_to = date('Y-m-t', strtotime($query_date));

    //                         $formData = array(
    //                             'leave_credits_available_id' => $hlca->id,
    //                             'month' => $request['month'],
    //                             'year' => $request['year'],
    //                             'value' => $credit,
    //                             'date_from' => $date_from,
    //                             'date_to' => $date_to,
    //                             'remarks' => $request['remarks'],
    //                             'is_expired' => 0
    //                         );

    //                         if ($table->create($formData)){
    //                             $successNewCounter ++;

    //                             $formData = array(
    //                                 'available' => $hlca->available + $credit,
    //                                 'balance' => $hlca->balance + $credit
    //                             );
    //                             $hlca->update($formData);
    //                         }
    //                     }
    //                 } else {
    //                     $hlca = new HrLeaveCreditsAvailable();
    //                     $hlca->leave_id     = $leaveId;
    //                     $hlca->user_id      = $userId;
    //                     $hlca->year         = $request['year'];
    //                     $hlca->available    = $request['value'];
    //                     $hlca->used         = 0;
    //                     $hlca->balance      = $request['value'];
    //                     if ($hlca->save()){
    //                         // not exists | create
    //                         $table = new HrLeaveCreditsList();

    //                         $query_date = $request['year'] . '-' . month2($request['month']) . '-01';
    //                         $date_from = date('Y-m-01', strtotime($query_date));
    //                         $date_to = date('Y-m-t', strtotime($query_date));

    //                         $formData = array(
    //                             'leave_credits_available_id' => $hlca->id,
    //                             'month' => $request['month'],
    //                             'year' => $request['year'],
    //                             'value' => $credit,
    //                             'date_from' => $date_from,
    //                             'date_to' => $date_to,
    //                             'remarks' => $request['remarks'],
    //                             'is_expired' => 0
    //                         );

    //                         if ($table->create($formData)){
    //                             $successNewCounter ++;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
            

    //         if ($inHlclCounter > 0 || $successNewCounter > 0 || $noLeaveCounter > 0){
    //             doLog('Leave Earning for '.$request['month'].' '.$request['year'], 'Human Resource - Leave Management - Monthly Leave Earnings (Non-Teaching)', 'Create');

    //             DB::commit();
    //             return response()->json([
    //                 'success' =>
    //                     'Leave Earned successfully created: ' . $successNewCounter . '<br><br>' .
    //                     'Leave Earned already exists: ' . $inHlclCounter . '<br><br>'
    //             ]);
    //         } else {
    //             DB::rollback();
    //             return response()->json(['error' => 'Leave Earned not created.']);
    //         }
    //     } catch (\Throwable $e){
    //         DB::rollback();
    //         return response()->json(['error' => $e]);
    //     }
    // }

    public function toBeDeleted($id){
        $this->deleteId = $id;
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
        ->where('hlcal.id', $this->deleteId)
        ->first();

        $this->user_id = $table->hlca_user_id;
        $this->leave_credits_available_id = $table->llt_name;
        $this->month = $table->month;
        $this->year = $table->year;
        $this->hlcalValue = number_format($table->value, 3);
        $this->date_from = $table->date_from;
        $this->date_to = $table->date_to;
        $this->remarks = $table->remarks;
    }

    public function delete(){
        $oldTable = HrLeaveCreditsAvailableList::find($this->deleteId);

        $table2 = HrLeaveCreditsAvailable::find($oldTable->leave_credits_available_id);
        $prevAvailable = $table2->available - $oldTable->value;
        $prevBalance = $table2->balance - $oldTable->value;
        $table2->available = $prevAvailable;
        $table2->balance = $prevBalance;
        if ($table2->available < $table2->used){
            $this->js("showNotification('error', 'Deletion is restricted due to a detected negative balance outcome.')");
            return;
        }

        $table = HrLeaveCreditsAvailableList::find($this->deleteId);
        if ($table->delete()){
            $table2->update();
            
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($oldTable, request()->ip(), 'Leave Earnings', 'Deleted');
            $this->js("showNotification('success', 'The selected Leave Earning has been deleted successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
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
        $this->tableList = HrLeaveCreditsAvailableList::from('hr_leave_credits_available_list as hlcal')
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
            $query->where('upi.firstname', 'like', '%'.trim($this->search).'%')
                ->orWhere('upi.lastname', 'like', '%'.trim($this->search).'%')
                ->orWhere('llt.name', 'like', '%'.trim($this->search).'%')
                ->orWhere('hlcal.month', 'like', '%'.trim($this->search).'%')
                ->orWhere('hlcal.year', 'like', '%'.trim($this->search).'%')
                ->orWhere('hlcal.value', 'like', '%'.trim($this->search).'%')
                ->orWhere('hlcal.date_from', 'like', '%'.trim($this->search).'%')
                ->orWhere('hlcal.date_to', 'like', '%'.trim($this->search).'%')
                ->orWhere('hlcal.remarks', 'like', '%'.trim($this->search).'%')
                ->orWhere('hlcal.created_at', 'like', '%'.trim($this->search).'%');
        })
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
        
        $this->totalTableDataCount = $this->tableList->count();
    }

    public function performAdvancedSearch(){
        $this->tableList = HrLeaveCreditsAvailableList::from('hr_leave_credits_available_list as hlcal')
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
        ->where('hlca.user_id', 'like', '%'.trim($this->userIdAdvancedSearchField).'%')
        ->where('llt.id', 'like', '%'.trim($this->leaveTypeIdAdvancedSearchField).'%')
        ->where('hlcal.month', 'like', '%'.trim($this->monthAdvancedSearchField).'%')
        ->where('hlcal.year', 'like', '%'.trim($this->yearAdvancedSearchField).'%')
        ->where('hlcal.value', 'like', '%'.trim($this->valueAdvancedSearchField).'%')
        ->where('hlcal.date_from', 'like', '%'.trim($this->dateFromAdvancedSearchField).'%')
        ->where('hlcal.date_to', 'like', '%'.trim($this->dateToAdvancedSearchField).'%')
        ->where('hlcal.remarks', 'like', '%'.trim($this->remarksAdvancedSearchField).'%')
        ->where('hlcal.created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);
    
        $this->resetPage();
        
        $this->totalTableDataCount = $this->tableList->count();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }

        return view('livewire.leave.leave-earnings', [
            'tableList' => $this->tableList,
        ]);
    }
}