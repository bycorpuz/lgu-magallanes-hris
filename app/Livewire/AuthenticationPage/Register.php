<?php

namespace App\Livewire\AuthenticationPage;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('Register')]
#[Layout('layouts.authentication-app')] 
class Register extends Component
{
    public $name = '';
    public $username = '';
    public $email = '';
    public $password = '';

    public function store(){
        $this->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|max:255'
        ]);

        $table = new User();
        $table->name = $this->name;
        $table->username = $this->username;
        $table->email = $this->email;
        $table->password = Hash::make($this->password);

        if ($table->save()){
            Auth::login($table);
            return $this->redirect('/my-profile');
        }
    }
    public function render()
    {
        return view('livewire.authentication-page.register');
    }
}
