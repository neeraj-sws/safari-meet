<?php

namespace App\Livewire\TravelAgent\SharedSafari;

use App\Helpers\ImageHelper;
use App\Models\{Park, ShareSafari, SharedSafariDetailsTabs, SharedShafariTabs};
use Livewire\Attributes\{Layout, On};
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

#[Layout('components.layouts.agent-app')]
class ShareSafariDetail extends Component
{
    public $showModal = false, $isEditing = false, $editId, $safariPark, $details;
    public $modalTitle = 'Add', $pageTitle = 'Share Safari Detail', $shareSafari, $safariParksId, $safariParks = [];
    public $characterstics = [], $characterDetailsData = [], $detailsMap = [], $showNavTab, $hasActiveData;

    public function mount($uuid)
    {
        $this->shareSafari = ShareSafari::with(['park'])->where('uuid', $uuid)->first();
        $this->safariParksId = $this->shareSafari->id;
        $this->safariParks = Park::pluck('name', 'park_id');
        $this->characterstics = SharedShafariTabs::where('status', 1)->get();
        $this->characterDetailsData = SharedSafariDetailsTabs::where('shared_safari_id', $this->shareSafari->id)->get();
        $this->detailsMap = $this->characterDetailsData->keyBy('shared_safari_tabs_id')->toArray();
        $activeTabName = request()->query('tab');
        if (!empty($activeTabName)) {
            $this->showNavTab = $this->characterstics->first(function ($item) use ($activeTabName) {
                return Str::slug($item->title, '_') === $activeTabName;
            }) ?? $this->characterstics->first();
        } else {
            $this->showNavTab = $this->characterstics->first() ?? null;
        }

        if ($this->showNavTab && !isset($this->detailsMap[$this->showNavTab->id])) {
            $newEntry = SharedSafariDetailsTabs::create([
                'shared_safari_tabs_id' => $this->showNavTab->id,
                'shared_safari_id' => $this->shareSafari->id,
                'title' => $this->showNavTab->title,
                'status' => true,
            ]);

            $this->characterDetailsData = SharedSafariDetailsTabs::where('shared_safari_id', $this->shareSafari->id)->get();
            $this->detailsMap = $this->characterDetailsData->keyBy('shared_safari_tabs_id')->toArray();
        }
        $this->hasActiveData = $this->detailsMap[$this->showNavTab->id] ?? null;
        $this->safariPark = $this->shareSafari->safari_park_id;
    }

    public function render()
    {
        return view('livewire.travel-agent.shared-safari.detail');
    }

    public function toggleStatus($id)
    {
        $this->showNavTab = $this->characterstics->where('shared_shafari_tabs_id', $id)->first() ?? null;

        if (!array_key_exists($id, $this->detailsMap)) {
            $characteristic = SharedShafariTabs::find($id);

            if ($characteristic) {
                $newEntry = SharedSafariDetailsTabs::create([
                    'shared_safari_tabs_id' => $characteristic->id,
                    'shared_safari_id' => $this->shareSafari->id,
                    'title' => $characteristic->title,
                    'status' => true,
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
        $updatedDetail = SharedSafariDetailsTabs::find($id);

        if ($updatedDetail) {
            $this->detailsMap[$updatedDetail->shared_safari_id] = $updatedDetail->toArray();
            $this->characterDetailsData = SharedSafariDetailsTabs::where('shared_safari_id', $this->shareSafari->id)->get();
        }
    }
}
