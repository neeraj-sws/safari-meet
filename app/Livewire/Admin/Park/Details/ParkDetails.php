<?php

namespace App\Livewire\Admin\Park\Details;

use App\Models\{Park, ParkTabs, ParkDetailsTabs};
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Str;

#[Layout('components.layouts.admin-app')]
class ParkDetails extends Component
{
    public $pageTitle = "Park Details";
    public $parkID, $parkData, $characterstics;
    public $selectedIds = [], $characterDetailsData = [], $detailsMap = [], $showNavTab, $hasActiveData;

    public function mount($uuid = null)
    {
        $this->parkID = $uuid;
        $this->parkData = Park::where('uuid', $uuid)->firstOrFail();
        $this->characterstics = ParkTabs::where('status', 1)->get();
        $this->characterDetailsData = ParkDetailsTabs::where('park_id', $this->parkData->id)->get();
        $this->detailsMap = $this->characterDetailsData->keyBy('park_tabs_id')->toArray();

        $activeTabName = request()->query('tab');
        if (!empty($activeTabName)) {
            $this->showNavTab = $this->characterstics->first(function ($item) use ($activeTabName) {
                return Str::slug($item->title, '_') === $activeTabName;
            }) ?? $this->characterstics->first();
        } else {
            $this->showNavTab = $this->characterstics->first() ?? null;
        }

        if ($this->showNavTab) {
            if (!isset($this->detailsMap[$this->showNavTab->id])) {
                $newEntry = ParkDetailsTabs::create([
                    'park_tabs_id' => $this->showNavTab->id,
                    'park_id' => $this->parkData->id,
                    'title' => $this->showNavTab->title,
                    'status' => false,
                ]);
                $this->characterDetailsData = ParkDetailsTabs::where('park_id', $this->parkData->id)->get();
                $this->detailsMap = $this->characterDetailsData->keyBy('park_tabs_id')->toArray();
            }
        }

        $this->hasActiveData = $this->detailsMap[$this->showNavTab->id];
        $this->selectedIds = collect($this->characterDetailsData)
            ->where('status', 1)
            ->pluck('park_characterstics')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.park.details.park-details');
    }

    public function toggleStatus($id)
    {
        $this->showNavTab = $this->characterstics->where('park_tabs_id', $id)->first() ?? null;

        if (!array_key_exists($id, $this->detailsMap)) {
            $characteristic = ParkTabs::find($id);

            if ($characteristic) {
                $newEntry = ParkDetailsTabs::create([
                    'park_tabs_id' => $characteristic->id,
                    'park_id' => $this->parkData->id,
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

    #[On('status-updated')]
    public function refreshStatus($id)
    {
        $updatedDetail = ParkDetailsTabs::find($id);
        if ($updatedDetail) {
            $this->detailsMap[$updatedDetail->park_tabs_id] = $updatedDetail->toArray();
            $this->characterDetailsData = ParkDetailsTabs::where('park_id', $this->parkData->id)->get();
        }
    }
}
