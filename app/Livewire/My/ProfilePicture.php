<?php

namespace App\Livewire\My;

use App\Models\User;
use App\Models\UserPersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class ProfilePicture extends Component
{
    public $listeners = [
        'refreshProfilePictureInfo' => '$refresh'
    ];

    public $user;

    public function mount(){
        $this->user = User::find(Auth::user()->id);
    }

    public function changeProfilePicture(Request $request){
        $path = 'images/users/';
        $table = UserPersonalInformation::where('user_id', Auth::user()->id)->first();
        $old_picture = $table->picture;
        $old_file_path_picture = $path . $old_picture;
        $new_filename = $table->user_id . '@' . uniqid() . '.jpg';

        $file = $request->file('userProfilePictureFile');
        $upload = $file->move(public_path($path), $new_filename);
        if ($upload){
            if ( $old_picture != 'default-avatar.png' && File::exists(public_path($old_file_path_picture)) ){
                File::delete(public_path($old_file_path_picture));
            }

            $table->picture = $new_filename;
            if ($table->update()){
                doLog($table, request()->ip(), 'My Profile', 'Updated Profile Picture');
                return response()->json(['status' => 1, 'msg' => 'Profile Picture has been updated successfully.']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Something went wrong on updating the UserPersonalInformation table.']);
            }
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong on uploading the file.']);
        }
    }

    public function render()
    {
        return view('livewire.my.profile-picture');
    }
}
