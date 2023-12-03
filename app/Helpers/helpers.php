<?php

use App\Models\GeneralSettings;
use App\Models\LibDesignation;
use App\Models\LibLeaveType;
use App\Models\LibPosition;
use App\Models\LibSalary;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserThemeSettings;
use App\Models\UserLog;
use App\Models\UserPersonalInformation;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

function artisanClear(){
    Artisan::call('optimize:clear');
}

if ( !function_exists('getSiteSettings') ){
    function getSiteSettings(){
        $results = null;
        $settings = new GeneralSettings();
        $settings_data = $settings->first();

        if($settings_data){
            $results = $settings_data;
        } else {
            $settings->id = Str::uuid();
            $settings->site_name = 'Your Company HRIS';
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
                    'upi.lastname as upi_lastname',
                    'upi.picture as upi_picture'
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
                    'upi.lastname as upi_lastname',
                    'upi.picture as upi_picture'
                )
                ->leftJoin('user_personal_informations as upi', 'u.id', '=', 'upi.user_id')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return $table;
    }
}

if ( !function_exists('getUserFullName') ){
    function getUserFullName($user_id){
        if ($user_id){
            $query = UserPersonalInformation::where('user_id', $user_id)->first();

            if ($query){
                $firstname = $query->firstname;
                $middlename = $query->middlename;
                $lastname = $query->lastname;
                $extname = $query->extname;
                $other_ext = $query->other_ext;

                if (!empty($middlename)){
                    if ($middlename == 'N/A' || $middlename == 'n/a' || $middlename == 'NA'  || $middlename == 'na'){
                        if (!empty($extname) && !empty($other_ext)){
                            $fullname = $firstname . ' ' . $lastname . ', ' . $extname . ', ' . $other_ext;
                        } else if (!empty($extname) && empty($other_ext)){
                            $fullname = $firstname . ' ' . $lastname . ', ' . $extname;
                        } else if (empty($extname) && !empty($other_ext)){
                            $fullname = $firstname . ' ' . $lastname . ', ' . $other_ext;
                        } else {
                            $fullname = $firstname . ' ' . $lastname;
                        }
                    } else {
                        if (!empty($extname) && !empty($other_ext)){
                            $fullname = $firstname . ' ' . substr($middlename, 0, 1) . '. ' . $lastname . ', ' . $extname . ', ' . $other_ext;
                        } else if (!empty($extname) && empty($other_ext)){
                            $fullname = $firstname . ' ' . substr($middlename, 0, 1) . '. ' . $lastname . ', ' . $extname;
                        } else if (empty($extname) && !empty($other_ext)){
                            $fullname = $firstname . ' ' . substr($middlename, 0, 1) . '. ' . $lastname . ', ' . $other_ext;
                        } else {
                            $fullname = $firstname . ' ' . substr($middlename, 0, 1) . '. ' . $lastname;
                        }
                    }
                } else {
                    if (!empty($extname) && !empty($other_ext)){
                        $fullname = $firstname . ' ' . $lastname . ', ' . $extname . ', ' . $other_ext;
                    } else if (!empty($extname) && empty($other_ext)){
                        $fullname = $firstname . ' ' . $lastname . ', ' . $extname;
                    } else if (empty($extname) && !empty($other_ext)){
                        $fullname = $firstname . ' ' . $lastname . ', ' . $other_ext;
                    } else {
                        $fullname = $firstname . ' ' . $lastname;
                    }
                }
            } else {
                $fullname = '(not-set)';
            }
        } else {
            $fullname = '(not-set)';
        }

        return $fullname;
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

if ( !function_exists('getPositions') ){
    function getPositions($param1){
        if ($param1){
            $table = LibPosition::find($param1);
        } else {
            $table = LibPosition::orderBy('created_at', 'desc')->get();
        }

        return $table;
    }
}

if ( !function_exists('getSalaries') ){
    function getSalaries($param1){
        if ($param1){
            $table = LibSalary::find($param1);
        } else {
            $table = LibSalary::orderBy('created_at', 'desc')->get();
        }

        return $table;
    }
}

if ( !function_exists('getLeaveTypes') ){
    function getLeaveTypes($param1){
        if ($param1 == ''){
            $table = LibLeaveType::orderBy('created_at', 'asc')->get();
        } elseif ($param1 == 'for_form'){
            $table = LibLeaveType::where('for_form', 'Yes')->orderBy('created_at', 'asc')->get();
        } elseif ($param1 == 'others'){
            $table = LibLeaveType::where('for_form', 'No')->orderBy('created_at', 'asc')->get();
        } else {
            $table = LibLeaveType::find($param1);
        }

        return $table;
    }
}

if ( !function_exists('getDesignations') ){
    function getDesignations($param1){
        if ($param1){
            $table = LibDesignation::find($param1);
        } else {
            $table = LibDesignation::orderBy('created_at', 'desc')->get();
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