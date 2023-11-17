<?php

namespace App\Livewire\DatabaseLibraries;

use App\Models\LibLeaveType;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Database Libraries - Leave Types')]
#[Layout('layouts.dashboard-app')] 
class LeaveTypes extends Component
{
    use WithPagination;

    protected $tableList;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch = false;
    public $abbreviationAdvancedSearchField, $nameAdvancedSearchField,
           $descriptionAdvancedSearchField, $daysAdvancedSearchField,
           $unitAdvancedSearchField, $isWithPayAdvancedSearchField,
           $dateCreatedAdvancedSearchField = '';

    public $counter = 0;
    public $totalTableDataCount = 0;
    public $id, $abbreviation, $name, $description,
           $days, $unit, $is_with_pay;

    public $isUpdateMode = false;
    public $deleteId = '';

    public function openCreateUpdateModal(){
        $this->dispatch('openCreateUpdateModal');
    }

    private function resetInputFields(){
        $this->abbreviation = '';
        $this->name = '';
        $this->description = '';
        $this->days = '';
        $this->unit = '';
        $this->is_with_pay = '';
        artisanClear();
    }

    private function resetAdvancedSearchFields(){
        $this->abbreviationAdvancedSearchField = '';
        $this->nameAdvancedSearchField = '';
        $this->descriptionAdvancedSearchField = '';
        $this->daysAdvancedSearchField = '';
        $this->unitAdvancedSearchField = '';
        $this->isWithPayAdvancedSearchField = '';
        $this->dateCreatedAdvancedSearchField = '';
    }

    public function closeModal(){
        $this->isUpdateMode = false;
        $this->resetInputFields();
        $this->dispatch('closeModal');
    }

    public function store(){
        $this->validate([
            'abbreviation' => 'unique:lib_leave_types,abbreviation',
            'name' => 'required|unique:lib_leave_types,name|min:3|max:255',
            'days' => 'required|numeric',
            'unit' => 'required|min:3|max:255',
            'is_with_pay' => 'required',
        ]);

        $table = new LibLeaveType();
        $table->abbreviation = $this->abbreviation;
        $table->name = $this->name;
        $table->description = $this->description;
        $table->days = $this->days;
        $table->unit = $this->unit;
        $table->is_with_pay = $this->is_with_pay;
        if ($table->save()){
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($table, request()->ip(), 'Leave Types', 'Created');
            $this->js("showNotification('success', 'Leave Type data has been saved successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function edit($id){
        $this->isUpdateMode = true;
        $this->resetInputFields();
        $this->dispatch('openCreateUpdateModal');

        $table = LibLeaveType::find($id);
        $this->id = $id;
        $this->abbreviation = $table->abbreviation;
        $this->name = $table->name;
        $this->description = $table->description;
        $this->days = $table->days;
        $this->unit = $table->unit;
        $this->is_with_pay = $table->is_with_pay;
    }

    public function update(){
        $this->validate([
            'abbreviation' =>  [
                Rule::unique('lib_leave_types')
                    ->where('abbreviation', $this->abbreviation)
                    ->ignore($this->id)
            ],
            'name' =>  [
                'required',
                'min:3',
                'max:255',
                Rule::unique('lib_leave_types')
                    ->where('name', $this->name)
                    ->ignore($this->id)
            ],
            'days' => 'required|numeric',
            'unit' => 'required|min:3|max:255',
            'is_with_pay' => 'required',
        ]);

        $table = LibLeaveType::find($this->id);
        $table->abbreviation = $this->abbreviation;
        $table->name = $this->name;
        $table->description = $this->description;
        $table->days = $this->days;
        $table->unit = $this->unit;
        $table->is_with_pay = $this->is_with_pay;
        if ($table->update()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');

            doLog($table, request()->ip(), 'Leave Types', 'Updated');
            $this->js("showNotification('success', 'Your changes to the Leave Type have been successfully updated.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function toBeDeleted($id){
        $this->deleteId = $id;
        $this->dispatch('openDeletionModal');

        $table = LibLeaveType::find($this->deleteId);
        $this->abbreviation = $table->abbreviation;
        $this->name = $table->name;
        $this->description = $table->description;
        $this->days = number_format($table->days, 3);
        $this->unit = ucwords($table->unit);
        $this->is_with_pay = ucwords($table->is_with_pay);
    }

    public function delete(){
        $oldTable = LibLeaveType::find($this->deleteId);
        $table = LibLeaveType::find($this->deleteId);
        if ($table->delete()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($oldTable, request()->ip(), 'Leave Types', 'Deleted');
            $this->js("showNotification('success', 'The selected Leave Type has been deleted successfully.')");
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
        $this->tableList = LibLeaveType::select(
            '*',
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at")
        )
        ->where('abbreviation', 'like', '%'.trim($this->search).'%')
        ->orWhere('name', 'like', '%'.trim($this->search).'%')
        ->orWhere('description', 'like', '%'.trim($this->search).'%')
        ->orWhere('days', 'like', '%'.trim($this->search).'%')
        ->orWhere('unit', 'like', '%'.trim($this->search).'%')
        ->orWhere('is_with_pay', 'like', '%'.trim($this->search).'%')
        ->orWhere('created_at', 'like', '%'.trim($this->search).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function performAdvancedSearch(){
        if ($this->abbreviationAdvancedSearchField){
            $abbreviationCondition = function ($query) {
                $query->where('abbreviation', 'like', '%' . trim($this->abbreviationAdvancedSearchField) . '%');
            };
        } else {
            $abbreviationCondition = function ($query) {
                $query->where('abbreviation', 'like', '%' . trim($this->abbreviationAdvancedSearchField) . '%')
                    ->orWhereNull('abbreviation');
            };
        }

        if ($this->descriptionAdvancedSearchField){
            $descriptionCondition = function ($query) {
                $query->where('description', 'like', '%' . trim($this->descriptionAdvancedSearchField) . '%');
            };
        } else {
            $descriptionCondition = function ($query) {
                $query->where('description', 'like', '%' . trim($this->descriptionAdvancedSearchField) . '%')
                    ->orWhereNull('description');
            };
        }

        if ($this->unitAdvancedSearchField){
            $unitCondition = function ($query) {
                $query->where('unit', 'like', '%' . trim($this->unitAdvancedSearchField) . '%');
            };
        } else {
            $unitCondition = function ($query) {
                $query->where('unit', 'like', '%' . trim($this->unitAdvancedSearchField) . '%')
                    ->orWhereNull('unit');
            };
        }

        $this->tableList = LibLeaveType::select(
            '*',
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at")
        )
        ->where($abbreviationCondition)
        ->where('name', 'like', '%'.trim($this->nameAdvancedSearchField).'%')
        ->where($descriptionCondition)
        ->where('days', 'like', '%'.trim($this->daysAdvancedSearchField).'%')
        ->where($unitCondition)
        ->where('is_with_pay', 'like', '%'.trim($this->isWithPayAdvancedSearchField).'%')
        ->where('created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function totalTableDataCount(){
        $this->totalTableDataCount = LibLeaveType::get()->count();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }
        
        $this->totalTableDataCount();

        return view('livewire.database-libraries.leave-types', [
            'tableList' => $this->tableList,
        ]);
    }
}