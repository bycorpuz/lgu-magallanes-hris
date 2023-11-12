<?php

use App\Models\GeneralSettings;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserThemeSettings;
use App\Models\UserLog;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

function artisanClear(){
    Artisan::call('optimize:clear');
}

if ( !function_exists('getSettings') ){
    function getSettings(){
        $results = null;
        $settings = new GeneralSettings();
        $settings_data = $settings->first();

        if($settings_data){
            $results = $settings_data;
        } else {
            $settings->id = Str::uuid();
            $settings->site_name = 'LGU Magallanes HRIS';
            $settings->site_email = 'your@email.com';
            $settings->save();

            $new_settings_data = $settings->first();
            $results = $new_settings_data;
        }
        return $results;
    }
}

if ( !function_exists('getUserThemeSettings') ){
    function getUserThemeSettings(){
        $results = null;
        $settings = new UserThemeSettings();
        $settings_data = $settings->where('user_id', Auth::user()->id)->first();

        if($settings_data){
            $results = $settings_data;
        } else {
            $settings->id = Str::uuid();
            $settings->user_id = Auth::user()->id;
            $settings->theme_style = 'light-theme';
            $settings->header_color = null;
            $settings->sidebar_color = null;
            $settings->save();

            $new_settings_data = $settings->first();
            $results = $new_settings_data;
        }
        return $results;
    }
}

if ( !function_exists('getUserThemeSettingsTrimmed') ){
    function getUserThemeSettingsTrimmed(){
	    $theme = getUserThemeSettings()->theme_style . ' ' . getUserThemeSettings()->header_color . ' ' . getUserThemeSettings()->sidebar_color;
        return trim($theme);
    }
}

if ( !function_exists('getUsers') ){
    function getUsers($param1){
        if ($param1){
            $table = User::from('users as u')
                ->select(
                    'u.*',
                    'u.email as u_email',
                    'upi.firstname as upi_firstname',
                    'upi.lastname as upi_lastname'
                )
                ->leftJoin('user_personal_informations as upi', 'u.id', '=', 'upi.user_id')
                ->where('u.id', $param1)
                ->first();
        } else {
            $table = User::from('users as u')
                ->select(
                    'u.*',
                    'u.email as u_email',
                    'upi.firstname as upi_firstname',
                    'upi.lastname as upi_lastname'
                )
                ->leftJoin('user_personal_informations as upi', 'u.id', '=', 'upi.user_id')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return $table;
    }
}

if ( !function_exists('getRoles') ){
    function getRoles($param1){
        if ($param1){
            $table = Role::find($param1);
        } else {
            $table = Role::orderBy('created_at', 'desc')->get();
        }

        return $table;
    }
}

if ( !function_exists('getPermissions') ){
    function getPermissions($param1){
        if ($param1){
            $table = Permission::find($param1);
        } else {
            $table = Permission::orderBy('created_at', 'desc')->get();
        }

        return $table;
    }
}

if ( !function_exists('doLog') ){
    function doLog($data, $clientIp, $module, $action){
        if ($data == 'Default'){
            $data = User::find(Auth::user()->id);
        }
    
        $combinedData = [
            'data' => $data,
            'ip' => $clientIp,
            'clientHostname' => gethostbyaddr($clientIp)
        ];
        $jsonData = json_encode($combinedData);
    
        $log = new UserLog();
        $log->user_id = Auth::user()->id;
        $log->module = $module;
        $log->action = $action;
        $log->data = $jsonData;
        $log->save();
    }
}
