<?php

namespace App\Livewire\Admin\Park\Details\Keyinfo;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\City;
use App\Models\Country;
use App\Models\ParkBestTimeModel;
use App\Models\ParkKeyInfoModel;
use App\Models\SafariType;
use App\Models\State;
use App\Models\WeatherModel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ParkOverview extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $pageTitle = "Park Overview";
    public $overview_image, $park, $overViewData, $editorId, $characterDetails, $isEditing = false;
    public $established, $area, $famous_for, $best_time_visit = [], $country_id, $state_id, $city_id;
    public $BestTimeVisit = [], $states = [], $cities = [], $countries = [];
    public $park_overview_image, $overviewpreviousImage, $KeyInfo;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->BestTimeVisit = WeatherModel::where('status', true)->get();
        $this->states = State::where('country_id', $park->country_id)->pluck('name', 'state_id');
        $this->cities = City::where('state_id', $park->state_id)->pluck('name', 'city_id');
        $this->countries = Country::orderByRaw("CASE WHEN name = 'India' THEN 0 ELSE 1 END")
            ->orderBy('name', 'asc')
            ->pluck('name', 'country_id');
        $this->KeyInfo = ParkKeyInfoModel::where('park_id', $this->park->id)->first();
        if ($this->KeyInfo) {
            $this->isEditing = true;
            $this->overviewpreviousImage = $this->KeyInfo->overview_image;
        }
        if (!empty($this->park)) {
            $this->established = $this->park->established;
            $this->area = $this->park->area;
            $this->famous_for = $this->park->famous_for;
            $this->city_id = $park->city_id;
            $this->state_id = $park->state_id;
            $this->country_id = $park->country_id;
            $this->best_time_visit = ParkBestTimeModel::where('park_id', $park->id)->pluck('weathers_id')->toArray();
        }
        $this->dispatch('init-datepicker', ['selector' => '.datepicker']);
    }

    public function render()
    {
        return view('livewire.admin.park.details.keyinfo.park-overview');
    }

    public function store()
    {
        if ($this->established == null) {
            $this->dispatch('swal:toast', ['type' => 'error', 'title' => '', 'message' => ' The Established field is required.']);
        }
        $this->validate([
            'established' => 'required|date_format:Y-m-d',
            'area' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Area cannot have leading or trailing spaces.');
                    }
                },
            ],
            'famous_for' => [
                'required',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Famous For cannot have leading or trailing spaces.');
                    }
                },
            ],
            // 'best_time_visit' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'park_overview_image' => ($this->isEditing && !empty($this->overviewpreviousImage))
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:15360',
        ], [
            'park_overview_image.max' => 'The banner image must not be greater than 15 MB.',
        ]);
        if (!empty($this->park)) {

            $this->park->established = $this->established;
            $this->park->area = $this->area;
            $this->park->famous_for = $this->famous_for;
            $this->park->city_id = $this->city_id;
            $this->park->state_id = $this->state_id;
            $this->park->country_id = $this->country_id;

            ParkBestTimeModel::where('park_id', $this->park->id)->delete();
            foreach ($this->best_time_visit as $bestTime) {
                ParkBestTimeModel::create([
                    'park_id' => $this->park->id,
                    'weathers_id' => $bestTime,
                ]);
            }
            $this->park->save();

            if ($this->park_overview_image) {

                // $origPath = $this->park_overview_image->store('uploads/park', 'public_root');
                // $imagePath = ImageHelper::convertToAvif($origPath, 'uploads/park');

                // if (!empty($this->overviewpreviousImage) && file_exists(public_path($this->overviewpreviousImage))) {
                //     @unlink(public_path($this->overviewpreviousImage));
                // }
                ImageUploadHelper::delete($this->overviewpreviousImage);
                $imagePath = ImageUploadHelper::upload($this->park_overview_image, 'uploads/park/key-info');
                if (empty($this->KeyInfo)) {
                    $this->KeyInfo = ParkKeyInfoModel::create([
                        'park_id' => $this->park->id,
                        'overview_image' => $imagePath,
                    ]);
                } else {
                    $this->KeyInfo->overview_image = $imagePath;
                    $this->KeyInfo->save();
                }
            } else {
                $imagePath = $this->overviewpreviousImage;

                if (empty($this->KeyInfo)) {
                    ParkKeyInfoModel::create([
                        'park_id' => $this->park->id,
                        'overview_image' => $imagePath,
                    ]);
                } else {
                    $this->KeyInfo->overview_image = $imagePath;
                }
                $this->KeyInfo->save();
            }
            $this->isEditing = true;
            $this->overviewpreviousImage = $this->KeyInfo->overview_image;
        }

        $this->reset(['park_overview_image']);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }

    public function removeOverViewImage(): void
    {
        if ($this->park_overview_image) {
            $this->park_overview_image->delete();
        }
        $this->park_overview_image = null;
    }

    public function updatedCountryId($value)
    {
        $this->states = State::where('country_id', $value)->pluck('name', 'state_id');
    }

    public function updatedStateId($value)
    {
        $this->cities = City::where('state_id', $value)->pluck('name', 'city_id');
    }
}
