<?php

namespace App\Livewire\My;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    }

    public function updatePersonalDetails(){
        $this->validate([
            'email' => 'required|email|unique:users,email,'.$this->user_id,
            'username' => 'required|min:3|unique:users,username,'.$this->user_id,
        ]);

        $table = User::find($this->user_id);
        $table->email = $this->email;
        $table->username = $this->username;
        if ($table->update()){
            $this->dispatch('refreshHeaderInfo');
            $this->dispatch('refreshProfilePictureInfo');

            doLog($table, request()->ip(), 'My Profile', 'Updated Personal Details');
            $this->js("showNotification('success', 'Your changes to the Personal Details have been successfully updated.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
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