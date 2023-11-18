<?php

namespace App\Livewire\Plantilla;

use App\Models\HrPlantillas;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Plantillas')]
#[Layout('layouts.dashboard-app')] 
class Plantillas extends Component
{
    use WithPagination;

    protected $tableList;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch = false;
    public $itemNumberAdvancedSearchField,
           $userIdAdvancedSearchField, $positionIdAdvancedSearchField,
           $salaryIdAdvancedSearchField, $statusAdvancedSearchField,
           $remarksAdvancedSearchField, $isPlantillaAdvancedSearchField,
           $dateCreatedAdvancedSearchField = '';

    public $counter = 0;
    public $totalTableDataCount = 0;

    public $id, $item_number, $user_id, $position_id,
           $salary_id, $status, $remarks, $is_plantilla = '';

    public $isUpdateMode = false;
    public $deleteId = '';

    public function openCreateUpdateModal(){
        $this->dispatch('openCreateUpdateModal');
    }

    private function resetInputFields(){
        $this->item_number = '';
        $this->user_id = '';
        $this->position_id = '';
        $this->salary_id = '';
        $this->status = '';
        $this->remarks = '';
        $this->is_plantilla = '';
        artisanClear();
    }

    private function resetAdvancedSearchFields(){
        $this->itemNumberAdvancedSearchField = '';
        $this->userIdAdvancedSearchField = '';
        $this->positionIdAdvancedSearchField = '';
        $this->salaryIdAdvancedSearchField = '';
        $this->statusAdvancedSearchField = '';
        $this->remarksAdvancedSearchField = '';
        $this->isPlantillaAdvancedSearchField = '';
        $this->dateCreatedAdvancedSearchField = '';
    }

    public function closeModal(){
        $this->isUpdateMode = false;
        $this->resetInputFields();
        $this->dispatch('closeModal');
    }

    public function store(){
        $this->validate([
            'item_number' => 'required|unique:hr_plantillas,item_number',
            'position_id' => 'required',
            'salary_id' => 'required',
            'status' => 'required|string|max:255',
            'is_plantilla' => 'required|in:Yes,No'
        ]);

        if (!empty($this->user_id)){
            $userExistsInPlantilla = HrPlantillas::where('user_id', $this->user_id)->first();
            if ($userExistsInPlantilla){
                $this->js("showNotification('error', 'User already exists in Plantilla.')");
                return;
            }
        }

        $table = new HrPlantillas();
        $table->item_number = $this->item_number;
        $table->user_id = !empty($this->user_id) ? $this->user_id : null;
        $table->position_id = $this->position_id;
        $table->salary_id = $this->salary_id;
        $table->status = $this->status;
        $table->remarks = $this->remarks;
        $table->is_plantilla = $this->is_plantilla;
        
        if ($table->save()) {
            $this->resetInputFields();
            $this->dispatch('closeModal');

            doLog($table, request()->ip(), 'Plantillas', 'Created');
            $this->js("showNotification('success', 'Plantilla data has been saved successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function edit($id){
        $this->isUpdateMode = true;
        $this->resetInputFields();
        $this->dispatch('openCreateUpdateModal');

        $table = HrPlantillas::find($id);
        $this->id = $table->id;
        $this->item_number = $table->item_number;
        $this->user_id = $table->user_id;
        $this->position_id = $table->position_id;
        $this->salary_id = $table->salary_id;
        $this->status = $table->status;
        $this->remarks = $table->remarks;
        $this->is_plantilla = $table->is_plantilla;
    }

    public function update(){
        $this->validate([
            'item_number' =>  [
                'required',
                Rule::unique('hr_plantillas')
                    ->where('item_number', $this->item_number)
                    ->ignore($this->id)
            ],
            'position_id' => 'required',
            'salary_id' => 'required',
            'status' => 'required|string|max:255',
            'is_plantilla' => 'required|in:Yes,No'
        ]);

        if (!empty($this->user_id)){
            $userExistsInPlantilla = HrPlantillas::where([
                ['user_id', $this->user_id],
                ['item_number', '!=', $this->item_number],
            ])->first();
            if ($userExistsInPlantilla){
                $this->js("showNotification('error', 'User already exists in Plantilla.')");
                return;
            }
        }

        $table = HrPlantillas::find($this->id);
        $table->item_number = $this->item_number;
        $table->user_id = !empty($this->user_id) ? $this->user_id : null;
        $table->position_id = $this->position_id;
        $table->salary_id = $this->salary_id;
        $table->status = $this->status;
        $table->remarks = $this->remarks;
        $table->is_plantilla = $this->is_plantilla;
        
        if ($table->update()) {
            $this->resetInputFields();
            $this->dispatch('closeModal');

            doLog($table, request()->ip(), 'Plantillas', 'Updated');
            $this->js("showNotification('success', 'Plantilla data has been updated successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong')");
        }
    }

    public function toBeDeleted($id){
        $this->deleteId = $id;
        $this->dispatch('openDeletionModal');

        $table = HrPlantillas::find($id);
        $this->id = $table->id;
        $this->item_number = $table->item_number;
        $this->user_id = $table->user_id;
        $this->position_id = $table->position_id;
        $this->salary_id = $table->salary_id;
        $this->status = $table->status;
        $this->remarks = $table->remarks;
        $this->is_plantilla = $table->is_plantilla;
    }

    public function delete(){
        $oldTable = HrPlantillas::from('hr_plantillas as hp')
            ->select(
                'hp.*',
                'upi.*'
            )
            ->leftJoin('user_personal_informations as upi', 'hp.user_id', '=', 'upi.user_id')
            ->where('hp.id', $this->deleteId)
            ->first();

        $table = HrPlantillas::find($this->deleteId);
        if ($table->delete()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($oldTable, request()->ip(), 'Plantillas', 'Deleted');
            $this->js("showNotification('success', 'The selected Plantilla has been deleted successfully.')");
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
        $this->tableList = HrPlantillas::from('hr_plantillas as hp')
        ->select(
            'hp.*',
            DB::raw("DATE_FORMAT(hp.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'upi.firstname as upi_firstname',
            'upi.middlename as upi_middlename',
            'upi.lastname as upi_lastname',
            'upi.extname as upi_extname',
            'lp.code as lp_code',
            'lp.abbreviation as lp_abbreviation',
            'lp.name as lp_name',
            'ls.id as ls_id',
            'ls.tranche as ls_tranche',
            'ls.grade as ls_grade',
            'ls.step as ls_step',
            'ls.basic as ls_basic'
        )
        ->leftJoin('user_personal_informations as upi', 'hp.user_id', '=', 'upi.user_id')
        ->leftJoin('lib_positions as lp', 'hp.position_id', '=', 'lp.id')
        ->leftJoin('lib_salaries as ls', 'hp.salary_id', '=', 'ls.id')
        ->where('upi.firstname', 'like', '%'.trim($this->search).'%')
        ->orWhere('upi.middlename', 'like', '%'.trim($this->search).'%')
        ->orWhere('upi.lastname', 'like', '%'.trim($this->search).'%')
        ->orWhere('upi.extname', 'like', '%'.trim($this->search).'%')
        ->orWhere('lp.code', 'like', '%'.trim($this->search).'%')
        ->orWhere('lp.abbreviation', 'like', '%'.trim($this->search).'%')
        ->orWhere('lp.name', 'like', '%'.trim($this->search).'%')
        ->orWhere('ls.tranche', 'like', '%'.trim($this->search).'%')
        ->orWhere('ls.grade', 'like', '%'.trim($this->search).'%')
        ->orWhere('ls.step', 'like', '%'.trim($this->search).'%')
        ->orWhere('ls.basic', 'like', '%'.trim($this->search).'%')
        ->orWhere('hp.created_at', 'like', '%'.trim($this->search).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function performAdvancedSearch(){
        if ($this->userIdAdvancedSearchField){
            $userNameCondition = function ($query) {
                $query->where('hp.user_id', 'like', '%' . trim($this->userIdAdvancedSearchField) . '%');
            };
        } else {
            $userNameCondition = function ($query) {
                $query->where('hp.user_id', 'like', '%' . trim($this->userIdAdvancedSearchField) . '%')
                    ->orWhereNull('hp.user_id');
            };
        }

        if ($this->remarksAdvancedSearchField){
            $remarksCondition = function ($query) {
                $query->where('hp.remarks', 'like', '%' . trim($this->remarksAdvancedSearchField) . '%');
            };
        } else {
            $remarksCondition = function ($query) {
                $query->where('hp.remarks', 'like', '%' . trim($this->remarksAdvancedSearchField) . '%')
                    ->orWhereNull('hp.remarks');
            };
        }

        $this->tableList = HrPlantillas::from('hr_plantillas as hp')
        ->select(
            'hp.*',
            DB::raw("DATE_FORMAT(hp.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'upi.firstname as upi_firstname',
            'upi.middlename as upi_middlename',
            'upi.lastname as upi_lastname',
            'upi.extname as upi_extname',
            'lp.code as lp_code',
            'lp.abbreviation as lp_abbreviation',
            'lp.name as lp_name',
            'ls.tranche as ls_tranche',
            'ls.grade as ls_grade',
            'ls.step as ls_step',
            'ls.basic as ls_basic'
        )
        ->leftJoin('user_personal_informations as upi', 'hp.user_id', '=', 'upi.user_id')
        ->leftJoin('lib_positions as lp', 'hp.position_id', '=', 'lp.id')
        ->leftJoin('lib_salaries as ls', 'hp.salary_id', '=', 'ls.id')
        ->where($userNameCondition)
        ->where('hp.item_number', 'like', '%'.trim($this->itemNumberAdvancedSearchField).'%')
        ->where('hp.position_id', 'like', '%'.trim($this->positionIdAdvancedSearchField).'%')
        ->where('hp.salary_id', 'like', '%'.trim($this->salaryIdAdvancedSearchField).'%')
        ->where('hp.status', 'like', '%'.trim($this->statusAdvancedSearchField).'%')
        ->where($remarksCondition)
        ->where('hp.is_plantilla', 'like', '%'.trim($this->isPlantillaAdvancedSearchField).'%')
        ->where('hp.created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);
    
        $this->resetPage();
    }

    public function totalTableDataCount(){
        $this->totalTableDataCount = HrPlantillas::get()->count();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }
        
        $this->totalTableDataCount();

        return view('livewire.plantilla.plantillas', [
            'tableList' => $this->tableList,
        ]);
    }
}
