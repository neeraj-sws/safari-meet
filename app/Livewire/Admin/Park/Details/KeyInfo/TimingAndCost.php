<?php

namespace App\Livewire\Admin\Park\Details\Keyinfo;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\ParkBestTimeModel;
use App\Models\ParkKeyInfoModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class TimingAndCost extends Component
{

    use WithFileUploads;

    public $pageTitle = "Timings & Cost";
    public $KeyInfo, $overview_image, $park, $editorId, $characterDetails, $isEditing = false;
    public $timingCostPreviousImage, $timing_cost_image, $morning_time, $afternoon_time, $core_zone_price, $buffer_zone_price;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;

        $this->KeyInfo = ParkKeyInfoModel::where('park_id', $this->park->id)->first();
        if ($this->KeyInfo) {
            $this->isEditing = true;
            $this->timingCostPreviousImage = $this->KeyInfo->timing_cost_image;
        }
        if (!empty($this->park)) {

            $this->morning_time = $park->morning_time;
            $this->afternoon_time = $park->afternoon_time;
            $this->core_zone_price = $park->core_zone_price;
            $this->buffer_zone_price = $park->buffer_zone_price;
        }
    }

    public function render()
    {
        return view('livewire.admin.park.details.keyinfo.timing-and-cost');
    }

    public function store()
    {
        $this->validate([
            'afternoon_time' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Afternoon Time cannot have leading or trailing spaces.');
                    }
                },
            ],

            'morning_time' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Morning Time cannot have leading or trailing spaces.');
                    }
                },
            ],
            'core_zone_price' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim($value) !== $value) {
                        $fail('Core Zone Price cannot have leading or trailing spaces.');
                    }
                },
            ],

            'buffer_zone_price' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim($value) !== $value) {
                        $fail('Buffer Zone Price cannot have leading or trailing spaces.');
                    }
                },
            ],
            'timing_cost_image' => ($this->isEditing && !empty($this->timingCostPreviousImage))
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:15360',
        ], [
            'core_zone.required' => 'The Core Zone is required.',
            'core_zone.regex' => 'The Core Zone can only contain alphabets, commas, and spaces.',
            'core_zone.max' => 'The Core Zone may not be greater than 100 characters.',

            'buffer_zone.required' => 'The Buffer Zone is required.',
            'buffer_zone.regex' => 'The Buffer Zone can only contain alphabets, commas, and spaces.',
            'buffer_zone.max' => 'The Buffer Zone may not be greater than 100 characters.',

            'afternoon_time.required' => 'The Afternoon Time is required.',
            'afternoon_time.regex' => 'The Afternoon Time can only contain letters, numbers, and the characters: -, /, |, :, ;.',

            'morning_time.required' => 'The Morning Time is required.',
            'morning_time.regex' => 'The Morning Time can only contain letters, numbers, and the characters: -, /, |, :, ;.',

            'travel_info_image.max'  => 'The banner image must not be greater than 15 MB.',

        ]);


        if (!empty($this->park)) {

            $this->park->afternoon_time = $this->afternoon_time;
            $this->park->morning_time = $this->morning_time;
            $this->park->core_zone_price = $this->core_zone_price;
            $this->park->buffer_zone_price = $this->buffer_zone_price;
            $this->park->save();

            if ($this->timing_cost_image) {
                // $origPath = $this->timing_cost_image->store('uploads/park', 'public_root');
                // $imagePath = ImageHelper::convertToAvif($origPath, 'uploads/park');

                // if (!empty($this->timingCostPreviousImage) && file_exists(public_path($this->timingCostPreviousImage))) {
                //     @unlink(public_path($this->timingCostPreviousImage));
                // }
                 ImageUploadHelper::delete($this->timingCostPreviousImage);
                $imagePath = ImageUploadHelper::upload($this->timing_cost_image, 'uploads/park/key-info');

                if (empty($this->KeyInfo)) {
                    $this->KeyInfo =  ParkKeyInfoModel::create([
                        'park_id' => $this->park->id,
                        'timing_cost_image' => $imagePath,
                    ]);
                } else {
                    $this->KeyInfo->timing_cost_image = $imagePath;
                    $this->KeyInfo->save();
                }
            } else {
                $imagePath = $this->timingCostPreviousImage;

                if (empty($this->KeyInfo)) {
                    ParkKeyInfoModel::create([
                        'park_id' => $this->park->id,
                        'timing_cost_image' => $imagePath,
                    ]);
                } else {
                    $this->KeyInfo->timing_cost_image = $imagePath;
                }
                $this->KeyInfo->save();
            }

            $this->timingCostPreviousImage = $this->KeyInfo->timing_cost_image;
        }

        $this->reset(['timing_cost_image']);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }

    public function removeTimingImage(): void
    {
        if ($this->timing_cost_image) {
            $this->timing_cost_image->delete();
        }
        $this->timing_cost_image = null;
    }
}
