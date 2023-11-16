<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\UserPersonalInformation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Users')]
#[Layout('layouts.dashboard-app')] 
class Users extends Component
{
    use WithPagination;

    protected $tableList;
    public $perPage = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showAdvancedSearch = false;
    public $userIdAdvancedSearchField,
           $firstNameAdvancedSearchField, $middleNameAdvancedSearchField,
           $lastNameAdvancedSearchField, $extNameAdvancedSearchField,
           $emailAdvancedSearchField, $usernameAdvancedSearchField, $mobileNoAdvancedSearchField,
           $dateCreatedAdvancedSearchField = '';

    public $counter = 0;
    public $totalTableDataCount = 0;

    public $id, $username, $email = '';
    public $user_id, $firstname, $middlename, $lastname, $extname,
           $date_of_birth, $place_of_birth, $sex, $civil_status,
           $ra_house_no, $ra_street, $ra_subdivision, $ra_brgy_code, $ra_zip_code,
           $tel_no, $mobile_no = '';

    public $isUpdateMode = false;
    public $deleteId = '';

    public function openCreateUpdateModal(){
        $this->dispatch('openCreateUpdateModal');
    }

    private function resetInputFields(){
        $this->username = '';
        $this->email = '';
        $this->user_id = '';
        $this->firstname = '';
        $this->middlename = '';
        $this->lastname = '';
        $this->extname = '';
        $this->date_of_birth = '';
        $this->place_of_birth = '';
        $this->sex = '';
        $this->civil_status = '';
        $this->ra_house_no = '';
        $this->ra_street = '';
        $this->ra_subdivision = '';
        $this->ra_brgy_code = '';
        $this->ra_zip_code = '';
        $this->tel_no = '';
        $this->mobile_no = '';
        artisanClear();
    }

    private function resetAdvancedSearchFields(){
        $this->userIdAdvancedSearchField = '';
        $this->firstNameAdvancedSearchField = '';
        $this->middleNameAdvancedSearchField = '';
        $this->lastNameAdvancedSearchField = '';
        $this->extNameAdvancedSearchField = '';
        $this->emailAdvancedSearchField = '';
        $this->usernameAdvancedSearchField = '';
        $this->mobileNoAdvancedSearchField = '';
        $this->dateCreatedAdvancedSearchField = '';
    }

    public function closeModal(){
        $this->isUpdateMode = false;
        $this->resetInputFields();
        $this->dispatch('closeModal');
    }

    public function generateUsername(){
        $firstname = strtolower($this->firstname);
        $middlename = strtolower($this->middlename);
        $lastname = strtolower($this->lastname);

        $this->username = substr($firstname, 0, 1) . (empty($middlename) ? '' : substr($middlename, 0, 1)) . str_replace(' ', '', $lastname);
        $this->email = substr($firstname, 0, 1) . (empty($middlename) ? '' : substr($middlename, 0, 1)) . str_replace(' ', '', $lastname) . '@gmail.com';
    }

    public function store(){
        $this->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username|min:3|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:male,female,other',
            'civil_status' => 'required|in:single,married,divorced,separated,widowed,other',
        ]);

        $table = new User();
        $table->email = strtolower($this->email);
        $table->username = strtolower($this->username);
        $table->password = Hash::make('password');
        
        if ($table->save()) {
            $table2 = new UserPersonalInformation();
            $table2->user_id = $table->id;
            $table2->firstname = strtoupper($this->firstname);
            $table2->middlename = strtoupper($this->middlename);
            $table2->lastname = strtoupper($this->lastname);
            $table2->extname = $this->extname;
            $table2->date_of_birth = $this->date_of_birth;
            $table2->place_of_birth = strtoupper($this->place_of_birth);
            $table2->sex = $this->sex;
            $table2->civil_status = $this->civil_status;
            $table2->tel_no = $this->tel_no;
            $table2->mobile_no = $this->mobile_no;

            if ($table2->save()) {
                $this->resetInputFields();
                $this->dispatch('closeModal');

                doLog($table, request()->ip(), 'Users', 'Created');
                $this->js("showNotification('success', 'User data has been saved successfully.')");
            } else {
                $this->js("showNotification('error', 'Something went wrong on UserPersonalInformation Table.')");
            }
        } else {
            $this->js("showNotification('error', 'Something went wrong on User Table.')");
        }
    }

    public function edit($id){
        $this->isUpdateMode = true;
        $this->resetInputFields();
        $this->dispatch('openCreateUpdateModal');

        $table = User::find($id);
        $this->id = $table->id;
        $this->email = $table->email;
        $this->username = $table->username;

        $table2 = UserPersonalInformation::where('user_id', $this->id)->first();
        $this->firstname = $table2->firstname;
        $this->middlename = $table2->middlename;
        $this->lastname = $table2->lastname;
        $this->extname = $table2->extname;
        $this->date_of_birth = $table2->date_of_birth;
        $this->place_of_birth = $table2->place_of_birth;
        $this->sex = $table2->sex;
        $this->civil_status = $table2->civil_status;
        $this->tel_no = $table2->tel_no;
        $this->mobile_no = $table2->mobile_no;
    }

    public function update(){        
        $this->validate([
            'email' =>  [
                'required',
                'email',
                Rule::unique('users')
                    ->where('email', $this->email)
                    ->ignore($this->id)
            ],
            'username' =>  [
                'required',
                'min:3',
                'max:255',
                Rule::unique('users')
                    ->where('username', $this->username)
                    ->ignore($this->id)
            ],
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:male,female,other',
            'civil_status' => 'required|in:single,married,divorced,separated,widowed,other',
        ]);

        $table = User::find($this->id);
        $table->email = strtolower($this->email);
        $table->username = strtolower($this->username);
        $table->password = Hash::make('password');
        
        if ($table->update()) {
            $table2 = UserPersonalInformation::where('user_id', $this->id)->first();
            $table2->firstname = strtoupper($this->firstname);
            $table2->middlename = strtoupper($this->middlename);
            $table2->lastname = strtoupper($this->lastname);
            $table2->extname = $this->extname;
            $table2->date_of_birth = $this->date_of_birth;
            $table2->place_of_birth = strtoupper($this->place_of_birth);
            $table2->sex = $this->sex;
            $table2->civil_status = $this->civil_status;
            $table2->tel_no = $this->tel_no;
            $table2->mobile_no = $this->mobile_no;

            if ($table2->update()) {
                $this->resetInputFields();
                $this->dispatch('closeModal');

                doLog($table, request()->ip(), 'Users', 'Updated');
                $this->js("showNotification('success', 'User data has been updated successfully.')");
            } else {
                $this->js("showNotification('error', 'Something went wrong on UserPersonalInformation Table.')");
            }
        } else {
            $this->js("showNotification('error', 'Something went wrong on User Table.')");
        }
    }

    public function toBeDeleted($id){
        $this->deleteId = $id;
        $this->dispatch('openDeletionModal');

        $table = User::find($id);
        $this->id = $table->id;
        $this->email = $table->email;
        $this->username = $table->username;

        $table2 = UserPersonalInformation::where('user_id', $this->id)->first();
        $this->firstname = $table2->firstname;
        $this->middlename = $table2->middlename;
        $this->lastname = $table2->lastname;
        $this->extname = $table2->extname;
        $this->date_of_birth = $table2->date_of_birth;
        $this->place_of_birth = $table2->place_of_birth;
        $this->sex = ucwords($table2->sex);
        $this->civil_status = ucwords($table2->civil_status);
        $this->tel_no = $table2->tel_no;
        $this->mobile_no = $table2->mobile_no;
    }

    public function delete(){
        $oldTable = User::from('users as u')
            ->select(
                'u.id',
                'u.username',
                'u.email',
                'u.created_at',
                'upi.*'
            )
            ->leftJoin('user_personal_informations as upi', 'u.id', '=', 'upi.user_id')
            ->where('u.id', $this->deleteId)
            ->first();

        $table = User::find($this->deleteId);
        if ($table->delete()){
            $this->isUpdateMode = false;
            $this->resetInputFields();
            $this->dispatch('closeModal');
            
            doLog($oldTable, request()->ip(), 'Users', 'Deleted');
            $this->js("showNotification('success', 'The selected User has been deleted successfully.')");
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
        $this->tableList = User::from('users as u')
        ->select(
            'u.id',
            'u.username',
            'u.email',
            'u.created_at',
            DB::raw("DATE_FORMAT(u.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'upi.firstname',
            'upi.middlename',
            'upi.lastname',
            'upi.extname',
            'upi.mobile_no'
        )
        ->leftJoin('user_personal_informations as upi', 'u.id', '=', 'upi.user_id')
        ->where('u.username', 'like', '%'.trim($this->search).'%')
        ->orWhere('upi.firstname', 'like', '%'.trim($this->search).'%')
        ->orWhere('upi.middlename', 'like', '%'.trim($this->search).'%')
        ->orWhere('upi.lastname', 'like', '%'.trim($this->search).'%')
        ->orWhere('upi.extname', 'like', '%'.trim($this->search).'%')
        ->orWhere('upi.mobile_no', 'like', '%'.trim($this->search).'%')
        ->orWhere('u.email', 'like', '%'.trim($this->search).'%')
        ->orWhere('u.created_at', 'like', '%'.trim($this->search).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        $this->resetPage();
    }

    public function performAdvancedSearch(){
        if ($this->middleNameAdvancedSearchField){
            $middleNameCondition = function ($query) {
                $query->where('upi.middlename', 'like', '%' . trim($this->middleNameAdvancedSearchField) . '%');
            };
        } else {
            $middleNameCondition = function ($query) {
                $query->where('upi.middlename', 'like', '%' . trim($this->middleNameAdvancedSearchField) . '%')
                    ->orWhereNull('upi.middlename');
            };
        }

        if ($this->extNameAdvancedSearchField){
            $extNameCondition = function ($query) {
                $query->where('upi.extname', 'like', '%' . trim($this->extNameAdvancedSearchField) . '%');
            };
        } else {
            $extNameCondition = function ($query) {
                $query->where('upi.extname', 'like', '%' . trim($this->extNameAdvancedSearchField) . '%')
                    ->orWhereNull('upi.extname');
            };
        }

        if ($this->mobileNoAdvancedSearchField){
            $mobileNoCondition = function ($query) {
                $query->where('upi.mobile_no', 'like', '%' . trim($this->mobileNoAdvancedSearchField) . '%');
            };
        } else {
            $mobileNoCondition = function ($query) {
                $query->where('upi.mobile_no', 'like', '%' . trim($this->mobileNoAdvancedSearchField) . '%')
                    ->orWhereNull('upi.mobile_no');
            };
        }

        $this->tableList = User::from('users as u')
        ->select(
            'u.id',
            'u.username',
            'u.email',
            'u.created_at',
            DB::raw("DATE_FORMAT(u.created_at, '%Y-%m-%d %h:%i %p') as formatted_created_at"),
            'upi.firstname',
            'upi.middlename',
            'upi.lastname',
            'upi.extname',
            'upi.mobile_no'
        )
        ->leftJoin('user_personal_informations as upi', 'u.id', '=', 'upi.user_id')
        ->where('u.id', 'like', '%'.trim($this->userIdAdvancedSearchField).'%')
        ->where('u.username', 'like', '%'.trim($this->usernameAdvancedSearchField).'%')
        ->where('u.email', 'like', '%'.trim($this->emailAdvancedSearchField).'%')
        ->where('upi.firstname', 'like', '%'.trim($this->firstNameAdvancedSearchField).'%')
        ->where($middleNameCondition)
        ->where('upi.lastname', 'like', '%'.trim($this->lastNameAdvancedSearchField).'%')
        ->where($extNameCondition)
        ->where($mobileNoCondition)
        ->where('u.created_at', 'like', '%'.trim($this->dateCreatedAdvancedSearchField).'%')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);
    
        $this->resetPage();
    }

    public function totalTableDataCount(){
        $this->totalTableDataCount = User::get()->count();
    }

    public function render(){
        if ($this->search){
            $this->performGlobalSearch();
        } else {
            $this->performAdvancedSearch();
        }
        
        $this->totalTableDataCount();

        return view('livewire.user.users', [
            'tableList' => $this->tableList,
        ]);
    }
}