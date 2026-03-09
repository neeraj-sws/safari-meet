<?php

namespace App\Livewire\Admin\Seo;

use App\Helpers\ImageUploadHelper;
use App\Models\SeoPage as ModelsCategory;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component, WithPagination};
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Helpers\ImageHelper;

#[Layout('components.layouts.admin-app')]
class SeoMaster extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $itemId;
    public $title, $previousImage, $search = '';
    public $meta_title, $meta_key, $meta_description, $meta_image;
    public $isEditing = false, $isDetails = false, $DetailsData;
    public $pageTitle = 'SEO Pages';

    public $model = ModelsCategory::class;
    public $view = 'livewire.admin.seo.seo-master';



    public function rules()
    {
        $table = (new $this->model)->getTable();

        return [
            'title' => $this->isEditing
                ? 'required|string|max:255|unique:' . $table . ',title,' . $this->itemId . ',seo_pages_id'
                : 'required|string|max:255|unique:' . $table . ',title',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_image' => ($this->itemId && !empty($this->previousImage))
<<<<<<< HEAD
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:15360',
=======
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        ];
    }

    public function messages()
    {
        return [
<<<<<<< HEAD
            'meta_image.max' => 'The banner image must not be greater than 15 MB.',
=======
            'meta_image.max' => 'The banner image must not be greater than 5 MB.',
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        ];
    }

    public function render()
    {
        $items = $this->model::where('title', 'like', "%{$this->search}%")->orderBy('updated_at', 'desc')
            ->latest()->paginate(10);

        return view($this->view, compact('items'));
    }



    public function store()
    {
        $this->validate($this->rules());


        $image = $this->meta_image;
        $path = 'uploads/seo';
        // $origPath = $image->store($path, 'public_root');
        // $imagePath = ImageHelper::convertToAvif($origPath, $path);
        $imagePath = ImageUploadHelper::upload($image, $path);
        $name = $this->title;
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;
        while ($this->model::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }


        $this->model::create([
            'title' => $this->title,
            'slug' => $slug,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_image' => $imagePath,
        ]);

        $this->resetForm();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' Added Successfully'
        ]);
    }

    public function edit($id)
    {
        $this->resetForm();
        $item = $this->model::findOrFail($id);

        $this->itemId = $item->id;
        $this->title = $item->title;
        $this->meta_title = $item->meta_title;
        $this->meta_description = $item->meta_description;
        $this->previousImage = $item->meta_image;
        $this->isEditing = true;
    }

    public function details($id)
    {

        $this->DetailsData = $this->model::findOrFail($id);
        if (!empty($this->DetailsData)) {
            $this->isDetails = true;
        } else {
            $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => 'Somthings Went to Wrong',
            ]);
        }
    }

    public function update()
    {
        $this->validate($this->rules());

        if ($this->meta_image) {
            $image = $this->meta_image;
            $path = 'uploads/seo';
            // $origPath = $image->store($path, 'public_root');
            // $imagePath = ImageHelper::convertToAvif($origPath, $path);
            ImageUploadHelper::delete($this->previousImage);
            $imagePath = ImageUploadHelper::upload($image, $path);
        } else {
            $imagePath = $this->previousImage;
        }

        $item = $this->model::findOrFail($this->itemId);
        $name = $this->title;
        if ($item->title !== $name) {
            $baseSlug = Str::slug($name);
            $slug = $baseSlug;
            $counter = 1;
            while (
                $this->model::where('slug', $slug)
                    ->where('seo_pages_id', '!=', $this->itemId)
                    ->exists()
            ) {
                $slug = $baseSlug . '-' . $counter++;
            }
        } else {
            $slug = $item->slug;
        }

        $item->update([
            'title' => $this->title,
            'slug' => $slug,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_image' => $imagePath,
        ]);

        $this->resetForm();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' Updated Successfully'
        ]);
    }

    public function confirmDelete($id)
    {
        $this->itemId = $id;

        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'delete'
        ]);
    }

    #[On('delete')]
    public function delete()
    {
        $this->model::destroy($this->itemId);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' deleted successfully!'
        ]);
    }

    public function resetForm()
    {
        $this->reset([
            'title',
            'meta_title',
            'meta_key',
            'meta_description',
            'meta_image',
            'previousImage',
            'itemId',
            'isEditing'
        ]);
        $this->resetValidation();
    }


    public function removeMetaImage()
    {
        $this->meta_image = null;
    }
}
