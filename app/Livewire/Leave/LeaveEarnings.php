<?php

namespace App\Livewire\Leave;

use App\Models\HrLeaveCreditsAvailable;
use App\Models\HrLeaveCreditsAvailableList;
use App\Models\HrPlantilla;
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
    public $id, $leave_type_name, $user_name, $leave_credits_available_id, $month, $year,
           $hlcalValue, $date_from, $date_to, $remarks;
    public $leave_type_id = [];
    public $user_id = [];

    public $isUpdateMode = false;
    public $deleteId = '';

    public function openCreateUpdateModal(){
        $this->dispatch('openCreateUpdateModal');
    }

    private function resetInputFields(){
        $this->user_id = [];
        $this->user_name = '';
        $this->leave_type_id = [];
        $this->leave_type_name = '';
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

    public function store(){
        $this->validate([
            'month' => 'required|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'year' => 'required|digits:4',
            'hlcalValue' => 'required|numeric',
            'remarks' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $successNewCounter = 0;
            $noLeaveCounter = 0;
            $inHlcalCounter = 0;

            if (count($this->user_id) > 1 && in_array('All Plantilla Users', $this->user_id)) {
                $this->js("showNotification('error', 'Selecting \'All Plantilla Users\' along with individual users is not permitted.')");
                return;
            } else {
                if (in_array('All Plantilla Users', $this->user_id)){
                    $plantillaUsers = HrPlantilla::where(function($query) {
                        $query->whereNotNull('user_id')
                            ->where('is_plantilla', 'Yes');
                    })->get();
    
                    $this->user_id = $plantillaUsers->pluck('user_id')->toArray();
                }
            }

            foreach ($this->leave_type_id as $leaveTypeId){
                foreach ($this->user_id as $userId){
                    // check if exist in credit available table
                    $hlca = HrLeaveCreditsAvailable::where([
                        ['leave_type_id', '=', $leaveTypeId],
                        ['user_id', '=', $userId]
                    ])->first();

                    if ($hlca){
                        // check if exist in credit list table
                        $hlcal = HrLeaveCreditsAvailableList::where([
                            ['leave_credits_available_id', '=', $hlca->id],
                            ['month', '=', $this->month],
                            ['year', '=', $this->year],
                            ['remarks', '=', $this->remarks]
                        ])->first();

                        if ($hlcal){
                            // exists
                            $inHlcalCounter ++;
                        } else {
                            // not exists | create
                            $query_date = $this->year . '-' . months2($this->month) . '-01';
                            $this->date_from = date('Y-m-01', strtotime($query_date));
                            $this->date_to = date('Y-m-t', strtotime($query_date));

                            $table = new HrLeaveCreditsAvailableList();
                            $table->leave_credits_available_id = $hlca->id;
                            $table->month = $this->month;
                            $table->year = $this->year;
                            $table->value = $this->hlcalValue;
                            $table->date_from = $this->date_from;
                            $table->date_to = $this->date_to;
                            $table->remarks = $this->remarks;

                            if ($table->save()){
                                $successNewCounter ++;

                                $hlca->available += $this->hlcalValue;
                                $hlca->balance += $this->hlcalValue;
                                $hlca->update();
                            }
                        }
                    } else {
                        $hlca = new HrLeaveCreditsAvailable();
                        $hlca->leave_type_id = $leaveTypeId;
                        $hlca->user_id = $userId;
                        $hlca->available = $this->hlcalValue;
                        $hlca->used = 0;
                        $hlca->balance = $this->hlcalValue;
                        if ($hlca->save()){
                            // not exists | create
                            $query_date = $this->year . '-' . months2($this->month) . '-01';
                            $this->date_from = date('Y-m-01', strtotime($query_date));
                            $this->date_to = date('Y-m-t', strtotime($query_date));

                            $table = new HrLeaveCreditsAvailableList();
                            $table->leave_credits_available_id = $hlca->id;
                            $table->month = $this->month;
                            $table->year = $this->year;
                            $table->value = $this->hlcalValue;
                            $table->date_from = $this->date_from;
                            $table->date_to = $this->date_to;
                            $table->remarks = $this->remarks;

                            if ($table->save()){
                                $successNewCounter ++;
                                doLog($table, request()->ip(), 'Leave Earnings', 'Created');
                            }
                        }
                    }
                }
            }

            if ($inHlcalCounter > 0 || $successNewCounter > 0 || $noLeaveCounter > 0){
                DB::commit();
                $message = "Leave Earnings successfully created: $successNewCounter <br>" .
                           "Leave Earnings already exists: $inHlcalCounter <br><br>";

                $this->js("showNotification('success', '$message')");
            } else {
                DB::rollback();
                $this->js("showNotification('error', 'Something went wrong.')");
            }
        } catch (\Throwable $e){
            DB::rollback();
            $this->js("showNotification('error', 'Something went wrong 2.')");
        }
    }

    public function toBeDeleted($id){
        $this->deleteId = $id;
        $this->dispatch('openDeletionModal');

        $table = HrLeaveCreditsAvailableList::from('hr_leave_credits_available_list as hlcal')
        ->select(
            'hlcal.*',
            'llt.name as llt_name',
            'hlca.user_id as hlca_user_id',
            'upi.firstname as upi_firstname',
            'upi.lastname as upi_lastname'
        )
        ->leftJoin('hr_leave_credits_available as hlca', 'hlcal.leave_credits_available_id', '=', 'hlca.id')
        ->leftJoin('lib_leave_types as llt', 'hlca.leave_type_id', '=', 'llt.id')
        ->leftJoin('user_personal_informations as upi', 'hlca.user_id', '=', 'upi.user_id')
        ->where('hlcal.id', $this->deleteId)
        ->first();

        $this->user_name = $table->upi_firstname . ' ' . $table->upi_lastname;
        $this->leave_type_name = $table->llt_name;
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