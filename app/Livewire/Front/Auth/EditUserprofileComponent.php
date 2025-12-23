<?php

namespace App\Livewire\Front\Auth;

use App\Helpers\ImageHelper;
use App\Models\{User, State, Country, City, JoinSharedSafari, ShareSafari};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.guest')]
class EditUserprofileComponent extends Component
{
    use WithFileUploads;

    public  $user, $profile_photo, $activeTab = 'information';

    public function mount()
    {
        $this->user = User::find(Auth::guard('web')->user()->id);
    }


    public function render()
    {
        return view('livewire.front.auth.edit-userprofile-component');
    }


    public function ChangeTabs($value)
    {
        if ($value == 'information') {
            $this->activeTab = 'information';
        } elseif ($value == 'cover-photo') {
            $this->activeTab = 'cover-photo';
        } elseif ($value == 'following') {
            $this->activeTab = 'following';
        } elseif ($value == 'follower') {
            $this->activeTab = 'follower';
        }
    }

    public function updatedProfilePhoto()
    {
        $this->validate([
            'profile_photo' => 'image|max:2048',
        ]);

        $image = $this->profile_photo;
        $path = 'uploads/front/users/profile';
        $origPath = $image->store($path, 'public_root');
        $avifPath = '';
        $avifPath = ImageHelper::convertToAvif($origPath, $path);
        $this->user->profile_photo_path = $avifPath;
        $this->user->save();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Profile photo updated!']);
    }
}
