<?php

namespace App\Livewire\Admin;

use App\Helpers\ImageUploadHelper;
use App\Models\Species;
use App\Helpers\ImageHelper;
use App\Models\HomePageBannerModel as homeBennerModel;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class HomePageBanner extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $isEditing = false, $itemId, $deleteId, $previousImage, $display_image;
    public $pageTitle = 'Home Page Banner';
    public $search = '';
    public $title;

    public $model = homeBennerModel::class;
    public $view = 'livewire.admin.home-page-banner';

    public function rules()
    {
        return [
            'title' => 'required|string',
            'display_image' => ($this->itemId && !empty($this->previousImage))
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title likhna zaroori hai.',
            'display_image.required' => 'Image upload karna zaroori hai.',
            'display_image.image' => 'Sirf image files allowed hain.',
            'display_image.mimes' => 'Image type jpg, jpeg, png ya webp hi hona chahiye.',
            'display_image.max' => 'Image size 2 MB se zyada nahi ho sakti.',
        ];
    }


    public function render()
    {
        $species = $this->model::where('title', 'like', "%{$this->search}%")->orderBy('updated_at', 'desc')
            ->latest()->paginate(10);
        return view($this->view, compact('species'));
    }

    public function resetFilter()
    {
        $this->reset(['search']);
    }

    public function store()
    {
        $this->validate();

        $image = $this->display_image;
        $path = 'uploads/home/banner/';
        // $origPath = $image->store($path, 'public_root');

        // $avifPath = '';
        // $avifPath = ImageHelper::convertToAvif($origPath, $path);
        $avifPath = ImageUploadHelper::upload($image, $path);
        $imagePath = $avifPath;
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
            'display_image' => $imagePath,
            'status' => true,
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);

        $this->resetValidation();
        $this->resetFields();
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->resetFields();
        $species = $this->model::findOrFail($id);

        $this->title = $species->title;
        $this->previousImage = $species->display_image;

        $this->itemId = $species->id;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate($this->rules());
        $species = $this->model::findOrFail($this->itemId);
        if (($this->display_image)) {
            $image = $this->display_image;
            $path = 'uploads/sharesafarie';
            // $origPath = $image->store($path, 'public_root');

            // $avifPath = '';
            // $avifPath = ImageHelper::convertToAvif($origPath, $path);
            ImageUploadHelper::delete($this->previousImage);
            $avifPath = ImageUploadHelper::upload($image, $path);
            $imagePath = $avifPath;
        } else {
            $imagePath = $this->previousImage;
        }
        $name = $this->title;
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;
        while ($this->model::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }


        $species->update([
            'title' => $this->title,
            'slug' => $slug,
            'display_image' => $imagePath,
        ]);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Updated Successfully']);
        $this->isEditing = false;
        $this->resetValidation();
        $this->resetFields();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
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
        $this->model::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->reset(
            'title',
            'itemId',
            'display_image',
            'previousImage',
            'deleteId'
        );
    }
    public function toggleStatus($id)
    {
        $species = $this->model::findOrFail($id);
        $species->status = !$species->status;
        $species->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
    public function updating()
    {
        $this->resetPage();
    }


    public function removeDisplayImage(): void
    {
        if ($this->display_image) {
            $this->display_image->delete();
        }
        $this->display_image = null;
    }
}
