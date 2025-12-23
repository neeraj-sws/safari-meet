<?php

namespace App\Livewire\Admin\Package;

use App\Models\{Package, PackageDetailsTabs, PackageTabs, Park};
use Livewire\Attributes\{Layout, On};
use Livewire\Component;
use Illuminate\Support\Str;

#[Layout('components.layouts.admin-app')]
class PackageDetail extends Component
{
    public $showModal = false, $isEditing = false;
    public $modalTitle = 'Add', $pageTitle = 'Package Detail';
    public $package, $packageId;
    public $title, $shortDescription;
    public $characterstics = [], $characterDetailsData = [], $detailsMap = [], $showNavTab, $hasActiveData;
    public $safariPark, $safariParks;

    public function mount($uuid)
    {
        $this->packageId = $uuid;
        $this->package = Package::with(['park'])->where('uuid', $uuid)->first();
        $this->characterstics = PackageTabs::where('status', 1)->get();
        $this->characterDetailsData = PackageDetailsTabs::where('package_id', $this->package->id)->get();
        $this->detailsMap = $this->characterDetailsData->keyBy('package_tabs_id')->toArray();
        $activeTabName = request()->query('tab');
        if (!empty($activeTabName)) {
            $this->showNavTab = $this->characterstics->first(function ($item) use ($activeTabName) {
                return Str::slug($item->title, '_') === $activeTabName;
            }) ?? $this->characterstics->first();
        } else {
            $this->showNavTab = $this->characterstics->first() ?? null;
        }

        if ($this->showNavTab && !isset($this->detailsMap[$this->showNavTab->id])) {
            $newEntry = PackageDetailsTabs::create([
                'package_tabs_id' => $this->showNavTab->id,
                'package_id' => $this->package->id,
                'title' => $this->showNavTab->title,
                'status' => false,
            ]);

            $this->characterDetailsData = PackageDetailsTabs::where('package_id', $this->package->id)->get();
            $this->detailsMap = $this->characterDetailsData->keyBy('package_tabs_id')->toArray();
        }

        $this->hasActiveData = $this->detailsMap[$this->showNavTab->id] ?? null;

        $this->safariParks = Park::pluck('name', 'park_id');
        $this->safariPark = $this->package->package_park_id;
        $this->title = $this->package->title;
        $this->shortDescription = $this->package->short_description;
    }

    public function render()
    {
        return view('livewire.admin.package.detail');
    }

    public function toggleStatus($id)
    {

        $this->showNavTab = $this->characterstics->where('package_tabs_id', $id)->first() ?? null;
        if (!array_key_exists($id, $this->detailsMap)) {
            $characteristic = PackageTabs::find($id);

            if ($characteristic) {
                $newEntry = PackageDetailsTabs::create([
                    'package_tabs_id' => $characteristic->id,
                    'package_id' => $this->package->id,
                    'title' => $characteristic->title,
                    'status' => false,
                ]);

                $this->detailsMap[$id] = $newEntry->toArray();
                $this->hasActiveData = $this->detailsMap[$id];
            } else {
                $this->hasActiveData = null;
            }
        } else {
            $this->hasActiveData = $this->detailsMap[$id];
        }
    }

    #[On('package-status-updated')]
    public function refreshStatus($id)
    {
        $updatedDetail = PackageDetailsTabs::find($id);

        if ($updatedDetail) {
            $this->detailsMap[$updatedDetail->package_tabs_id] = $updatedDetail->toArray();
            $this->characterDetailsData = PackageDetailsTabs::where('package_id', $this->package->id)->get();
        }
    }
}
