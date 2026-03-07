<?php

namespace App\Livewire\Admin\Species\Details\Threat;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\SpeciesThreatModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class Threats extends Component
{
    use WithFileUploads;

    public $species, $characterDetails, $activeTabe, $pageTitle = 'Threats';
    public $short_description, $isEditing = false, $image, $previousImage, $theratData, $threat;

    public function mount($species = null, $characterstic = null)
    {
        $this->species = $species;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'Threats';
        $this->theratData = SpeciesThreatModel::where('species_id', $this->species->id)
            ->where('species_details_characterstics_id', $characterstic['species_details_characterstic_id'])
            ->first();
        if (!empty($this->theratData)) {
            $this->isEditing = true;
            $this->short_description = $this->theratData->short_description;
            $this->previousImage = $this->theratData->image;
            $this->threat = $this->theratData->threat;
        }
        // $this->dispatch('initializeCKEditor');
    }


    public function render()
    {
        return view('livewire.admin.species.details.threat.threats');
    }

    public function store()
    {
        $this->validate([
            'short_description' => 'required',
            'threat' => 'required',
        ], [
            'short_description.required' => 'The Threat Short Description  field is required.',
            'threat.required' => 'The Threat  field is required.',
        ]);
        $path = 'uploads/species/threat';

        if (!empty($this->theratData)) {

            if (($this->image)) {
                $this->validate([
                    'image' => 'required|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:15360',
                ], [
                    'image.required' => 'The Image field is required.',
                    'image.max'  => 'The banner image must not be greater than 5 MB.',
                ]);
                $image = $this->image;
                // $origPath = $image->store($path, 'public_root');
                // $avifPath = '';
                // $avifPath = ImageHelper::convertToAvif($origPath, $path);
                // if (!empty($this->previousImage) && file_exists(public_path($this->previousImage))) {
                    //     @unlink(public_path($this->previousImage));
                // }
                 ImageUploadHelper::delete($this->previousImage);
                $avifPath = ImageUploadHelper::upload($image, $path);
                    $imagePath = $avifPath;
            } else {
                $imagePath = $this->previousImage;
            }
            $this->theratData->image = $imagePath;
            $this->theratData->short_description = $this->short_description;
            $this->theratData->threat = $this->threat;
            $this->theratData->save();
        } else {
            $this->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:15360',

            ], [
                'image.required' => 'The Image field is required.',
                'image.max'  => 'The banner image must not be greater than 5 MB.',
            ]);
            $image = $this->image;
            // $path = 'uploads/species/threat';
            // $origPath = $image->store($path, 'public_root');
            // $avifPath = '';
            // $avifPath = ImageHelper::convertToAvif($origPath, $path);
            $avifPath = ImageUploadHelper::upload($image, $path);
            $imagePath = $avifPath;
            $this->theratData = SpeciesThreatModel::create([
                'species_id' => $this->species->id,
                'species_details_characterstics_id' => $this->characterDetails['species_details_characterstic_id'],
                'short_description' => $this->short_description,
                'image' => $imagePath,
                'threat' => $this->threat,
            ]);
        }
        $this->previousImage = $this->theratData->image;
        $this->isEditing = true;
        $this->resetValidation();
        $this->reset(['image']);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }

    public function removeOverViewImage(): void
    {
        if ($this->image) {
            $this->image->delete();
        }
        $this->image = null;
    }
}
