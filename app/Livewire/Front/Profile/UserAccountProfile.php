<?php

namespace App\Livewire\Front\Profile;

use App\Models\{User};
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserAccountProfile extends Component
{
    public  $user;

    public function mount()
    {
        $this->user = User::find(Auth::guard('web')->user()->id);
    }

    public function render()
    {
        return view('livewire.front.profile.user-account-profile');
    }
}
