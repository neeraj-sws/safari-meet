<?php

namespace App\Livewire\Admin\Park\Details\Information;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\ParkInformationModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class ParkDonts extends Component
{
    use WithFileUploads;

    public $pageTitle = "Park Do's", $park, $characterDetails;
    public $informationData, $dontsRules, $donts_image, $dontsPreviousImage, $isEditing = false;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->informationData = ParkInformationModel::where('park_id', $this->park->id)->first();
        if (!empty($this->informationData)) {
            $this->dontsRules = $this->informationData->donts_description;
            $this->dontsPreviousImage = $this->informationData->donts_image;
            $this->isEditing = true;
        }
        $this->dispatch('initializeCKEditor');
    }

    public function render()
    {
        return view('livewire.admin.park.details.information.park-donts');
    }

    public function store()
    {
        $this->validate([
            'dontsRules' => 'required',
            'donts_image' => ($this->isEditing && !empty($this->dontsPreviousImage)) ? 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:5120'
                : 'required|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:5120',
        ], [
            'donts_image.max' => 'The banner image must not be greater than 5 MB.',
        ]);


        if (empty($this->informationData)) {
            $dontsimagePath = '';
            if ($this->donts_image) {
                // $origPath = $this->donts_image->store('uploads/park', 'public_root');
                // $dontsimagePath = ImageHelper::convertToAvif($origPath, 'uploads/park');

                // if (!empty($this->dontsPreviousImage) && file_exists(public_path($this->dontsPreviousImage))) {
                //     @unlink(public_path($this->dontsPreviousImage));
                // }

                ImageUploadHelper::delete($this->dontsPreviousImage);
                $dontsimagePath = ImageUploadHelper::upload($this->donts_image, 'uploads/park/do-dont');
            }
            ParkInformationModel::create([
                'park_id' => $this->park->id,
                'donts_image' => $dontsimagePath,
                'donts_description' => $this->dontsRules,

            ]);
        } else {
            $dontsimagePath = '';
            if ($this->donts_image) {
                // $origPath = $this->donts_image->store('uploads/park', 'public_root');
                // $dontsimagePath = ImageHelper::convertToAvif($origPath, 'uploads/park');
                // if (!empty($this->dontsPreviousImage) && file_exists(public_path($this->dontsPreviousImage))) {
                //     @unlink(public_path($this->dontsPreviousImage));
                // }
                ImageUploadHelper::delete($this->dontsPreviousImage);
                $dontsimagePath = ImageUploadHelper::upload($this->donts_image, 'uploads/park/do-dont');
            } else {
                $dontsimagePath = $this->dontsPreviousImage;
            }
            $this->informationData->donts_description = $this->dontsRules;
            $this->informationData->donts_image = $dontsimagePath;
            $this->informationData->save();
        }
        $this->dontsPreviousImage = $this->informationData->donts_image;
        $this->reset('donts_image');
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }

    public function removeDontsImage()
    {
        $this->donts_image = null;
    }
}
