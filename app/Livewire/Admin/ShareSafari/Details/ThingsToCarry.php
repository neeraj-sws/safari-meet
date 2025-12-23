<?php

namespace App\Livewire\Admin\ShareSafari\Details;

use App\Models\PackageDetailsTabs;
use App\Models\SharedSafariDetailsTabs;
use Livewire\Component;

class ThingsToCarry extends Component
{

    public $characterDetails, $safari, $activeTabe;

    public function mount($package = null, $characterstic = null)
    {

        $this->safari = $package;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'thingstocarry';
    }

    public function render()
    {
        return view('livewire.admin.share-safari.details.things-to-carry');
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
