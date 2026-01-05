<?php

namespace App\Livewire\TravelAgent\SharedSafari\Details;

use App\Models\PackageDetailsTabs;
use App\Models\PackageTabs;
use App\Models\SafariDetailsDynamicTabs;
use App\Models\SharedSafariDetailsTabs;
use App\Models\SharedShafariTabs;
use Livewire\Component;

class CommonTabs extends Component
{
    public $characterDetails, $package, $activeTabe, $pageTitle, $short_description, $existingFact, $type, $column, $column2, $section = 'show';

    public function mount($package, $type, $characterstic, $section = 'all')
    {
        $this->package = $package;
        $this->characterDetails = $characterstic;
        $this->type = $type;
        $this->activeTabe = 'discussion';
        if ($this->type == 1) {
            if (!empty($this->characterDetails)) {
                $tab = SharedShafariTabs::find($this->characterDetails['shared_safari_tabs_id']);
                $this->pageTitle = $tab?->title;
            }
        } else {

            if (!empty($this->characterDetails)) {
                $tab = PackageTabs::find($this->characterDetails['package_tabs_id']);
                $this->pageTitle = $tab?->title;
            }
        }
        $this->column = ($this->type == 1) ? 'shared_safari_id' : 'package_id';
        $this->column2 = ($this->type == 1) ? 'shared_shafari_details_tabs_id' : 'package_details_tabs_id';
        $this->existingFact = SafariDetailsDynamicTabs::where($this->column, $this->package->id)->where($this->column2, $this->characterDetails['id'])->first();

        if ($this->existingFact) {
            $this->short_description = $this->existingFact->short_description;
        }
        $this->section = ($section == 'user') ? 'hide' : 'show';
    }

    public function render()
    {
        return view('livewire.travel-agent.shared-safari.details.common-tabs');
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
                $this->column2 => $this->characterDetails['id'],
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
        $detailTabs = SharedSafariDetailsTabs::findOrFail($id);
        $detailTabs->status = !$detailTabs->status;
        $detailTabs->save();
        $this->dispatch('package-status-updated', id: $detailTabs->id);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
}
