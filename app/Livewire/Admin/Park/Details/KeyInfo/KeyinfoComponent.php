<?php

namespace App\Livewire\Admin\Park\Details\KeyInfo;

use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;
use App\Models\ParkDetailsTabs;

// #[Layout('components.layouts.admin-app')]
class KeyinfoComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $pageTitle = "Key Info";
    public $overview_image, $park, $overViewData, $editorId, $characterDetails, $isEditing = false;
    public $established, $area, $famous_for, $best_time_visit = [], $country_id, $state_id, $city_id;
    public $BestTimeVisit = [], $states = [], $cities = [], $countries = [], $safari_types = [];
    public $park_overview_image, $overviewpreviousImage, $KeyInfo, $safariType = [], $core_zone, $entry_gates;
    public $nearest_railway, $travelInfopreviousImage, $travel_info_image, $timingCostPreviousImage, $timing_cost_image, $morning_time;
    public $afternoon_time, $core_zone_price, $buffer_zone_price, $activeTabe;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'park-overview';
        $subActiveTabName = request()->query('subtab');
        if (!empty($subActiveTabName)) {
            $this->activeTabe = $subActiveTabName;
        }
    }

    public function render()
    {
        return view('livewire.admin.park.details.keyinfo.keyinfo-component');
    }

    public function changeTab($value)
    {
        $this->activeTabe = $value;
    }

    public function toggleStatus($id)
    {
        $detailTabs = ParkDetailsTabs::findOrFail($id);
        $detailTabs->status = !$detailTabs->status;
        $detailTabs->save();
        $this->dispatch('status-updated', id: $detailTabs->id);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
}
