<?php

namespace App\Livewire\Front\Profile;

use App\Helpers\ImageHelper;
use App\Models\JoinSharedSafari;
use App\Models\ShareSafari;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserAccountView extends Component
{
    use WithFileUploads;

    public  $profile_photo, $user, $followingList, $followerList, $followerCount, $followersCount, $SafariOrganized, $SafariJoined, $isProfileRoute = true;

    public function mount($isprofile = true)
    {
        $this->user = User::find(Auth::guard('web')->user()->id);
        $this->isProfileRoute =  $isprofile;
        $this->followListing();
    }

    public function render()
    {
        return view('livewire.front.profile.user-account-view');
    }

    #[On('follow-count-update')]
    public function followListing()
    {
        $this->followingList  = $this->user->userFollowings()->with('following')->get();
        $this->followerList  = $this->user->userFollowers()->with('follower')->get();
        $this->SafariOrganized = ShareSafari::where('organized_by', $this->user->id)
            ->where('organized_type', 'user')
            ->count();
        $this->SafariJoined  =  JoinSharedSafari::where('user_id', $this->user->id)->count();
    }
    
    #[On('profileUpdated')]
    public function profileupdated()
    {
        $this->user = User::find(Auth::guard('web')->user()->id);
        $this->followListing();
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
