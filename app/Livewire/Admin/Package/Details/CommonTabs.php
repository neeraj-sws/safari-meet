<?php

namespace App\Livewire\Admin\Package\Details;

use App\Models\PackageDetailsTabs;
use App\Models\PackageTabs;
use App\Models\SafariDetailsDynamicTabs;
use Livewire\Component;

class CommonTabs extends Component
{
    public $characterDetails, $package, $activeTabe, $pageTitle, $short_description, $existingFact, $type, $column;

    public function mount($package, $type, $characterstic)
    {
        $this->package = $package;
        $this->characterDetails = $characterstic;
        $this->type = $type;
        $this->activeTabe = 'discussion';

        if (!empty($this->characterDetails)) {
            $tab = PackageTabs::find($this->characterDetails['package_tabs_id']);
            $this->pageTitle = $tab?->title;
        }
        $this->column = ($this->type == 1) ? 'shared_safari_id' : 'package_id';
        $this->existingFact = SafariDetailsDynamicTabs::where($this->column, $this->package->id)->where('package_details_tabs_id', $this->characterDetails['package_details_tabs_id'])->first();

        if ($this->existingFact) {
            $this->short_description = $this->existingFact->short_description;
        }
    }

    public function render()
    {
        return view('livewire.admin.package.details.common-tabs');
    }

    public function store()
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
            $this->existingFact = SafariDetailsDynamicTabs::create([
                $this->column => $this->package->id,
                'short_description' => $this->short_description,
                'package_details_tabs_id' => $this->characterDetails['package_details_tabs_id'],
                'key' =>  $this->package->slug,
            ]);
        }

        $this->resetValidation();
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' saved successfully.'
        ]);
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
