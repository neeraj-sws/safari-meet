<?php

namespace App\Livewire\Admin;

use App\Helpers\ImageUploadHelper;
use App\Models\ReachabilityMode as ModelsCategory;
use App\Models\ParkReachability;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component, WithPagination};
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Helpers\ImageHelper;

#[Layout('components.layouts.admin-app')]
class ReachabilityModes extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $itemId;
    public $title, $previousImage, $display_image, $search = '';
    public $isEditing = false;
    public $pageTitle = 'Reachability Modes';

    public $model = ModelsCategory::class;
    public $view = 'livewire.admin.reachability-modes';



    public function rules()
    {
        $table = (new $this->model)->getTable();

        return [
            'title' => array_merge(
                [
                    'required',
                    'string',
                    'max:50',
                    function ($attribute, $value, $fail) {
                        if (trim($value) !== $value) {
                            $fail('Title cannot have leading or trailing spaces.');
                        }
                    }
                ],
                $this->isEditing
                ? [Rule::unique($table, 'title')->ignore($this->itemId, 'reachability_modes_id')]
                : [Rule::unique($table, 'title')]
            ),
            'display_image' => ($this->itemId && !empty($this->previousImage))
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:15360',
        ];
    }

    public function messages()
    {
        return [
            'display_image.max' => 'The banner image must not be greater than 5 MB.',
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


        $image = $this->display_image;
        $path = 'uploads/reachability';
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
            'display_image' => $imagePath,
            'status' => true,
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
        $this->previousImage = $item->display_image;
        $this->isEditing = true;

        $this->dispatch('initializeIconPicker');
    }

    public function update()
    {
        $this->validate($this->rules());

        if ($this->display_image) {
            $image = $this->display_image;
            $path = 'uploads/reachability';
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
                    ->where('id', '!=', $this->itemId)
                    ->exists()
            ) {
                $slug = $baseSlug . '-' . $counter++;
            }
        } else {
            $slug = $item->slug;
        }

        $item->update([
            'title' => $this->title,
            'display_image' => $imagePath,
            'slug' => $slug,
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

        $isUsedInParkReachability = ParkReachability::where('reachability_id', $this->itemId)->exists();

        if ($isUsedInParkReachability) {
            // Show an error message instead of deleting
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => 'Cannot delete. This item is used in Park Reachability.'
            ]);
            return;
        }

        $this->model::destroy($this->itemId);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' deleted successfully!'
        ]);
    }

    public function resetForm()
    {
        $this->reset(['title', 'display_image', 'itemId', 'isEditing']);
        $this->resetValidation();
    }


    public function removeDisplayImage(): void
    {
        if ($this->display_image) {
            $this->display_image->delete();
        }
        $this->display_image = null;
    }

    public function toggleStatus($id)
    {
        $habitat = $this->model::findOrFail($id);
        $habitat->status = !$habitat->status;
        $habitat->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
}
