<?php

namespace App\Livewire\Admin;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\ThingsToCarry as ModelsCategory;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component, WithFileUploads, WithPagination};
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

#[Layout('components.layouts.admin-app')]
class ThingToCarries extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $itemId;
    public $title, $short_description, $search = '', $display_image, $previousImage;
    public $isEditing = false;
    public $pageTitle = 'Things To Carries';

    public $model = ModelsCategory::class;
    public $view = 'livewire.admin.things-to-carry';



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
                ? [Rule::unique($table, 'title')->ignore($this->itemId, 'things_to_carry_id')]
                : [Rule::unique($table, 'title')]
            ),
            'short_description' => 'required',
            'display_image' => ($this->itemId && !empty($this->previousImage))
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
            'display_image.max' => 'The display image must not be greater than 5 MB.',
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
        // $origPath = $this->display_image->store('uploads/thing-to-carry', 'public_root');
        // $imagePath = ImageHelper::convertToAvif($origPath, 'uploads/thing-to-carry');
        $imagePath = ImageUploadHelper::upload($this->display_image, 'uploads/thing-to-carry');
        $this->model::create([
            'title' => $this->title,
            'short_description' => $this->short_description,
            'image' => $imagePath,
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
        $this->short_description = $item->short_description;
        $this->isEditing = true;
        $this->previousImage = $item->image;
    }

    public function update()
    {
        $this->validate($this->rules());

        if ($this->display_image) {
            // $origPath = $this->display_image->store('uploads/thing-to-carry', 'public_root');
            // $imagePath = ImageHelper::convertToAvif($origPath, 'uploads/thing-to-carry');
            ImageUploadHelper::delete($this->previousImage);
            $imagePath = ImageUploadHelper::upload($this->display_image, 'uploads/thing-to-carry');
        } else {
            $imagePath = $this->previousImage;
        }
        $this->model::findOrFail($this->itemId)->update([
            'title' => $this->title,
            'short_description' => $this->short_description,
            'image' => $imagePath,
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
        $this->reset(['title', 'short_description', 'itemId', 'isEditing', 'display_image']);
        $this->resetValidation();
    }

    public function removeDisplayImage(): void
    {
        $this->display_image = null;
    }

    public function updating()
    {
        $this->resetPage();
    }
}
