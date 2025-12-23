<?php

namespace App\Livewire\Admin\Park\Details\Accommodation;

use App\Models\ParkDetailsTabs;
use Livewire\Component;

class ParkAccommodation extends Component
{
    public $pageTitle = "Safari Information", $park, $characterDetails, $activeTabe;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->activeTabe = "Accommodations";
    }

    public function render()
    {
        return view('livewire.admin.park.details.accommodation.park-accommodation');
    }

    public function changeTab($value)
    {
        $this->activeTabe = $value;
    }
    public function toggleStatus($id)
    {
        $detailTabs = ParkDetailsTabs::findOrFail($id);
        $detailTabs->status = !$detailTabs->status;
        $detailTabs->save();
        $this->dispatch('status-updated', id: $detailTabs->id);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
}
