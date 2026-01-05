<?php

namespace App\Livewire\Admin\Park\Details\TravelTips;


use App\Models\ParkDetailsTabs;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TravelTipsComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $park, $characterDetails, $activeTabe;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'weather-info';
        $subActiveTabName = request()->query('subtab');
        if (!empty($subActiveTabName)) {
            $this->activeTabe = $subActiveTabName;
        }
    }
    public function render()
    {
        return view('livewire.admin.park.details.travel-tips.travel-tips-component');
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
