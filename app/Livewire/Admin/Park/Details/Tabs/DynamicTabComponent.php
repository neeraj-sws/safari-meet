<?php

namespace App\Livewire\Admin\Park\Details\Tabs;

use App\Models\ParkDetailsDynamicTabs;
use App\Models\ParkDetailsTabs;
use App\Models\ParkTabs;
use Livewire\Component;

class DynamicTabComponent extends Component
{
    public $park, $characterstic;
    public $short_description;
    public $pageTitle = '';
    public $existingFact, $activeTabe;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterstic = $characterstic;
        if (!empty($this->characterstic)) {
            $tab = ParkTabs::find($this->characterstic['park_tabs_id']);
            $this->pageTitle = $tab?->title;
        }

        $this->activeTabe = 'overview';
        $this->existingFact = ParkDetailsDynamicTabs::where('park_id',$this->park->id)->where('park_details_characterstics_id',$this->characterstic['park_details_tabs_id'])->first();

        if ($this->existingFact) {
            $this->short_description = $this->existingFact->short_description;
        }
        $this->dispatch('initializeCKEditor');
    }

    public function render()
    {
        return view('livewire.admin.park.details.tabs.dynamic-tab-component');
    }

    public function storeIntrestingFacts()
    {
        $this->validate([
            'short_description' => 'required',
        ], [
            'short_description.required' => 'The Short Description field is required.',
        ]);

        if ($this->existingFact) {
            $this->existingFact->update([
                'short_description' => $this->short_description,
            ]);
        } else {
            $this->existingFact = ParkDetailsDynamicTabs::create([
                'park_id' => $this->park->id,
                'short_description' => $this->short_description,
                'park_details_characterstics_id' => $this->characterstic['park_details_tabs_id'],
                'key' =>  $this->park->slug,
            ]);
        }

        $this->resetValidation();
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' saved successfully.'
        ]);
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
