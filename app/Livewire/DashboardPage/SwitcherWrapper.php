<?php

namespace App\Livewire\DashboardPage;

use App\Models\UserThemeSettings;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SwitcherWrapper extends Component
{
    public $listeners = [
        'refreshSwitcherWrapper' => '$refresh'
    ];

    public function themeStyles($class) {
        // Define a map of valid theme styles
        $validTheme = ['light-theme', 'dark-theme', 'semi-dark', 'minimal-theme'];
        // Ensure $class is a valid style, or set a default style
        $newTheme = in_array($class, $validTheme) ? $class : 'minimal-theme';
        
        // Update the user's theme style
        $table = UserThemeSettings::where('user_id', Auth::user()->id)->first();
        $table->theme_style = $newTheme;
        $table->header_color = null;
        $table->sidebar_color = null;
        $table->update();
        
        doLog($table, request()->ip(), 'Dashboard Page - Theme Customizer', 'Changed Theme Styles');
        $this->dispatch('refreshHeaderInfo');
        $this->dispatch('refreshUserLogsTable');
    }

    public function headerColors($class){
        $validColor = [
            'headercolor1', 'headercolor2', 'headercolor3', 'headercolor4',
            'headercolor5', 'headercolor6', 'headercolor7', 'headercolor8'
        ];
        $newColor = in_array($class, $validColor) ? $class : 'headercolor8';

        $table = UserThemeSettings::where('user_id', Auth::user()->id)->first();
        $table->header_color = 'color-header ' . $newColor;
        $table->update();
        
        doLog($table, request()->ip(), 'Dashboard Page - Theme Customizer', 'Changed Header Colors');
        $this->dispatch('refreshUserLogsTable');
    }

    public function sidebarColors($class){
        $validColor = [
            'sidebarcolor1', 'sidebarcolor2', 'sidebarcolor3', 'sidebarcolor4',
            'sidebarcolor5', 'sidebarcolor6', 'sidebarcolor7', 'sidebarcolor8'
        ];
        $newColor = in_array($class, $validColor) ? $class : 'sidebarcolor8';

        $table = UserThemeSettings::where('user_id', Auth::user()->id)->first();
        $table->theme_style = null;
        $table->header_color = null;
        $table->sidebar_color = 'color-sidebar ' . $newColor;
        $table->update();

        doLog($table, request()->ip(), 'Dashboard Page - Theme Customizer', 'Changed Sidebar Colors');
        $this->dispatch('refreshUserLogsTable');
    }
    
    public function render()
    {
        return view('livewire.dashboard-page.switcher-wrapper');
    }
}
