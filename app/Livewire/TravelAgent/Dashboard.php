<?php

namespace App\Livewire\TravelAgent;

use App\Models\{Package,ShareSafari};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Layout};
use Livewire\{Component};

#[Layout('components.layouts.agent-app')]
class Dashboard extends Component
{
    public $parksCount, $safarisCount, $packagesCount, $speciesCount;

    public function mount()
    {
        if (Auth::guard('web')->user()->status != 1) {
            return redirect()->route('profile-edit');
        }

        $this->safarisCount =  ShareSafari::where('organized_by',Auth::guard('web')->user()->id)->where('organized_type','agent')->count();
        $this->packagesCount =  Package::where('organized_by',Auth::guard('web')->user()->id)->where('type',1)->count();
    }

    public function render()
    {
        return view('livewire.travel-agent.dashboard');
    }
}
