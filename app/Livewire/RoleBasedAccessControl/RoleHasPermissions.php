<?php

namespace App\Livewire\RoleBasedAccessControl;

use App\Models\RoleHasPermission;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('RBAC - Role Has Permissions')]
#[Layout('layouts.dashboard-app')] 
class RoleHasPermissions extends Component
{
    use WithPagination;

    protected $tableList;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch = false;
    public $roleIdAdvancedSearchField, $permissionIdAdvancedSearchField,
           $dateCreatedAdvancedSearchField = '';

    public $counter = 0;
    public $successCounter = 0;
    public $totalTableDataCount = 0;
    public $role_id;
    public $permission_id = [];

    public $isUpdateMode = false;

    public function openCreateUpdateModal(){
        $this->dispatch('openCreateUpdateModal');
    }

    private function resetInputFields(){
        $this->role_id = '';
        $this->permission_id = [];
        $this->successCounter = 0;
        artisanClear();
    }

    private function resetAdvancedSearchFields(){
        $this->roleIdAdvancedSearchField = '';
        $this->permissionIdAdvancedSearchField = '';
        $this->dateCreatedAdvancedSearchField = '';
    }

    public function closeModal(){
        $this->isUpdateMode = false;
        $this->resetInputFields();
        $this->dispatch('closeModal');
    }

    public function store(){
        foreach($this->permission_id as $permissionId){
            $table = new RoleHasPermission();
            $table->role_id = $this->role_id;
            $table->permission_id = $permissionId;

            $query = RoleHasPermission::where([
                ['role_id', $this->role_id],
                ['permission_id', $permissionId],
            ])->first();
            if (!$query) {
                if ($table->save()){
                    $this->successCounter ++;
                }
            }
        }

        if ($this->successCounter > 0){
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($table, request()->ip(), 'Role Has Permissions', 'Created');
            $this->js("showNotification('success', 'Permission to a Role data has been saved successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function edit($role_id, $permission_id){
        $this->isUpdateMode = true;
        $this->resetInputFields();
        $this->dispatch('openCreateUpdateModal');

        $table = RoleHasPermission::where([
            ['role_id', $role_id],
            ['permission_id', $permission_id],
        ])->first();
        $this->permission_id = $table->permission_id;
        $this->role_id = $table->role_id;
    }

    public function update(){
        // no action
    }

    public function toBeDeleted($role_id, $permission_id){
        $this->dispatch('openDeletionModal');

        $table = RoleHasPermission::where([
            ['role_id', $role_id],
            ['permission_id', $permission_id],
        ])->first();
        $this->role_id = $table->role_id;
        $this->permission_id = $table->permission_id;
    }

    public function delete(){
        $oldTable = RoleHasPermission::where([
            ['role_id', $this->role_id],
            ['permission_id', $this->permission_id],
        ]);
        $table = RoleHasPermission::where([
            ['role_id', $this->role_id],
            ['permission_id', $this->permission_id],
        ]);
        
        if ($table->delete()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($oldTable, request()->ip(), 'Role Has Permissions', 'Deleted');
            $this->js("showNotification('success', 'The selected Permission to a Role has been deleted successfully.')");
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
        $this->tableList = RoleHasPermission::from('role_has_permissions as rhp')
        ->select(
            'rhp.*',
            DB::raw("DATE_FORMAT(rhp.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'r.name as r_name',
            'p.name as p_name'
        )
        ->leftJoin('permissions as p', 'rhp.permission_id', '=', 'p.id')
        ->leftJoin('roles as r', 'rhp.role_id', '=', 'r.id')
        ->where('r.name', 'like', '%'.trim($this->search).'%')
        ->orWhere('p.name', 'like', '%'.trim($this->search).'%')
        ->orWhere('rhp.created_at', 'like', '%'.trim($this->search).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function performAdvancedSearch(){
        $this->tableList = RoleHasPermission::from('role_has_permissions as rhp')
        ->select(
            'rhp.*',
            DB::raw("DATE_FORMAT(rhp.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'r.name as r_name',
            'p.name as p_name'
        )
        ->leftJoin('permissions as p', 'rhp.permission_id', '=', 'p.id')
        ->leftJoin('roles as r', 'rhp.role_id', '=', 'r.id')
        ->where('r.id', 'like', '%'.trim($this->roleIdAdvancedSearchField).'%')
        ->where('p.id', 'like', '%'.trim($this->permissionIdAdvancedSearchField).'%')
        ->where('rhp.created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function totalTableDataCount(){
        $this->totalTableDataCount = RoleHasPermission::get()->count();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }
        
        $this->totalTableDataCount();

        return view('livewire.role-based-access-control.role-has-permissions', [
            'tableList' => $this->tableList,
        ]);
    }
}