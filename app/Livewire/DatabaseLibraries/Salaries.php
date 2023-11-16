<?php

namespace App\Livewire\DatabaseLibraries;

use App\Models\LibSalary;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Database Libraries - Salaries')]
#[Layout('layouts.dashboard-app')] 
class Salaries extends Component
{
    use WithPagination;

    protected $tableList;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch = false;
    public $trancheAdvancedSearchField, $gradeAdvancedSearchField,
           $stepAdvancedSearchField, $basicAdvancedSearchField,
           $dateCreatedAdvancedSearchField = '';

    public $counter = 0;
    public $totalTableDataCount = 0;
    public $id, $tranche, $grade, $step, $basic;

    public $isUpdateMode = false;
    public $deleteId = '';

    public function openCreateUpdateModal(){
        $this->dispatch('openCreateUpdateModal');
    }

    private function resetInputFields(){
        $this->tranche = '';
        $this->grade = '';
        $this->step = '';
        $this->basic = '';
        artisanClear();
    }

    private function resetAdvancedSearchFields(){
        $this->trancheAdvancedSearchField = '';
        $this->gradeAdvancedSearchField = '';
        $this->stepAdvancedSearchField = '';
        $this->basicAdvancedSearchField = '';
        $this->dateCreatedAdvancedSearchField = '';
    }

    public function closeModal(){
        $this->isUpdateMode = false;
        $this->resetInputFields();
        $this->dispatch('closeModal');
    }

    public function store(){
        $this->validate([
            'tranche' => 'required|integer',
            'grade' => 'required|integer',
            'step' =>  [
                'required',
                'integer',
                Rule::unique('lib_salaries')
                    ->where('tranche', $this->tranche)
                    ->where('step', $this->step)
            ],
            'basic' => 'required|numeric',
        ]);
        
        $table = new LibSalary();
        $table->tranche = $this->tranche;
        $table->grade = $this->grade;
        $table->step = $this->step;
        $table->basic = $this->basic;
        if ($table->save()){
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($table, request()->ip(), 'Salaries', 'Created');
            $this->js("showNotification('success', 'Salary data has been saved successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function edit($id){
        $this->isUpdateMode = true;
        $this->resetInputFields();
        $this->dispatch('openCreateUpdateModal');

        $table = LibSalary::find($id);
        $this->id = $id;
        $this->tranche = $table->tranche;
        $this->grade = $table->grade;
        $this->step = $table->step;
        $this->basic = $table->basic;
    }

    public function update(){
        $this->validate([
            'tranche' => 'required|integer',
            'grade' => 'required|integer',
            'step' =>  [
                'required',
                'integer',
                Rule::unique('lib_salaries')
                    ->where('tranche', $this->tranche)
                    ->where('step', $this->step)
                    ->ignore($this->id)
            ],
            'basic' => 'required|numeric',
        ]);

        $table = LibSalary::find($this->id);
        $table->tranche = $this->tranche;
        $table->grade = $this->grade;
        $table->step = $this->step;
        $table->basic = $this->basic;
        if ($table->update()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');

            doLog($table, request()->ip(), 'Salaries', 'Updated');
            $this->js("showNotification('success', 'Your changes to the Salary have been successfully updated.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function toBeDeleted($id){
        $this->deleteId = $id;
        $this->dispatch('openDeletionModal');

        $table = LibSalary::find($this->deleteId);
        $this->tranche = $table->tranche;
        $this->grade = $table->grade;
        $this->step = $table->step;
        $this->basic = number_format($table->basic, 2);
    }

    public function delete(){
        $oldTable = LibSalary::find($this->deleteId);
        $table = LibSalary::find($this->deleteId);
        if ($table->delete()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($oldTable, request()->ip(), 'Salaries', 'Deleted');
            $this->js("showNotification('success', 'The selected Salary has been deleted successfully.')");
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
        $this->tableList = LibSalary::select(
            '*',
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at")
        )
        ->where('tranche', 'like', '%'.trim($this->search).'%')
        ->orWhere('grade', 'like', '%'.trim($this->search).'%')
        ->orWhere('step', 'like', '%'.trim($this->search).'%')
        ->orWhere('basic', 'like', '%'.trim($this->search).'%')
        ->orWhere('created_at', 'like', '%'.trim($this->search).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function performAdvancedSearch(){
        $this->tableList = LibSalary::select(
            '*',
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at")
        )
        ->where('tranche', 'like', '%'.trim($this->trancheAdvancedSearchField).'%')
        ->where('grade', 'like', '%'.trim($this->gradeAdvancedSearchField).'%')
        ->where('step', 'like', '%'.trim($this->stepAdvancedSearchField).'%')
        ->where('basic', 'like', '%'.trim($this->basicAdvancedSearchField).'%')
        ->where('created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function totalTableDataCount(){
        $this->totalTableDataCount = LibSalary::get()->count();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }
        
        $this->totalTableDataCount();

        return view('livewire.database-libraries.salaries', [
            'tableList' => $this->tableList,
        ]);
    }
}