<?php

namespace App\Livewire\Admin\Park\Details\Information;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\ParkInformationModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class ParkDos extends Component
{
    use WithFileUploads;

    public $pageTitle = "Park Do's", $park, $characterDetails;
    public $informationData, $doRules, $dos_image, $doPreviousImage, $isEditing = false;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->informationData = ParkInformationModel::where('park_id', $this->park->id)->first();
        if (!empty($this->informationData)) {
            $this->doRules = $this->informationData->dos_description;
            $this->doPreviousImage = $this->informationData->dos_image;
            $this->isEditing = true;
        }
        // $this->dispatch('initializeCKEditor');
    }

    public function render()
    {
        return view('livewire.admin.park.details.information.park-dos');
    }

    public function store()
    {
        $this->validate([
            'doRules' => 'required',
            'dos_image' => ($this->isEditing && !empty($this->doPreviousImage)) ? 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:5120'
<<<<<<< HEAD
                : 'required|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:15360',
        ], [
            'dos_image.max' => 'The banner image must not be greater than 15 MB.',
=======
                : 'required|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:5120',
        ], [
            'dos_image.max' => 'The banner image must not be greater than 5 MB.',
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        ]);


        if (empty($this->informationData)) {
            $dosimagePath = '';
            if ($this->dos_image) {
                // $origPath = $this->dos_image->store('uploads/park', 'public_root');
                // $dosimagePath = ImageHelper::convertToAvif($origPath, 'uploads/park');

                // if (!empty($this->doPreviousImage) && file_exists(public_path($this->doPreviousImage))) {
                //     @unlink(public_path($this->doPreviousImage));
                // }

                ImageUploadHelper::delete($this->doPreviousImage);
                $dosimagePath = ImageUploadHelper::upload($this->dos_image, 'uploads/park/do-dont');
            }
            ParkInformationModel::create([
                'park_id' => $this->park->id,
                'dos_image' => $dosimagePath,
                'dos_description' => $this->doRules,

            ]);
        } else {
            $dosimagePath = '';
            if ($this->dos_image) {
                // $origPath = $this->dos_image->store('uploads/park', 'public_root');
                // $dosimagePath = ImageHelper::convertToAvif($origPath, 'uploads/park');

                // if (!empty($this->doPreviousImage) && file_exists(public_path($this->doPreviousImage))) {
                //     @unlink(public_path($this->doPreviousImage));
                // }

                ImageUploadHelper::delete($this->doPreviousImage);
                $dosimagePath = ImageUploadHelper::upload($this->dos_image  , 'uploads/park/do-dont');
            } else {
                $dosimagePath = $this->doPreviousImage;
            }
            $this->informationData->dos_description = $this->doRules;
            $this->informationData->dos_image = $dosimagePath;
            $this->informationData->save();
        }
        $this->doPreviousImage = $this->informationData->dos_image;
        $this->reset('dos_image');
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }

    public function removeDosImage()
    {
        $this->dos_image = null;
    }
}
