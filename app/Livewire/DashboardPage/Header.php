<?php

namespace App\Livewire\DashboardPage;

use App\Models\UserThemeSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public $listeners = [
        'refreshHeaderInfo' => '$refresh'
    ];

    public function themeStyles($class) {
        $isDarkTheme = $class === 'dark-theme';
        $newTheme = !$isDarkTheme ? 'dark-theme' : 'light-theme';

        $table = UserThemeSettings::where('user_id', Auth::user()->id)->first();
        $table->theme_style = $newTheme;
        $table->header_color = null;
        $table->sidebar_color = null;
        $table->update();

        doLog($table, request()->ip(), 'Dashboard Page - Header', 'Changed Dark Mode Settings');
        $this->dispatch('refreshSwitcherWrapper');
        $this->dispatch('refreshUserLogsTable');
    }

    public function logoutHandler(Request $request){
        doLog('Default', request()->ip(), 'Dashboard Page - Header', 'Logged Out');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
    
    public function render()
    {
        return view('livewire.dashboard-page.header');
    }
}
