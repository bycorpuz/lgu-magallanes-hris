<?php

namespace App\Livewire\DatabaseLibraries;

use App\Models\LibPosition;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Database Libraries - Positions')]
#[Layout('layouts.dashboard-app')] 
class Positions extends Component
{
    use WithPagination;

    protected $tableList;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch = false;
    public $codeAdvancedSearchField, $abbreviationAdvancedSearchField,
           $nameAdvancedSearchField, $dateCreatedAdvancedSearchField = '';

    public $counter = 0;
    public $totalTableDataCount = 0;
    public $id, $code, $abbreviation, $name;

    public $isUpdateMode = false;
    public $deleteId = '';

    public function openCreateUpdateModal(){
        $this->dispatch('openCreateUpdateModal');
    }

    private function resetInputFields(){
        $this->code = '';
        $this->abbreviation = '';
        $this->name = '';
        artisanClear();
    }

    private function resetAdvancedSearchFields(){
        $this->codeAdvancedSearchField = '';
        $this->abbreviationAdvancedSearchField = '';
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
            'code' => 'required|unique:lib_positions,code|min:3|max:10',
            'name' => 'required|unique:lib_positions,name|min:3|max:255',
        ]);

        $table = new LibPosition();
        $table->code = $this->code;
        $table->abbreviation = $this->abbreviation;
        $table->name = $this->name;
        if ($table->save()){
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($table, request()->ip(), 'Positions', 'Created');
            $this->js("showNotification('success', 'Position data has been saved successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function edit($id){
        $this->isUpdateMode = true;
        $this->resetInputFields();
        $this->dispatch('openCreateUpdateModal');

        $table = LibPosition::find($id);
        $this->id = $id;
        $this->code = $table->code;
        $this->abbreviation = $table->abbreviation;
        $this->name = $table->name;
    }

    public function update(){
        $this->validate([
            'code' =>  [
                'required',
                'min:3',
                'max:10',
                Rule::unique('lib_positions')
                    ->where('code', $this->code)
                    ->ignore($this->id)
            ],
            'name' =>  [
                'required',
                'min:3',
                'max:255',
                Rule::unique('lib_positions')
                    ->where('name', $this->name)
                    ->ignore($this->id)
            ],
        ]);

        $table = LibPosition::find($this->id);
        $table->code = $this->code;
        $table->abbreviation = $this->abbreviation;
        $table->name = $this->name;
        if ($table->update()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');

            doLog($table, request()->ip(), 'Positions', 'Updated');
            $this->js("showNotification('success', 'Your changes to the Position have been successfully updated.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function toBeDeleted($id){
        $this->deleteId = $id;
        $this->dispatch('openDeletionModal');

        $table = LibPosition::find($this->deleteId);
        $this->code = $table->code;
        $this->abbreviation = $table->abbreviation;
        $this->name = $table->name;
    }

    public function delete(){
        $oldTable = LibPosition::find($this->deleteId);
        $table = LibPosition::find($this->deleteId);
        if ($table->delete()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($oldTable, request()->ip(), 'Positions', 'Deleted');
            $this->js("showNotification('success', 'The selected Position has been deleted successfully.')");
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
        $this->tableList = LibPosition::select(
            '*',
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at")
        )
        ->where('code', 'like', '%'.trim($this->search).'%')
        ->orWhere('abbreviation', 'like', '%'.trim($this->search).'%')
        ->orWhere('name', 'like', '%'.trim($this->search).'%')
        ->orWhere('created_at', 'like', '%'.trim($this->search).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function performAdvancedSearch(){
        $this->tableList = LibPosition::select(
            '*',
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at")
        )
        ->where('code', 'like', '%'.trim($this->codeAdvancedSearchField).'%')
        ->where('abbreviation', 'like', '%'.trim($this->abbreviationAdvancedSearchField).'%')
        ->where('name', 'like', '%'.trim($this->nameAdvancedSearchField).'%')
        ->where('created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function totalTableDataCount(){
        $this->totalTableDataCount = LibPosition::get()->count();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }
        
        $this->totalTableDataCount();

        return view('livewire.database-libraries.positions', [
            'tableList' => $this->tableList,
        ]);
    }
}