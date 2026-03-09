<?php

namespace App\Livewire\Admin\Social;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\MediaPost as Model;
use App\Models\Park;

#[Layout('components.layouts.admin-app')]
class MediaPost extends Component
{
    use WithPagination, WithFileUploads;

    public $type_of_media, $caption, $image, $video;
    public $isEditing = false, $itemId;
    public $pageTitle = 'Social Post';
    public $previewUrl = null, $show_preview = false;
    public $parks = [], $park;
    public $model = Model::class;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->parks = Park::where('status', 1)->pluck('name', 'park_id')->toArray();
    }

    public function render()
    {
        $items = $this->model::with(['user', 'adminUser', 'park'])
            ->latest()
            ->paginate(10);
        return view('livewire.admin.social.media-post', compact('items'));
    }

    protected function rules()
    {
        $rules = [
            'type_of_media' => 'required|in:image,video',
            'caption' => 'nullable|string|max:1000',
            'park' => 'required|exists:parks,park_id',
        ];

        if (!$this->isEditing) {
            if ($this->type_of_media === 'image') {
<<<<<<< HEAD
                $rules['image'] = 'required|mimes:jpg,jpeg,png,webp,avif|max:15360';
            } elseif ($this->type_of_media === 'video') {
                $rules['video'] = 'required|mimes:mp4,mov,avi,mkv,flv,webm|max:15360';
=======
                $rules['image'] = 'required|mimes:jpg,jpeg,png,webp,avif|max:10240';
            } elseif ($this->type_of_media === 'video') {
                $rules['video'] = 'required|mimes:mp4,mov,avi,mkv,flv,webm|max:51200';
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            }
        }

        return $rules;
    }

    public function store()
    {
        $this->validate();

        $path = 'uploads/social/posts';
        $mediaPath = '';

        if ($this->type_of_media === 'image' && $this->image) {
            // $imagePath = $this->image->store("$path/images", 'public_root');
            // $mediaPath = ImageHelper::convertToAvif($imagePath, "$path/images");
            $mediaPath = ImageUploadHelper::upload($this->image, $path.'/images');
        } elseif ($this->type_of_media === 'video' && $this->video) {
            $mediaPath = $this->video->store("$path/videos", 'public_root');
        }

        $this->model::create([
            'user_id' => Auth::guard('admin')->id(),
            'user_type' => 'admin',
            'media_url' => $mediaPath,
            'caption' => $this->caption,
            'type' => $this->type_of_media,
            'park_id' => $this->park,
            'visibility' => 'public',
        ]);

        $this->resetForm();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => "{$this->pageTitle} Added Successfully!",
        ]);
    }

    public function edit($id)
    {
        $this->resetForm();
        $item = $this->model::findOrFail($id);

        $this->itemId = $item->id;
        $this->type_of_media = $item->type;
        $this->caption = $item->caption;
        $this->park = $item->park_id;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        $item = $this->model::findOrFail($this->itemId);

        $path = 'uploads/social/posts';
        $mediaPath = $item->media_url;

        if ($this->type_of_media === 'image' && $this->image) {
            $imagePath = $this->image->store("$path/images", 'public_root');
            $mediaPath = ImageHelper::convertToAvif($imagePath, "$path/images");
        } elseif ($this->type_of_media === 'video' && $this->video) {
            $mediaPath = $this->video->store("$path/videos", 'public_root');
        }

        $item->update([
            'caption' => $this->caption,
            'media_url' => $mediaPath,
            'type' => $this->type_of_media,
            'park_id' => $this->park,
        ]);

        $this->resetForm();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => "{$this->pageTitle} Updated Successfully!",
        ]);
    }

    public function confirmDelete($id)
    {
        $this->itemId = $id;

        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'icon' => 'warning',
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'delete',
        ]);
    }

    #[On('delete')]
    public function delete()
    {
        $this->model::destroy($this->itemId);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => "{$this->pageTitle} Deleted Successfully!",
        ]);
    }

    public function showPreview($url)
    {
        $this->previewUrl = asset($url);
        $this->show_preview = true;
    }

    public function closePreview()
    {
        $this->show_preview = false;
        $this->previewUrl = null;
    }

    public function resetForm()
    {
        $this->reset(['type_of_media', 'image', 'video', 'caption', 'isEditing', 'itemId', 'park']);
        $this->resetValidation();
    }
}
