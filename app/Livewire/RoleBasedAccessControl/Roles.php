<?php

namespace App\Livewire\RoleBasedAccessControl;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('RBAC - Roles')]
#[Layout('layouts.dashboard-app')] 
class Roles extends Component
{
    use WithPagination;

    protected $tableList;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch = false;
    public $nameAdvancedSearchField, $guardNameAdvancedSearchField,
           $dateCreatedAdvancedSearchField = '';

    public $counter = 0;
    public $totalTableDataCount = 0;
    public $id, $name;
    public $guard_name = 'web';

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
        $this->guardNameAdvancedSearchField = '';
        $this->dateCreatedAdvancedSearchField = '';
    }

    public function closeModal(){
        $this->isUpdateMode = false;
        $this->resetInputFields();
        $this->dispatch('closeModal');
    }

    public function store(){
        $this->validate([
            'name' => 'required|unique:roles,name'
        ]);

        $table = new Role();
        $table->name = $this->name;
        $table->guard_name = $this->guard_name;
        if ($table->save()){
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($table, request()->ip(), 'Roles', 'Created');
            $this->js("showNotification('success', 'Role data has been saved successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function edit($id){
        $this->isUpdateMode = true;
        $this->resetInputFields();
        $this->dispatch('openCreateUpdateModal');

        $table = Role::find($id);
        $this->id = $id;
        $this->name = $table->name;
    }

    public function update(){
        $this->validate([
            'name' =>  [
                'required',
                Rule::unique('roles')
                    ->where('name', $this->name)
                    ->ignore($this->id)
            ],
        ]);

        $table = Role::find($this->id);
        $table->name = $this->name;
        if ($table->update()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');

            doLog($table, request()->ip(), 'Roles', 'Updated');
            $this->js("showNotification('success', 'Your changes to the Role have been successfully updated.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function toBeDeleted($id){
        $this->deleteId = $id;
        $this->dispatch('openDeletionModal');

        $table = Role::find($this->deleteId);
        $this->name = $table->name;
    }

    public function delete(){
        $table = Role::find($this->deleteId);
        if ($table->delete()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($table, request()->ip(), 'Roles', 'Deleted');
            $this->js("showNotification('success', 'The selected Role has been deleted successfully.')");
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
        $this->tableList = Role::select(
            '*',
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at")
        )
        ->where('name', 'like', '%'.trim($this->search).'%')
        ->orWhere('guard_name', 'like', '%'.trim($this->search).'%')
        ->orWhere('created_at', 'like', '%'.trim($this->search).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function performAdvancedSearch(){
        $this->tableList = Role::select(
            '*',
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at")
        )
        ->where('name', 'like', '%'.trim($this->nameAdvancedSearchField).'%')
        ->where('guard_name', 'like', '%'.trim($this->guardNameAdvancedSearchField).'%')
        ->where('created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function totalTableDataCount(){
        $this->totalTableDataCount = Role::get()->count();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }
        
        $this->totalTableDataCount();

        return view('livewire.role-based-access-control.roles', [
            'tableList' => $this->tableList,
        ]);
    }
}