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
    public $emailUsername;
    public $password;

    public function loginHandler(Request $request){
        $credentials = $this->validate([
            'emailUsername' => 'required|max:255',
            'password' => 'required|min:8|max:255',
        ]);

        $loginType = filter_var($credentials['emailUsername'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $attemptCredentials = [
            $loginType => $credentials['emailUsername'],
            'password' => $credentials['password'],
        ];

        if (Auth::attempt($attemptCredentials)) {
            doLog('Default', $request->ip(), 'Login Form', 'Logged In');
            $this->js("showNotification('success', 'Redirecting to your Profile...')");

            $request->session()->regenerate();
            return $this->redirect('/my-profile');
        } else {
            $this->addError('login', 'The password provided does not match the email or username entered.');
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }


    public function render()
    {
        return view('livewire.authentication-page.login');
    }
}
