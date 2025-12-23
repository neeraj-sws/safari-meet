<?php

namespace App\Livewire\Admin\Package\Details;

use App\Models\PackageDetailsTabs;
use Livewire\Component;

class Ratings extends Component
{

    public $characterDetails, $package, $activeTabe, $isEditing = false;

    public function mount($package = null, $characterstic = null)
    {
        $this->package = $package;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'ratingsheading';
        $subActiveTabName = request()->query('subtab');
        if (!empty($subActiveTabName)) {
            $this->activeTabe = $subActiveTabName;
        }
    }

    public function render()
    {
        return view('livewire.admin.package.details.ratings');
    }

    public function changeTab($value)
    {
        $this->activeTabe = $value;
    }

    public function toggleStatus($id)
    {
        $detailTabs = PackageDetailsTabs::findOrFail($id);
        $detailTabs->status = !$detailTabs->status;
        $detailTabs->save();
        $this->dispatch('package-status-updated', id: $detailTabs->id);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
}
