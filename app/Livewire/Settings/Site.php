<?php

namespace App\Livewire\Settings;

use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Site Settings')]
#[Layout('layouts.dashboard-app')] 
class Site extends Component
{
    use WithFileUploads;

    public $tab = null;
    public $defaultTabName = 'general_settings';
    protected $queryString = ["tab"];

    public $site_name, $site_email, $site_phone, $site_meta_keywords, $site_meta_description, $site_logo, $site_favicon;
    public $facebook_url, $twitter_url, $youtube_url, $instagram_url;

    public function selectTab($tab){
        $this->tab = $tab;
    }

    public function mount(){
        $this->tab = request()->tab ? request()->tab : $this->defaultTabName;

        $this->site_name = getSiteSettings()->site_name;
        $this->site_email = getSiteSettings()->site_email;
        $this->site_phone = getSiteSettings()->site_phone;
        $this->site_meta_keywords = getSiteSettings()->site_meta_keywords;
        $this->site_meta_description = getSiteSettings()->site_meta_description;
        $this->site_logo = getSiteSettings()->site_logo;
        $this->site_favicon = getSiteSettings()->site_favicon;
        $this->facebook_url = getSiteSettings()->facebook_url;
        $this->twitter_url = getSiteSettings()->twitter_url;
        $this->youtube_url = getSiteSettings()->youtube_url;
        $this->instagram_url = getSiteSettings()->instagram_url;
    }

    public function updateGeneralSettings(){
        $this->validate([
            'site_name' => 'required',
            'site_email' => 'required|email'
        ]);

        $table = new GeneralSettings();
        $table = $table->first();
        $table->site_name = $this->site_name;
        $table->site_email = $this->site_email;
        $table->site_phone = $this->site_phone;
        $table->site_meta_keywords = $this->site_meta_keywords;
        $table->site_meta_description = $this->site_meta_description;
        if ($table->update()){
            $this->dispatch('refreshSidebarWrapperHeader');
            
            doLog($table, request()->ip(), 'Settings', 'Updated General Settings');
            $this->js("showNotification('success', 'Your changes to the General Settings have been successfully updated.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function updateSocialNetworks(){
        $table = new GeneralSettings();
        $table = $table->first();
        $table->facebook_url = $this->facebook_url;
        $table->twitter_url = $this->twitter_url;
        $table->youtube_url = $this->youtube_url;
        $table->instagram_url = $this->instagram_url;
        if ($table->update()){
            doLog($table, request()->ip(), 'Settings', 'Updated Social Networks');
            $this->js("showNotification('success', 'Your changes to the Social Networks have been successfully updated.')");
        } else {
            $this->js("showNotification('error', 'Something went wrong.')");
        }
    }

    public function changeLogo(Request $request){
        $path = 'images/site/';
        $table = GeneralSettings::first();
        $old_logo = $table->site_logo;
        $old_file_path_site_logo = $path . $old_logo;
        $new_filename = $table->id . '@' . uniqid() . '.png';

        $file = $request->file('site_logo_filename');
        $upload = $file->move(public_path($path), $new_filename);
        if ($upload){
            if ( File::exists(public_path($old_file_path_site_logo)) ){
                File::delete(public_path($old_file_path_site_logo));
            }

            $table->site_logo = $new_filename;
            if ($table->update()){
                doLog($table, request()->ip(), 'Settings', 'Updated Site Logo');
                $this->js("showNotification('success', 'Site Logo has been updated successfully.')");
            } else {
                $this->js("showNotification('error', 'Something went wrong on updating the GeneralSettings table.')");
            }
        } else {
            $this->js("showNotification('error', 'Something went wrong on uploading the file.')");
        }
    }

    public function render()
    {
        return view('livewire.settings.site');
    }
}