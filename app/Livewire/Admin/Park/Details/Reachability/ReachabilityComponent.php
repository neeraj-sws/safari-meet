<?php

namespace App\Livewire\Admin\Park\Details\Reachability;

use App\Models\ParkDetailsTabs;
use Livewire\Component;
use Livewire\WithPagination;

class ReachabilityComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $park, $characterDetails, $activeTabe;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'reachability';
        $subActiveTabName = request()->query('subtab');
        if (!empty($subActiveTabName)) {
            $this->activeTabe = $subActiveTabName;
        }
    }

    public function render()
    {
        return view('livewire.admin.park.details.reachability.reachability-component');
    }


    public function toggleStatus($id)
    {
        $detailTabs = ParkDetailsTabs::findOrFail($id);
        $detailTabs->status = !$detailTabs->status;
        $detailTabs->save();
        $this->dispatch('status-updated', id: $detailTabs->id);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    public function changeTab($value)
    {
        $this->activeTabe = $value;
    }
}
