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
            'firstname' => 'User',
            'lastname' => 'User'
        ]);

        // You can associate this user with hr_leave_credits_available here
        $leaveTypeIds = [
            '1a46126a-e1ec-4597-9a8e-053ef7b748f4', // SL
            'e8bfe149-808c-4c72-b52d-1f373bedd548', // VL
            '2e3fa1d1-aeb5-4693-a097-842b7951281a', // SPL
        ];
        
        foreach ($leaveTypeIds as $leaveTypeId) {
            // Check if the record exists, and update if it does, or create a new one if it doesn't
            $user->userHrLeaveCreditsAvailable()
                ->create(
                    [
                        'leave_type_id' => $leaveTypeId,
                        'available' => '0.00',
                        'used' => '0.00',
                        'balance' => '0.00'
                    ]
                );
        }
    }
}
