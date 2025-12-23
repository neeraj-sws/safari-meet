<?php

namespace App\Livewire\Front\Profile;

use App\Helpers\SettingHelper;
use App\Models\JoinSharedSafari;
use App\Models\ShareSafari;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserAccountSharedSafaries extends Component
{
    public $shareSafaris = [], $perPage = 3, $joinedShareSafaris = [], $joinPerPage = 3;

    public function mount()
    {
        $this->loadShareSafaris();
        $this->loadJoinedSharedSafaris();
    }

    public function render()
    {
        return view('livewire.front.profile.user-account-shared-safaries');
    }

    public function loadMore()
    {
        $this->perPage += 3;
        $this->loadShareSafaris();
    }

    private function loadShareSafaris()
    {
        $this->shareSafaris = ShareSafari::with('park.state','joinedsafari')
            ->where('organized_by', Auth::guard('web')->user()->id)
            ->whereIn('organized_type',['user','agent'])
            ->orderBy('shared_safari_id', 'desc')
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
        $joinedSafarisID =   JoinSharedSafari::where('user_id', Auth::guard('web')->id())->pluck('share_safari_id')->toArray();
        $this->joinedShareSafaris = ShareSafari::with('park.state')
            ->whereIn('shared_safari_id', $joinedSafarisID)
            ->take($this->joinPerPage)
            ->get();
    }

    public function deletejoinsafari($id)
    {
        $join_safari = JoinSharedSafari::find($id);
        if (!empty($join_safari)) {
            $join_safari->delete();
            $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => "Leave Shared Safari  Successfully",
            ]);
        } else {
            return $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => "Something went wrong",
            ]);
        }
    }
}
