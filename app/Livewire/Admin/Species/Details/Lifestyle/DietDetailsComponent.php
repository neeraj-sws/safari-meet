<?php

namespace App\Livewire\Admin\Species\Details\Lifestyle;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Helpers\UserHelper;
use App\Models\DietDetailsModel;
use App\Models\DietModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class DietDetailsComponent extends Component
{
    use WithFileUploads;

    public $showDietModal = false, $isEditing = false;
    public $modalTitle, $heading, $dietDetails = [], $dietImage, $previousImage;
    public $speciesId, $dietData = [], $dietId, $description;
    public $species, $characterDetails, $pageTitle = "Diet";

    public function mount($species = null, $characterstic = null)
    {
        $this->species = $species;
        $this->speciesId = $this->species->id;
        $this->characterDetails = $characterstic;
    }

    public function render()
    {
        $this->dietData = DietModel::where('species_id', $this->speciesId)->get();
        return view('livewire.admin.species.details.lifestyle.diet-details');
    }

    public function addDiet()
    {
        $this->resetValidation();
        $this->reset(['heading', 'dietDetails', 'dietId', 'dietImage', 'previousImage', 'description']);
        $this->showDietModal = true;
        $this->modalTitle = "Add Diet Details";
        $this->dispatch('initializeCKEditor');
    }

    public function removeDetail($index)
    {
        unset($this->dietDetails[$index]);
        $this->dietDetails = array_values($this->dietDetails);
    }

    public function deleteDiet($id)
    {
        DietModel::findOrFail($id)->delete();
        $this->dietData = DietModel::where('species_id', $this->speciesId)->get();
    }

    public function deleteDietDetail($id)
    {
        $this->dietData = DietModel::where('species_id', $this->speciesId)->get();
    }

    public function editDiet($id)
    {
        $this->showDietModal = false;
        $diet = DietModel::findOrFail($id);
        $this->resetValidation();
        $this->reset(['heading', 'dietDetails', 'dietId', 'dietImage', 'previousImage', 'description']);
        $this->dietDetails = [];
        $this->modalTitle = "Add Diet Details";
        $this->showDietModal = true;
        $this->heading = $diet->title;
        $this->dietId = $id;
        $this->isEditing = true;
        $this->previousImage = $diet->image;
        $this->description = $diet?->short_description;
        $this->dispatch('initializeCKEditor');
    }

    public function saveDiet()
    {

        $rules = [
            'heading' => [
                'required',
                'string',
                'min:3',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Heading cannot have leading or trailing spaces.');
                    }
                },
            ],
            'dietImage' => ($this->isEditing)
                ? 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:15360'
                : 'required|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:15360',
            'description' => 'required|string',
        ];
        $messages = [

            'heading.required' => 'Heading is required.',
            'heading.string' => 'Heading must be a valid string.',
            'heading.min' => 'Heading must be at least 3 characters.',
            'heading.max' => 'Heading may not be greater than 100 characters.',
            'heading.regex' => 'Heading can only contain letters and single spaces between words.',

            'dietImage.required' => 'The diet image is required.',
            'dietImage.image' => 'The diet image must be a valid image file (jpg, png, etc.).',
            'dietImage.max' => 'The display image must not be greater than 5 MB.',

            'description.required' => 'The Diet Details is required.',
            'description.string' => 'The Diet Details must be a string.',
        ];

        $this->validate($rules, $messages);


        $imagePath = $this->previousImage;

        if ($this->dietImage) {
            // $origPath = $this->dietImage->store('uploads/species/lifestyle', 'public_root');
            // $imagePath = ImageHelper::convertToAvif($origPath, 'uploads/species/lifestyle');

            // if (!empty($this->previousImage) && file_exists(public_path($this->previousImage))) {
            //     @unlink(public_path($this->previousImage));
            // }

            ImageUploadHelper::delete($this->previousImage);
            $imagePath = ImageUploadHelper::upload($this->dietImage, 'uploads/species/lifestyle');
        }

        if ($this->dietId) {
            $diet = DietModel::findOrFail($this->dietId);
            $diet->update([
                'title' => $this->heading,
                'image' => $imagePath,
                'short_description' => $this->description,
            ]);
        } else {
            $diet = DietModel::create([
                'species_id' => $this->speciesId,
                'title' => $this->heading,
                'image' => $imagePath,
                'short_description' => $this->description,
            ]);
        }

        $this->reset(['heading', 'description', 'dietImage', 'previousImage', 'showDietModal', 'dietId', 'isEditing']);
    }

    public function removeDietImage()
    {
        $this->dietImage = null;
        $this->previousImage = null;
    }
}
