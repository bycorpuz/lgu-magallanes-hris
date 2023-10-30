<?php

namespace App\Livewire\User;

use App\Models\UserLog;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('User Logs')]
#[Layout('layouts.dashboard-app')] 
class Logs extends Component
{
    use WithPagination;
    
    public $listeners = [
        'refreshUserLogsTable' => '$refresh'
    ];

    protected $tableList;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch = false;
    public $userIdAdvancedSearchField, $moduleAdvancedSearchField,
           $actionAdvancedSearchField, $dataAdvancedSearchField,
           $dateCreatedAdvancedSearchField = '';

    public $counter = 0;
    public $id, $user_id, $module, $action, $data;

    private function resetAdvancedSearchFields(){
        $this->userIdAdvancedSearchField = '';
        $this->moduleAdvancedSearchField = '';
        $this->actionAdvancedSearchField = '';
        $this->dataAdvancedSearchField = '';
        $this->dateCreatedAdvancedSearchField = '';
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
        $this->tableList = UserLog::from('user_logs as ul')
        ->select(
            'ul.*',
            DB::raw("DATE_FORMAT(ul.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'u.username as u_username',
            'u.email as u_email',
            'upi.firstname as upi_firstname',
            'upi.lastname as upi_lastname'
        )
        ->leftJoin('users as u', 'ul.user_id', '=', 'u.id')
        ->leftJoin('user_personal_informations as upi', 'ul.user_id', '=', 'upi.user_id')
        ->where('upi.firstname', 'like', '%'.trim($this->search).'%')
        ->orWhere('upi.lastname', 'like', '%'.trim($this->search).'%')
        ->orWhere('u.username', 'like', '%'.trim($this->search).'%')
        ->orWhere('u.email', 'like', '%'.trim($this->search).'%')
        ->orWhere('ul.user_id', 'like', '%'.trim($this->search).'%')
        ->orWhere('ul.module', 'like', '%'.trim($this->search).'%')
        ->orWhere('ul.action', 'like', '%'.trim($this->search).'%')
        ->orWhere('ul.data', 'like', '%'.trim($this->search).'%')
        ->orWhere('ul.created_at', 'like', '%'.trim($this->search).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function performAdvancedSearch(){
        $this->tableList = UserLog::from('user_logs as ul')
        ->select(
            'ul.*',
            DB::raw("DATE_FORMAT(ul.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'u.username as u_username',
            'u.email as u_email',
            'upi.firstname as upi_firstname',
            'upi.lastname as upi_lastname'
        )
        ->leftJoin('users as u', 'ul.user_id', '=', 'u.id')
        ->leftJoin('user_personal_informations as upi', 'ul.user_id', '=', 'upi.user_id')
        ->where('ul.user_id', 'like', '%'.trim($this->userIdAdvancedSearchField).'%')
        ->where('ul.module', 'like', '%'.trim($this->moduleAdvancedSearchField).'%')
        ->where('ul.action', 'like', '%'.trim($this->actionAdvancedSearchField).'%')
        ->where('ul.data', 'like', '%'.trim($this->dataAdvancedSearchField).'%')
        ->where('ul.created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);
    
        $this->resetPage();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }

        return view('livewire.user.logs', [
            'tableList' => $this->tableList,
        ]);
    }
}
