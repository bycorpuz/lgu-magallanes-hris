<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $commonPassword = Hash::make('password');

        // Create a new user
        $user = User::create([
            'username' => 'user',
            'email' => 'user@user.com',
            'password' => $commonPassword
        ]);

        // You can associate this user with user_theme_settings here
        $user->userThemeSettings()->create([
            'theme_style' => 'light-theme',
            'header_color' => null,
            'sidebar_color' => null,
        ]);
        
        // You can associate this user with user_personal_informations here
        $user->userPersonalInformations()->create([
            'firstname' => 'Bobby',
            'lastname' => 'Corpuz'
        ]);
    }
}
