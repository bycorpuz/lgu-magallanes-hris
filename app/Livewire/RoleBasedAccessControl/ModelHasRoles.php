<?php

namespace App\Livewire\RoleBasedAccessControl;

use App\Models\ModelHasRole;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('RBAC - Model Has Roles')]
#[Layout('layouts.dashboard-app')] 
class ModelHasRoles extends Component
{
    use WithPagination;

    protected $tableList;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch = false;
    public $modelIdAdvancedSearchField, $roleIdAdvancedSearchField,
           $dateCreatedAdvancedSearchField = '';

    public $counter = 0;
    public $successCounter = 0;
    public $totalTableDataCount = 0;
    public $model_id = [];
    public $role_id = [];
    public $model_type = 'App\Models\User';

    public $isUpdateMode = false;

    public function openCreateUpdateModal(){
        $this->dispatch('openCreateUpdateModal');
    }

    private function resetInputFields(){
        $this->model_id = [];
        $this->role_id = [];
        $this->successCounter = 0;
        artisanClear();
    }

    private function resetAdvancedSearchFields(){
        $this->modelIdAdvancedSearchField = '';
        $this->roleIdAdvancedSearchField = '';
        $this->dateCreatedAdvancedSearchField = '';
    }

    public function closeModal(){
        $this->isUpdateMode = false;
        $this->resetInputFields();
        $this->dispatch('closeModal');
    }

    public function store(){
        foreach($this->model_id as $modelId){
            $table = new ModelHasRole();
            $table->model_id = $modelId;
            $table->role_id = $this->role_id;
            $table->model_type = $this->model_type;

            $query = ModelHasRole::where([
                ['model_id', $modelId],
                ['role_id', $this->role_id],
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
            
            doLog($table, request()->ip(), 'Model Has Roles', 'Created');
            $this->js("showNotification('success', 'Role to a User data has been saved successfully.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function edit($model_id, $role_id){
        $this->isUpdateMode = true;
        $this->resetInputFields();
        $this->dispatch('openCreateUpdateModal');

        $table = ModelHasRole::where([
            ['model_id', $model_id],
            ['role_id', $role_id],
        ])->first();
        $this->role_id = $table->role_id;
        $this->model_id = $table->model_id;
    }

    public function update(){
        // no action
    }

    public function toBeDeleted($model_id, $role_id){
        $this->dispatch('openDeletionModal');

        $table = ModelHasRole::where([
            ['model_id', $model_id],
            ['role_id', $role_id],
        ])->first();
        $this->model_id = $table->model_id;
        $this->role_id = $table->role_id;
    }

    public function delete(){
        $table = ModelHasRole::where([
            ['model_id', $this->model_id],
            ['role_id', $this->role_id],
        ]);
        
        if ($table->delete()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($table, request()->ip(), 'Model Has Roles', 'Deleted');
            $this->js("showNotification('success', 'The selected Role to a User has been deleted successfully.')");
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
        $this->tableList = ModelHasRole::from('model_has_roles as mhr')
        ->select(
            'mhr.*',
            DB::raw("DATE_FORMAT(mhr.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'r.name as r_name',
            'u.email as u_email',
            'upi.firstname as upi_firstname',
            'upi.lastname as upi_lastname'
        )
        ->leftJoin('roles as r', 'mhr.role_id', '=', 'r.id')
        ->leftJoin('users as u', 'mhr.model_id', '=', 'u.id')
        ->leftJoin('user_personal_informations as upi', 'mhr.model_id', '=', 'upi.user_id')
        ->where('r.name', 'like', '%'.trim($this->search).'%')
        ->orWhere('u.email', 'like', '%'.trim($this->search).'%')
        ->orWhere('upi.firstname', 'like', '%'.trim($this->search).'%')
        ->orWhere('upi.lastname', 'like', '%'.trim($this->search).'%')
        ->orWhere('mhr.created_at', 'like', '%'.trim($this->search).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function performAdvancedSearch(){
        $this->tableList = ModelHasRole::from('model_has_roles as mhr')
        ->select(
            'mhr.*',
            DB::raw("DATE_FORMAT(mhr.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'r.name as r_name',
            'u.email as u_email',
            'upi.firstname as upi_firstname',
            'upi.lastname as upi_lastname'
        )
        ->leftJoin('roles as r', 'mhr.role_id', '=', 'r.id')
        ->leftJoin('users as u', 'mhr.model_id', '=', 'u.id')
        ->leftJoin('user_personal_informations as upi', 'mhr.model_id', '=', 'upi.user_id')
        ->where('r.id', 'like', '%'.trim($this->roleIdAdvancedSearchField).'%')
        ->where('u.id', 'like', '%'.trim($this->modelIdAdvancedSearchField).'%')
        ->where('mhr.created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function totalTableDataCount(){
        $this->totalTableDataCount = ModelHasRole::get()->count();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }
        
        $this->totalTableDataCount();

        return view('livewire.role-based-access-control.model-has-roles', [
            'tableList' => $this->tableList,
        ]);
    }
}