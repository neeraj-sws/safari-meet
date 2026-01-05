<?php

namespace App\Livewire\Admin\Package\Details;

use App\Models\PackageDetailsTabs;
use Livewire\Component;

class Discussion extends Component
{

    public $characterDetails, $package, $activeTabe;

    public function mount($package = null, $characterstic = null)
    {
        $this->package = $package;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'discussion';
    }

    public function render()
    {
        return view('livewire.admin.package.details.discussion');
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
