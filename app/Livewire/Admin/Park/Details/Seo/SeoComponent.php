<?php

namespace App\Livewire\Admin\Park\Details\Seo;

use App\Helpers\ImageUploadHelper;
use App\Models\ParkDetailsTabs;
use App\Models\ParkTabs;
use Livewire\Component;
use App\Helpers\ImageHelper;
use Livewire\WithFileUploads;

class SeoComponent extends Component
{
    use WithFileUploads;

    public $park, $characterstic;
    public $short_description;
    public $pageTitle = '';
    public $existingFact, $activeTabe;
    public $isEditing = false, $meta_title, $meta_key, $meta_description;
    public $meta_image;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterstic = $characterstic;
        if (!empty($this->characterstic)) {
            $tab = ParkTabs::find($this->characterstic['park_tabs_id']);
            $this->pageTitle = $tab?->title;
        }
        $this->activeTabe = 'overview';
        $this->meta_title = $this->park->meta_title ?? '';
        $this->meta_description = $this->park->meta_description ?? '';
    }

    public function render()
    {
        return view('livewire.admin.park.details.seo.seo-component');
    }

    public function store()
    {
        $this->validate([
            'meta_title' => [
                'required',
                'string',
                'max:100',
            ],
            'meta_description' => [
                'required',
                'string',
                'max:500',
            ],
<<<<<<< HEAD
            'meta_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',
=======
            'meta_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        ], [

            'meta_title.required' => 'Meta Title is required.',
            'meta_title.string' => 'Meta Title must be a valid string.',
            'meta_title.max' => 'Meta Title cannot be longer than 100 characters.',
            'meta_title.regex' => 'Meta Title contains invalid characters or spacing. Please avoid leading, trailing, or multiple consecutive spaces.',

            'meta_description.required' => 'Meta Description is required.',
            'meta_description.string' => 'Meta Description must be a valid string.',
            'meta_description.max' => 'Meta Description cannot be longer than 500 characters.',
            'meta_description.regex' => 'Meta Description contains invalid characters or spacing. Please avoid leading, trailing, or multiple consecutive spaces.',

<<<<<<< HEAD
            'meta_image.max' => 'Meta Image must not be larger than 15 MB.',
=======
            'meta_image.max' => 'Meta Image must not be larger than 5MB.',
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            'meta_image.mimes' => 'Only JPG, JPEG, PNG, WEBP images are allowed.',
        ]);

        $metaImagePath = $this->park->meta_image;
        $path = 'uploads/park/meta';
        if ($this->meta_image) {

            // $origImage = $this->meta_image->store($path, 'public_root');
            // $metaImagePath = ImageHelper::convertToAvif($origImage, $path);
            ImageUploadHelper::delete($this->park->meta_image);
            $metaImagePath = ImageUploadHelper::upload($this->meta_image, $path);
        }

        $this->park->update([
            'meta_title' => $this->meta_title,
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
        $detailTabs = ParkDetailsTabs::findOrFail($id);
        $detailTabs->status = !$detailTabs->status;
        $detailTabs->save();
        $this->dispatch('status-updated', id: $detailTabs->id);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
}
