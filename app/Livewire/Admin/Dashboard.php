<?php

namespace App\Livewire\Admin;

use App\Models\{Park, ShareSafari, Package, Species};
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-app')]
class Dashboard extends Component
{
    public $parksCount,$safarisCount,$packagesCount,$speciesCount ;

    public function render()
    {

            $this->parksCount= Park::count();
            $this->safarisCount=  ShareSafari::count();
            $this->packagesCount=  Package::count();
            $this->speciesCount=  Species::count();

        return view('livewire.admin.dashboard');
    }
}
