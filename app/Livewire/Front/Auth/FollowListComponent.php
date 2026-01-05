<?php

namespace App\Livewire\Front\Auth;

use Livewire\Component;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowListComponent extends Component
{
    public $type; // follower or following
    public $userId, $view, $activeStatus = "following", $followinglists, $followerlists;

    public function mount($type, $view = "desktop", $userId)
    {

        $this->type = $type;
        $this->view = $view;
        $this->userId = $userId;
        $this->LoadFollowList();
    }



    public function render()
    {
        return view('livewire.front.auth.follow-list-component');
    }

    public function LoadFollowList()
    {
        $this->followinglists =  Auth::guard('web')->user()->userFollowings()->with('following')->get();
        $this->followerlists = Auth::guard('web')->user()->userFollowers()->with('follower')->get();
    }

    public function followtoggle($follow)
    {
        $this->activeStatus = $follow;
        $this->LoadFollowList();
    }

    public function followToggleStatus($followId)
    {

        $follow = Follow::where('id', $followId)->first();

        if ($follow) {
            $follow->delete();
            $this->LoadFollowList();
            $this->dispatch('follow-count-update');
            return  $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Unfollowed successfully!']);
        }
        return  $this->dispatch('swal:toast', ['type' => 'error', 'title' => '', 'message' => 'Data not found!']);
    }

    public function userInitials($name)
    {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $w) {
            $initials .= strtoupper(substr($w, 0, 1));
        }
        return $initials;
    }
}
