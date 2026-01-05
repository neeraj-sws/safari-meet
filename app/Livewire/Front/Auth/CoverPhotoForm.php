<?php

namespace App\Livewire\Front\Auth;

use App\Helpers\ImageHelper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CoverPhotoForm extends Component
{
    use WithFileUploads;

    public $coverImage, $user;

    public function mount()
    {
        $this->user = User::find(Auth::guard('web')->user()->id);
    }

    public function render()
    {
        return view('livewire.front.auth.cover-photo-form');
    }

    // public function updatedProfilePhoto()
    // {
    //     $this->validate([
    //         'profile_photo' => 'image|max:2048',
    //     ]);

    //     $image = $this->profile_photo;
    //     $path = 'uploads/front/users/';
    //     $origPath = $image->store($path, 'public_root');
    //     $avifPath = '';
    //     $avifPath = ImageHelper::convertToAvif($origPath, $path);
    //     $this->user->profile_photo_path = $avifPath;
    //     $this->user->save();
    //     $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Profile photo updated!']);
    // }

    // public function saveCoverImage()
    // {
    //     $this->validate([
    //         'coverImage' => 'image|max:2048',
    //     ]);

    //     $image = $this->coverImage;
    //     $path = 'uploads/front/users/coverimage/';
    //     $origPath = $image->store($path, 'public_root');
    //     $avifPath = '';
    //     $avifPath = ImageHelper::convertToAvif($origPath, $path);
    //     $this->user->coverImage = $avifPath;
    //     $this->user->save();
    //     $this->coverImage = '';
    //     $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Profile photo updated!']);
    //     return $this->redirectRoute('profile-edit');
    // }
}
