<?php

namespace App\Livewire\Admin\Park\Details\About;

use App\Models\ParkDetailsTabs;
use Livewire\Component;
use Livewire\WithFileUploads;

class AboutComponent extends Component
{
    use WithFileUploads;

    public $pageTitle = "Key Info", $park, $characterDetails, $activeTabe;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'about';
    }

    public function render()
    {
        return view('livewire.admin.park.details.about.about-component');
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
