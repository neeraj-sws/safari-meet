<?php

namespace App\Livewire\Admin\Package\Details;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\Package;
use App\Models\PackageDetailsTabs;
use Livewire\Component;
use Livewire\WithFileUploads;

class SeoComponent extends Component
{
    use WithFileUploads;

    public $package;
    public $characterstic;

    public $meta_title;
    public $meta_key;
    public $meta_description;
    public $meta_image;

    public $pageTitle = '';
    public $activeTabe = 'seo';
    public $isEditing = false;

    public function mount($package = null, $characterstic = null)
    {
        $this->package = $package;
        $this->characterstic = $characterstic;

        $this->meta_title = $this->package->meta_title ?? '';
        $this->meta_key = $this->package->meta_key ?? '';
        $this->meta_description = $this->package->meta_description ?? '';
    }

    public function render()
    {
        return view('livewire.admin.package.details.seo-component');
    }

    public function store()
    {
        $this->validate([
            'meta_title' => 'required|string|max:100',
            'meta_description' => 'required|string|max:500',
            'meta_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'meta_title.required' => 'Meta Title is required.',
            'meta_title.max' => 'Meta Title cannot be longer than 100 characters.',

            'meta_description.required' => 'Meta Description is required.',
            'meta_description.max' => 'Meta Description cannot be longer than 500 characters.',

            'meta_image.max' => 'Meta Image must not be larger than 5MB.',
            'meta_image.mimes' => 'Only JPG, JPEG, PNG, WEBP images are allowed.',
        ]);

        $metaImagePath = $this->package->meta_image;

        if ($this->meta_image) {
            $path = 'uploads/package/meta';

            ImageUploadHelper::delete($this->package->meta_image);
            $metaImagePath = ImageUploadHelper::upload($this->banner_image, $path);

            // $origImage = $this->meta_image->store($path, 'public_root');
            // $metaImagePath = ImageHelper::convertToAvif($origImage, $path);
        }

        $this->package->update([
            'meta_title' => $this->meta_title,
            'meta_key' => $this->meta_key,
            'meta_description' => $this->meta_description,
            'meta_image' => $metaImagePath,
        ]);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'SEO Details Saved Successfully'
        ]);
    }

    public function changeTab($value)
    {
        $this->activeTabe = $value;
    }
}
