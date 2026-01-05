<?php

namespace App\Livewire\TravelAgent\SharedSafari\Details;

use App\Models\PackageDetailsTabs;
use App\Models\SharedSafariDetailsTabs;
use Livewire\Component;

class ThingsToCarry extends Component
{

    public $characterDetails, $safari, $activeTabe, $section = 'show';

    public function mount($package = null, $characterstic = null, $section  = 'all')
    {

        $this->safari = $package;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'thingstocarry';
        $this->section = ($section == 'user') ? 'hide' : 'show';
    }

    public function render()
    {
        return view('livewire.travel-agent.shared-safari.details.things-to-carry');
    }


    public function changeTab() {}


    public function toggleStatus($id)
    {
        $detailTabs = SharedSafariDetailsTabs::findOrFail($id);
        $detailTabs->status = !$detailTabs->status;
        $detailTabs->save();
        $this->dispatch('package-status-updated', id: $detailTabs->id);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
}
