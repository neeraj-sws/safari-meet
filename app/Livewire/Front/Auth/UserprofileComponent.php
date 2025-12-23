<?php

namespace App\Livewire\Front\Auth;

use App\Helpers\ImageHelper;
use App\Models\{ShareSafari, User};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\{Component, WithFileUploads};
use Carbon\Carbon;

#[Layout('components.layouts.guest')]
class UserprofileComponent extends Component
{
    public $activeTab = 'profile';

    public function mount($type = null)
    {
        if ($type == 'user-safar') {
            $this->activeTab = 'shared-safari';
        }

        $activeTabName = request()->query('tab', 'profile');
        if ($activeTabName == 'profile') {
            $this->activeTab = 'profile';
        } elseif ($activeTabName == 'shared-safari'){
            $this->activeTab = 'shared-safari';
        } elseif ($activeTabName == 'add-media-post'){
            $this->activeTab = 'add-media-post';
        } elseif ($activeTabName == 'following'){
            $this->activeTab = 'following';
        } elseif ($activeTabName == 'follower'){
            $this->activeTab = 'follower';
        }
    }

    public function render()
    {
        return view('livewire.front.auth.userprofile-component');
    }

    public function changeTab($tabName)
    {
        $this->activeTab = $tabName;
    }
}
