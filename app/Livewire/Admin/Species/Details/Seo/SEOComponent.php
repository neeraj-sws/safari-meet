<?php

namespace App\Livewire\Admin\Species\Details\Seo;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\Species;
use App\Models\SpeciesDetailsCharactersticModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class SEOComponent extends Component
{
    use WithFileUploads;

    public $species;

    public $characterDetails;

    public $activeTabe;

    public $isEditing = false;

    public $meta_title;

    public $meta_key;

    public $meta_description;

    public $meta_image;

    public function mount($species = null, $characterstic = null)
    {
        $this->species = $species;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'seo';
        $this->meta_title = $this->species->meta_title;
        $this->meta_key = $this->species->meta_key;
        $this->meta_description = $this->species->meta_description;
    }

    public function render()
    {
        return view('livewire.admin.species.details.seo.seo-component');
    }

    public function store()
    {
        $this->validate([
            'meta_title' => [
                'required',
                'string',
                'max:150',
            ],
            'meta_description' => [
                'required',
                'string',
                'max:500',
            ],
            'meta_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [

            'meta_title.required' => 'Meta Title is required.',
            'meta_title.string' => 'Meta Title must be a valid string.',
            'meta_title.max' => 'Meta Title cannot be longer than 60 characters.',
            'meta_title.regex' => 'Meta Title contains invalid characters or spacing. Please avoid leading, trailing, or multiple consecutive spaces.',

            'meta_description.required' => 'Meta Description is required.',
            'meta_description.string' => 'Meta Description must be a valid string.',
            'meta_description.max' => 'Meta Description cannot be longer than 500 characters.',
            'meta_description.regex' => 'Meta Description contains invalid characters or spacing. Please avoid leading, trailing, or multiple consecutive spaces.',

            'meta_image.max' => 'Meta Image must not be larger than 5MB.',
            'meta_image.mimes' => 'Only JPG, JPEG, PNG, WEBP images are allowed.',
        ]);

        $species = Species::find($this->species->id);
        $metaImagePath = $species->meta_image;
        $path = 'uploads/species/meta_image';
        if ($this->meta_image) {

            // $origImage = $this->meta_image->store($path, 'public_root');
            // $metaImagePath = ImageHelper::convertToAvif($origImage, $path);

            ImageUploadHelper::delete($metaImagePath);
            $metaImagePath = ImageUploadHelper::upload($this->meta_image, $path);
        }
        $species->update([
            'meta_title' => ucwords($this->meta_title),
            'meta_key' => $this->meta_key,
            'meta_description' => $this->meta_description,
            'meta_image' => $metaImagePath,
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'SEO Details Added Successfully']);
    }

    public function changeTab($value)
    {
        $this->activeTabe = $value;
    }

    public function toggleStatus($id)
    {
        $detailTabs = SpeciesDetailsCharactersticModel::findOrFail($id);
        $detailTabs->status = !$detailTabs->status;
        $detailTabs->save();
        $this->dispatch('species-status-updated', id: $detailTabs->id);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
}
