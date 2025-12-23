<?php

namespace App\Livewire\Admin\Package\Details;

use App\Models\Feature;
use App\Models\PackageDetailsTabs;
use Livewire\Component;

class Inclusions extends Component
{

    public $characterDetails, $package, $activeTabe, $type;

    public function mount($package = null, $characterstic = null, $type)
    {
        $this->package = $package;
        $this->characterDetails = $characterstic;
        if ($type == 1) {
            $this->type = "Inclusion";
            $this->activeTabe = 'Inclusion';
        } elseif ($type == 2) {
            $this->type = "Exclusion";
            $this->activeTabe = 'Exclusion';
        } else {
            return;
        }
    }

    public function render()
    {
        return view('livewire.admin.package.details.inclusions');
    }


    public function changeTab() {}


    public function toggleStatus($id)
    {
        $detailTabs = PackageDetailsTabs::findOrFail($id);
        $detailTabs->status = !$detailTabs->status;
        $detailTabs->save();
        $this->dispatch('package-status-updated', id: $detailTabs->id);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
}
