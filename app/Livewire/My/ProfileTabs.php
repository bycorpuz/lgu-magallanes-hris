<?php

namespace App\Livewire\My;

use App\Models\User;
use App\Models\UserPersonalInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ProfileTabs extends Component
{
    public $tab = null;
    public $defaultTabName = 'personal_details';
    protected $queryString = ["tab"];
    
    public $user_id, $email, $username;

    public $firstname, $middlename, $lastname, $extname, $other_ext,
           $date_of_birth, $place_of_birth, $sex, $civil_status,
           $ra_house_no, $ra_street, $ra_subdivision, $ra_brgy_code, $ra_zip_code,
           $tel_no, $mobile_no, $picture = '';

    public $current_password, $new_password, $new_password_confirmation;

    public function selectTab($tab){
        $this->tab = $tab;
    }

    public function mount(){
        $this->tab = request()->tab ? request()->tab : $this->defaultTabName;

        $table = User::find(Auth::user()->id);
        $this->user_id = $table->id;
        $this->email = $table->email;
        $this->username = $table->username;

        $this->firstname = $table->userPersonalInformations->firstname;
        $this->middlename = $table->userPersonalInformations->middlename;
        $this->lastname = $table->userPersonalInformations->lastname;
        $this->extname = $table->userPersonalInformations->extname;
        $this->other_ext = $table->userPersonalInformations->other_ext;
        $this->date_of_birth = $table->userPersonalInformations->date_of_birth;
        $this->place_of_birth = $table->userPersonalInformations->place_of_birth;
        $this->sex = $table->userPersonalInformations->sex;
        $this->civil_status = $table->userPersonalInformations->civil_status;
        $this->tel_no = $table->userPersonalInformations->tel_no;
        $this->mobile_no = $table->userPersonalInformations->mobile_no;
    }

    public function updatePersonalDetails(){
        $this->validate([
            'email' =>  [
                'required',
                'email',
                Rule::unique('users')
                    ->where('email', $this->email)
                    ->ignore($this->user_id)
            ],
            'username' =>  [
                'required',
                'min:3',
                'max:255',
                Rule::unique('users')
                    ->where('username', $this->username)
                    ->ignore($this->user_id)
            ],
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:Male,Female,Other',
            'civil_status' => 'required|in:Single,Married,Divorced,Separated,Widowed,Other',
        ]);

        DB::beginTransaction();
        try {
            $table = User::find($this->user_id);
            $table->email = strtolower($this->email);
            $table->username = strtolower($this->username);
            
            if ($table->update()) {
                $table2 = UserPersonalInformation::where('user_id', $this->user_id)->first();
                $table2->firstname = strtoupper($this->firstname);
                $table2->middlename = strtoupper($this->middlename);
                $table2->lastname = strtoupper($this->lastname);
                $table2->extname = $this->extname;
                $table2->other_ext = $this->other_ext;
                $table2->date_of_birth = $this->date_of_birth;
                $table2->place_of_birth = strtoupper($this->place_of_birth);
                $table2->sex = $this->sex;
                $table2->civil_status = $this->civil_status;
                $table2->tel_no = $this->tel_no;
                $table2->mobile_no = $this->mobile_no;

                if ($table2->update()) {
                    DB::commit();
                    $this->dispatch('refreshHeaderInfo');
                    $this->dispatch('refreshProfilePictureInfo');

                    doLog($table, request()->ip(), 'My Profile', 'Updated Personal Details');
                    $this->js("showNotification('success', 'Personal Details data has been updated successfully.')");
                } else {
                    $this->js("showNotification('error', 'Something went wrong on UserPersonalInformation Table.')");
                }
            } else {
                $this->js("showNotification('error', 'Something went wrong on User Table.')");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->js("showNotification('error', 'Something went wrong.");
        }
    }

    public function updatePassword(){
        $this->validate([
            'current_password' => [
                'required', function($attribute, $value, $fail){
                    if ( !Hash::check($value, User::find($this->user_id)->password) ){
                        return $fail(__('The :attribute is incorrect.'));
                    }
                }
            ],
            'new_password' => 'required|min:5|max:45|confirmed'
        ]);

        $table = User::find($this->user_id);
        $table->password = Hash::make($this->new_password);
        if ($table->update()){
                $this->current_password = $this->new_password = $this->new_password_confirmation = null;
                doLog($table, request()->ip(), 'My Profile', 'Updated Password');
                $this->js("showNotification('success', 'Password successfully changed.')");        
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function render(){
        return view('livewire.my.profile-tabs');
    }
}