<?php

namespace App\Livewire\DatabaseLibraries;

use App\Models\LibDesignation;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Database Libraries - Designations')]
#[Layout('layouts.dashboard-app')] 
class Designations extends Component
{
    use WithPagination;

    protected $tableList;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch = false;
    public $nameAdvancedSearchField, $dateCreatedAdvancedSearchField = '';

    public $counter = 0;
    public $totalTableDataCount = 0;
    public $id, $name;

    public $isUpdateMode = false;
    public $deleteId = '';

    public function openCreateUpdateModal(){
        $this->dispatch('openCreateUpdateModal');
    }

    private function resetInputFields(){
        $this->name = '';
        artisanClear();
    }

    private function resetAdvancedSearchFields(){
        $this->nameAdvancedSearchField = '';
        $this->dateCreatedAdvancedSearchField = '';
    }

    public function closeModal(){
        $this->isUpdateMode = false;
        $this->resetInputFields();
        $this->dispatch('closeModal');
    }

    public function store(){
        $this->validate([
            'name' => 'required|unique:lib_designations,name|min:3|max:255',
        ]);

        $table = new LibDesignation();
        $table->name = $this->name;
        if ($table->save()){
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($table, request()->ip(), 'Designations', 'Created');
            $this->js("showNotification('success', 'Designation data has been saved successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function edit($id){
        $this->isUpdateMode = true;
        $this->resetInputFields();
        $this->dispatch('openCreateUpdateModal');

        $table = LibDesignation::find($id);
        $this->id = $id;
        $this->name = $table->name;
    }

    public function update(){
        $this->validate([
            'name' =>  [
                'required',
                'min:3',
                'max:255',
                Rule::unique('lib_designations')
                    ->where('name', $this->name)
                    ->ignore($this->id)
            ],
        ]);

        $table = LibDesignation::find($this->id);
        $table->name = $this->name;
        if ($table->update()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');

            doLog($table, request()->ip(), 'Designations', 'Updated');
            $this->js("showNotification('success', 'Your changes to the Designation have been successfully updated.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function toBeDeleted($id){
        $this->deleteId = $id;
        $this->dispatch('openDeletionModal');

        $table = LibDesignation::find($this->deleteId);
        $this->name = $table->name;
    }

    public function delete(){
        $oldTable = LibDesignation::find($this->deleteId);
        $table = LibDesignation::find($this->deleteId);
        if ($table->delete()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($oldTable, request()->ip(), 'Designations', 'Deleted');
            $this->js("showNotification('success', 'The selected Designation has been deleted successfully.')");
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
        $this->tableList = LibDesignation::select(
            '*',
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at")
        )
        ->where('name', 'like', '%'.trim($this->search).'%')
        ->orWhere('created_at', 'like', '%'.trim($this->search).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function performAdvancedSearch(){
        $this->tableList = LibDesignation::select(
            '*',
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at")
        )
        ->where('name', 'like', '%'.trim($this->nameAdvancedSearchField).'%')
        ->where('created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function totalTableDataCount(){
        $this->totalTableDataCount = LibDesignation::get()->count();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }
        
        $this->totalTableDataCount();

        return view('livewire.database-libraries.designations', [
            'tableList' => $this->tableList,
        ]);
    }
}