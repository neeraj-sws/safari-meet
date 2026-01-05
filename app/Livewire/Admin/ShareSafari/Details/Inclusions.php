<?php

namespace App\Livewire\Admin\ShareSafari\Details;

use App\Models\Feature;
use App\Models\PackageDetailsTabs;
use App\Models\SharedSafariDetailsTabs;
use Livewire\Component;

class Inclusions extends Component
{

    public $characterDetails, $package, $activeTabe, $type, $table;

    public function mount($package = null, $characterstic = null, $type, $table = "package")
    {
        $this->package = $package;
        $this->table = $table;
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
        return view('livewire.admin.share-safari.details.inclusions');
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
