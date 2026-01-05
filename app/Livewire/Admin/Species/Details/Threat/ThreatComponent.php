<?php

namespace App\Livewire\Admin\Species\Details\Threat;

use App\Models\SpeciesDetailsCharactersticModel;
use Livewire\Component;


// #[Layout('components.layouts.admin-app')]
class ThreatComponent extends Component
{

    public $species, $characterDetails, $activeTabe;

    public function mount($species = null, $characterstic = null)
    {
        $this->species = $species;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'threats';
        $subActiveTabName = request()->query('subtab');
        if (!empty($subActiveTabName)) {
            $this->activeTabe = $subActiveTabName;
        }
    }

    public function render()
    {
        return view('livewire.admin.species.details.threat.threat-component');
    }


    public function changeTab($value)
    {
        $this->activeTabe = $value;
    }

    public function toggleStatus($id)
    {
        $detailTabs = SpeciesDetailsCharactersticModel::findOrFail($id);
        $detailTabs->status = !$detailTabs->status;
        $detailTabs->save();
        $this->dispatch('species-status-updated', id: $detailTabs->id);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
}
