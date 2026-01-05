<?php

namespace App\Livewire\Admin\Park\Details\Information;

use App\Helpers\ImageHelper;
use App\Models\ParkDetailsTabs;
use App\Models\ParkInformationModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class InformationComponent extends Component
{
    use WithFileUploads;

    public $pageTitle = "Safari Information", $park, $characterDetails, $bookingProcess, $rules, $isEditing = false, $activeTabe;
    public $information, $informationData, $dos_image, $doPreviousImage, $donts_image, $dontsPreviousImage, $doRules, $dontsRules;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->activeTabe = "safari-information";
        $subActiveTabName = request()->query('subtab');
        if (!empty($subActiveTabName)) {
            $this->activeTabe = $subActiveTabName;
        }
    }

    public function render()
    {
        return view('livewire.admin.park.details.information.information-component');
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
