<?php

namespace App\Livewire\Admin\Park\Details\Faq;

use Livewire\Component;
use App\Models\ParkDetailsTabs;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ParkFaq extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $park, $characterDetails, $activeTabe;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'faq';
        $subActiveTabName = request()->query('subtab');
        if (!empty($subActiveTabName)) {
            $this->activeTabe = $subActiveTabName;
        }
    }
    public function render()
    {
        return view('livewire.admin.park.details.faq.park-faq');
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
