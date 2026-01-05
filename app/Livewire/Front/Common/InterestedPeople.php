<?php

namespace App\Livewire\Front\Common;

use App\Helpers\UserHelper;
use App\Mail\DynamicMail;
use App\Models\Follow;
use App\Models\JoinSharedSafari;
use App\Models\SafariAllottedSeat;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class InterestedPeople extends Component
{
    public $userList = [], $followingList, $followerList, $userType = 'user', $showEmail = true;

    public function mount($userList, $usertype = null, $showEmail = true)
    {
        $this->userList = $userList;
        $this->userType = $usertype ?? 'user';
        $this->showEmail = $showEmail;
        if ($this->userType  == 'user') {
            $this->hydrate();
        }
    }

    public function hydrate()
    {
        if (get_class($this->userList) == 'App\Models\User') {
            $this->followingList  = $this->userList->userFollowings()->with('following')->count();
            $this->followerList  = $this->userList->userFollowers()->with('follower')->count();
        }
    }

    public function render()
    {
        return view('livewire.front.common.interested-people');
    }

    public function toggleFollow($userId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $followerId = Auth::id();


        if ($followerId == $userId) {
            return;
        }
        $follow = Follow::where('follower_id', $followerId)
            ->where('following_id', $userId)
            ->first();

        if ($follow) {
            $follow->delete();
        } else {
            Follow::create([
                'follower_id' => $followerId,
                'following_id' => $userId,
                'status' => 'accepted',
            ]);
        }
        $this->isFollowing($userId);
        $this->hydrate();
    }

    public function isFollowing($userId)
    {
        if (!Auth::check()) return false;

        return Follow::where('follower_id', Auth::id())
            ->where('following_id', $userId)
            ->exists();
    }

    #[On('resetSocialMediaCount')]
    public function refreshcount()
    {
        $this->hydrate();
    }
}
