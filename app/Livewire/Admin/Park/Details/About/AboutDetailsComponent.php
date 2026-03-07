<?php

namespace App\Livewire\Admin\Park\Details\About;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\ParkAboutSection;
use App\Models\ParkAboutSectionDetail;
use Livewire\Component;
use Livewire\WithFileUploads;

class AboutDetailsComponent extends Component
{
    use WithFileUploads;

    public $showAboutModal = false, $isEditing = false;
    public $modalTitle, $heading, $aboutImage, $previousImage, $description;
    public $park, $aboutData = [], $aboutId;

    public function mount($park = null)
    {
        $this->park = $park;
    }

    public function render()
    {
        $this->aboutData = ParkAboutSection::where('park_id', $this->park?->id)->get();
        return view('livewire.admin.park.details.about.about-details-component');
    }

    public function addAbout()
    {
        $this->resetValidation();
        $this->reset(['heading', 'aboutId', 'aboutImage', 'previousImage', 'description']);
        $this->showAboutModal = true;
        $this->modalTitle = "Add About";
        // $this->dispatch('initializeCKEditor');
    }

    public function deleteAbout($id)
    {
        ParkAboutSection::findOrFail($id)->delete();
        $this->refreshData();
    }


    public function editAbout($id)
    {
        $about = ParkAboutSection::findOrFail($id);

        $this->resetValidation();

        $this->modalTitle = "Edit About";
        $this->showAboutModal = true;
        $this->heading = $about->title;
        $this->aboutId = $id;
        $this->isEditing = true;
        $this->previousImage = $about->image;
        $this->description = $about?->short_description;
        $this->dispatch('initializeCKEditor');
    }

    public function saveAbout()
    {
        $rules = [
            'heading' => [
                'required',
                'string',
                'min:3',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        return $fail('The heading cannot have leading or trailing spaces.');
                    }
                },
            ],
            'aboutImage' => ($this->isEditing
                ? 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:15360'
                : 'required|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:15360'),
            'description' => 'required',
        ];

        $messages = [
            'heading.required' => 'The heading is required.',
            'heading.string' => 'The heading must be a valid string.',
            'heading.min' => 'The heading must be at least 3 characters long.',
            'heading.max' => 'The heading may not be greater than 100 characters.',
            'heading.regex' => 'The heading may only contain letters and single spaces between words.',

            'aboutImage.required' => 'The image is required.',
            'aboutImage.max'  => 'The banner image must not be greater than 5 MB.',
            'description.required' => 'The description is required.',
        ];

        $this->validate($rules, $messages);

        $imagePath = $this->previousImage;

        if ($this->aboutImage) {
            // $origPath = $this->aboutImage->store('uploads/park/about', 'public_root');
            // $imagePath = ImageHelper::convertToAvif($origPath, 'uploads/park/about');

            // if (!empty($this->previousImage) && file_exists(public_path($this->previousImage))) {
            //     @unlink(public_path($this->previousImage));
            // }

            ImageUploadHelper::delete($this->previousImage);
            $imagePath = ImageUploadHelper::upload($this->aboutImage, 'uploads/park/about');
        }

        if ($this->aboutId) {
            $about = ParkAboutSection::findOrFail($this->aboutId);
            $about->update([
                'title' => ucwords($this->heading),
                'image' => $imagePath,
                'short_description' => $this->description,
            ]);
        } else {
            $about = ParkAboutSection::create([
                'park_id' => $this->park?->id,
                'title' => ucwords($this->heading),
                'image' => $imagePath,
                'short_description' => $this->description,
            ]);
        }


        $this->reset(['heading', 'description', 'aboutImage', 'previousImage', 'showAboutModal', 'aboutId', 'isEditing']);
        $this->refreshData();
    }

    public function removeAboutImage()
    {
        $this->aboutImage = null;
        $this->previousImage = null;
    }

    public function refreshData()
    {
        $this->aboutData = ParkAboutSection::where('park_id', $this->park?->id)->get();
    }
}
