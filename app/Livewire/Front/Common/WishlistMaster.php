<?php

namespace App\Livewire\Front\Common;

use App\Models\JoinSharedSafari;
use App\Models\ShareSafari;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class WishlistMaster extends Component
{
    public $packageWishlist = [], $perPage = 3, $sharedSafariWishlist = [], $joinPerPage = 3, $authUser;

    public function mount()
    {
        $this->authUser = Auth::guard('web')->user();
        $this->loadShareSafaris();
        $this->loadJoinedSharedSafaris();
    }

    public function render()
    {
        return view('livewire.front.common.wishlist-master');
    }

    public function loadMore()
    {
        $this->perPage += 3;
        $this->loadShareSafaris();
    }

    private function loadShareSafaris()
    {
        $this->sharedSafariWishlist = Wishlist::with(['sharedSafari.park.state'])
            ->where('user_id', $this->authUser->id)
            ->whereNotNull('shared_safari_id')
            ->take($this->perPage)
            ->get();
    }

    public function joinedLoadMore()
    {
        $this->joinPerPage += 3;
        $this->loadJoinedSharedSafaris();
    }

    private function loadJoinedSharedSafaris()
    {
        $this->packageWishlist = Wishlist::with(['package.park.state'])
            ->where('user_id', $this->authUser->id)
            ->whereNotNull('package_id')
            ->take($this->perPage)
            ->get();
    }
}
