<?php

namespace App\Livewire\Admin\Park\Details\Keyinfo;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\ParkKeyInfoModel;
use App\Models\ParkSafariType;
use App\Models\SafariType;
use Livewire\Component;
use Livewire\WithFileUploads;

class SafariTravelInfo extends Component
{
    use WithFileUploads;

    public $pageTitle = "Safari and Travel Info";
    public $overview_image, $park, $editorId, $characterDetails, $isEditing = false;
    public $safari_types = [], $KeyInfo, $safariType = [], $core_zone, $entry_gates;
    public $nearest_railway, $travelInfopreviousImage, $travel_info_image;


    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->safari_types = SafariType::where('status', true)->pluck('name', 'safari_type_id')->toArray();
        $this->KeyInfo = ParkKeyInfoModel::where('park_id', $this->park->id)->first();
        if ($this->KeyInfo) {
            $this->isEditing = true;
            $this->travelInfopreviousImage = $this->KeyInfo->travel_info_image;
        }
        if (!empty($this->park)) {
            $this->core_zone = $park->core_zone;
            $this->entry_gates = $park->entry_gates;
            $this->nearest_railway = $park->nearest_railway;
            $this->safariType = ParkSafariType::where('park_id', $park->id)->pluck('safari_type_id')->toArray();
        }
    }


    public function render()
    {
        return view('livewire.admin.park.details.keyinfo.safari-travel-info');
    }

    public function store()
    {
        $this->validate([
            'safariType' => 'required',
            'core_zone' => [
                'required',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Core Zone cannot have leading or trailing spaces.');
                    }
                },
            ],
            'entry_gates' => [
                'required',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Core Zone cannot have leading or trailing spaces.');
                    }
                },
            ],
            'nearest_railway' => [
                'required',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Nearest Railway cannot have leading or trailing spaces.');
                    }
                },
            ],
            'travel_info_image' => ($this->isEditing && !empty($this->travelInfopreviousImage))
<<<<<<< HEAD
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:15360',
=======
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        ], [

            'safariType.required' => 'Safari Type is required.',

            'core_zone.required' => 'Core Zone is required.',
            'core_zone.regex' => 'Core Zone must contain only letters, commas, and spaces.',
            'core_zone.max' => 'Core Zone must not exceed 100 characters.',

            'nearest_railway.required' => 'Nearest Railway is required.',
            'nearest_railway.regex' => 'Nearest Railway must contain only letters, commas, and spaces.',
            'nearest_railway.max' => 'Nearest Railway must not exceed 100 characters.',
<<<<<<< HEAD
            'travel_info_image.max'  => 'The banner image must not be greater than 15 MB.',
=======
            'travel_info_image.max'  => 'The banner image must not be greater than 5 MB.',
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        ]);


        if (!empty($this->park)) {

            $this->park->core_zone = $this->core_zone;
            $this->park->entry_gates = $this->entry_gates;
            $this->park->nearest_railway = $this->nearest_railway;

            ParkSafariType::where('park_id', $this->park->id)->delete();
            foreach ($this->safariType as $type) {
                ParkSafariType::create([
                    'park_id' => $this->park->id,
                    'safari_type_id' => $type,
                ]);
            }
            $this->park->save();

            if ($this->travel_info_image) {
                // $origPath = $this->travel_info_image->store('uploads/park', 'public_root');
                // $imagePath = ImageHelper::convertToAvif($origPath, 'uploads/park');

                // if (!empty($this->travelInfopreviousImage) && file_exists(public_path($this->travelInfopreviousImage))) {
                //     @unlink(public_path($this->travelInfopreviousImage));
                // }
                 ImageUploadHelper::delete($this->travelInfopreviousImage);
                $imagePath = ImageUploadHelper::upload($this->travel_info_image, 'uploads/park/key-info');

                if (empty($this->KeyInfo)) {
                    $this->KeyInfo =  ParkKeyInfoModel::create([
                        'park_id' => $this->park->id,
                        'travel_info_image' => $imagePath,
                    ]);
                } else {
                    $this->KeyInfo->travel_info_image = $imagePath;
                    $this->KeyInfo->save();
                }
            } else {
                $imagePath = $this->travelInfopreviousImage;
                if (empty($this->KeyInfo)) {
                    ParkKeyInfoModel::create([
                        'park_id' => $this->park->id,
                        'travel_info_image' => $imagePath,
                    ]);
                } else {
                    $this->KeyInfo->travel_info_image = $imagePath;
                }
                $this->KeyInfo->save();
            }

            $this->travelInfopreviousImage = $this->KeyInfo->travel_info_image;
        }

        $this->reset(['travel_info_image',]);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }

    public function removeTravelImage(): void
    {
        if ($this->travel_info_image) {
            $this->travel_info_image->delete();
        }
        $this->travel_info_image = null;
    }
}
