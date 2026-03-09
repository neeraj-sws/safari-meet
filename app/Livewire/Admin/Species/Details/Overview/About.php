<?php

namespace App\Livewire\Admin\Species\Details\Overview;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Helpers\UserHelper;
use App\Models\SpeciesOverviewModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class About extends Component
{
    use WithFileUploads;

    public $species, $characterDetails, $pageTitle = 'About';
    public $about, $isEditing = false, $overview_image, $previousImage, $overViewData;

    public function mount($species = null, $characterstic = null)
    {
        $this->species = $species;
        $this->characterDetails = $characterstic;
        $this->overViewData = SpeciesOverviewModel::where('species_id', $this->species->id)->first();
        if (!empty($this->overViewData)) {
            $this->isEditing = true;
            $this->about = $this->overViewData->about;
            $this->previousImage = $this->overViewData->about_image;
        }
    }

    public function render()
    {
        return view('livewire.admin.species.details.overview.about');
    }

    public function removeOverViewImage()
    {
        if ($this->overview_image) {
            $this->overview_image->delete();
        }
        $this->overview_image = null;
    }

    public function store()
    {
        $this->validate([
            'about' => 'required',
            'overview_image' => ($this->overViewData)
                ? 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:15360'
                : 'required|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:15360',
        ], [
            'overview_image.max' => 'The banner image must not be greater than 15 MB.',
        ]);



        $path = 'uploads/species/about';
        if (!empty($this->overViewData)) {
            if (($this->overview_image)) {
                // $image = $this->overview_image;
                // $origPath = $image->store($path, 'public_root');
                // $avifPath = '';
                // $avifPath = ImageHelper::convertToAvif($origPath, $path);

                // if (!empty($this->previousImage) && file_exists(public_path($this->previousImage))) {
                    //     @unlink(public_path($this->previousImage));
                // }

                 ImageUploadHelper::delete($this->previousImage);
                 $avifPath = ImageUploadHelper::upload($this->overview_image, $path);
                    $imagePath = $avifPath;
            } else {
                $imagePath = $this->previousImage;
            }
            $this->overViewData->about = $this->about;
            $this->overViewData->about_image = $imagePath;
            $this->overViewData->save();
        } else {
            // $image = $this->overview_image;
            // $path = 'uploads/species';
            // $origPath = $image->store($path, 'public_root');
            // $avifPath = '';
            // $avifPath = ImageHelper::convertToAvif($origPath, $path);
            $imagePath = ImageUploadHelper::upload($this->overview_image, $path);;
            $this->overViewData =  SpeciesOverviewModel::create([
                'species_id' => $this->species->id,
                'species_details_characterstics_id' => $this->characterDetails['species_details_characterstic_id'],
                'about' => $this->about,
                'about_image' => $imagePath,

            ]);
        }
        $this->reset(['overview_image']);
        $this->overViewData = SpeciesOverviewModel::where('species_id', $this->species->id)
            ->where('species_details_characterstics_id', $this->characterDetails['species_details_characterstic_id'])
            ->first();
        if (!empty($this->overViewData)) {
            $this->isEditing = true;
            $this->about = $this->overViewData->about;
            $this->previousImage = $this->overViewData->about_image;
        }
        $this->reset(['overview_image']);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
        //   dd($this->textEditor );
    }
}
