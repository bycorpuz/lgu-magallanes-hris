<?php

namespace App\Livewire\AuthenticationPage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('Login')]
#[Layout('layouts.authentication-app')] 
class Login extends Component
{
    public $email;
    public $password;

    public function loginHandler(Request $request){
        $credentials = $this->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:255'
        ]);

        if (Auth::attempt($credentials)) {
            doLog('Default', request()->ip(), 'Login Form', 'Logged In');
            $this->js("showNotification('success', 'Redirecting to Dashboard...')");

            $request->session()->regenerate();
            return $this->redirect('/dashboard');
        } else {
            $this->addError('email', 'The password provided does not match the email entered.');
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function render()
    {
        return view('livewire.authentication-page.login');
    }
}
