<?php

namespace App\Livewire\RoleBasedAccessControl;

use App\Models\ModelHasPermission;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('RBAC - Model Has Permissions')]
#[Layout('layouts.dashboard-app')] 
class ModelHasPermissions extends Component
{
    use WithPagination;

    protected $tableList;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch = false;
    public $modelIdAdvancedSearchField, $permissionIdAdvancedSearchField,
           $dateCreatedAdvancedSearchField = '';

    public $counter = 0;
    public $successCounter = 0;
    public $totalTableDataCount = 0;
    public $model_id = [];
    public $permission_id = [];
    public $model_type = 'App\Models\User';

    public $isUpdateMode = false;

    public function openCreateUpdateModal(){
        $this->dispatch('openCreateUpdateModal');
    }

    private function resetInputFields(){
        $this->model_id = [];
        $this->permission_id = [];
        $this->successCounter = 0;
        artisanClear();
        $this->dispatch('refreshSidebarWrapper');
    }

    private function resetAdvancedSearchFields(){
        $this->modelIdAdvancedSearchField = '';
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
            foreach($this->model_id as $modelId){
                $table = new ModelHasPermission();
                $table->model_id = $modelId;
                $table->permission_id = $permissionId;
                $table->model_type = $this->model_type;

                $query = ModelHasPermission::where([
                    ['model_id', $modelId],
                    ['permission_id', $permissionId],
                ])->first();
                if (!$query) {
                    if ($table->save()){
                        $this->successCounter ++;
                    }
                }
            }
        }

        if ($this->successCounter > 0){
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($table, request()->ip(), 'Model Has Permissions', 'Created');
            $this->js("showNotification('success', 'Permission to a User data has been saved successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function edit($model_id, $permission_id){
        $this->isUpdateMode = true;
        $this->resetInputFields();
        $this->dispatch('openCreateUpdateModal');

        $table = ModelHasPermission::where([
            ['model_id', $model_id],
            ['permission_id', $permission_id],
        ])->first();
        $this->permission_id = $table->permission_id;
        $this->model_id = $table->model_id;
    }

    public function update(){
        // no action
    }

    public function toBeDeleted($model_id, $permission_id){
        $this->dispatch('openDeletionModal');

        $table = ModelHasPermission::where([
            ['model_id', $model_id],
            ['permission_id', $permission_id],
        ])->first();
        $this->model_id = $table->model_id;
        $this->permission_id = $table->permission_id;
    }

    public function delete(){
        $table = ModelHasPermission::where([
            ['model_id', $this->model_id],
            ['permission_id', $this->permission_id],
        ]);
        
        if ($table->delete()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($table, request()->ip(), 'Model Has Permissions', 'Deleted');
            $this->js("showNotification('success', 'The selected Permission to a User has been deleted successfully.')");
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
        $this->tableList = ModelHasPermission::from('model_has_permissions as mhp')
        ->select(
            'mhp.*',
            DB::raw("DATE_FORMAT(mhp.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'p.name as p_name',
            'u.email as u_email',
            'upi.firstname as upi_firstname',
            'upi.lastname as upi_lastname'
        )
        ->leftJoin('permissions as p', 'mhp.permission_id', '=', 'p.id')
        ->leftJoin('users as u', 'mhp.model_id', '=', 'u.id')
        ->leftJoin('user_personal_informations as upi', 'mhp.model_id', '=', 'upi.user_id')
        ->where('p.name', 'like', '%'.trim($this->search).'%')
        ->orWhere('u.email', 'like', '%'.trim($this->search).'%')
        ->orWhere('upi.firstname', 'like', '%'.trim($this->search).'%')
        ->orWhere('upi.lastname', 'like', '%'.trim($this->search).'%')
        ->orWhere('mhp.created_at', 'like', '%'.trim($this->search).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function performAdvancedSearch(){
        $this->tableList = ModelHasPermission::from('model_has_permissions as mhp')
        ->select(
            'mhp.*',
            DB::raw("DATE_FORMAT(mhp.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'p.name as p_name',
            'u.email as u_email',
            'upi.firstname as upi_firstname',
            'upi.lastname as upi_lastname'
        )
        ->leftJoin('permissions as p', 'mhp.permission_id', '=', 'p.id')
        ->leftJoin('users as u', 'mhp.model_id', '=', 'u.id')
        ->leftJoin('user_personal_informations as upi', 'mhp.model_id', '=', 'upi.user_id')
        ->where('p.id', 'like', '%'.trim($this->permissionIdAdvancedSearchField).'%')
        ->where('u.id', 'like', '%'.trim($this->modelIdAdvancedSearchField).'%')
        ->where('mhp.created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function totalTableDataCount(){
        $this->totalTableDataCount = ModelHasPermission::get()->count();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }
        
        $this->totalTableDataCount();

        return view('livewire.role-based-access-control.model-has-permissions', [
            'tableList' => $this->tableList,
        ]);
    }
}