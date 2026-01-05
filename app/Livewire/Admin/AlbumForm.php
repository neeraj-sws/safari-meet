<?php
namespace App\Livewire\Admin;

use App\Helpers\ImageHelper;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\{Album, AlbumCategory, Tag, AlbumImage, Upload};
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class AlbumForm extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $showModal = false, $isEditing = false, $deleteId;
    public $modalTitle = 'Add', $pageTitle = 'Album ';
    public $search = '';
    public $albumId;
    public $title, $description, $cover_image, $existingCover;
    public $category_id;
    public $tags = [];
    public $new_images = [], $update_new_images = [];
    public $categories, $tagsList;
    public $filter_category, $filter_tag, $filter_tag_temp, $filter_category_temp;

    public $viewModal = false, $albumImages, $addAlbumImgId;

    public function mount()
    {
        $this->albumImages = collect();
        $this->categories = AlbumCategory::pluck('name', 'id');
        $this->tagsList = Tag::pluck('name', 'id');
    }
    public function render()
    {
        $albums = Album::with('category')->where('title', 'like', "%{$this->search}%");

        if (isset($this->filter_category_temp) && !empty($this->filter_category_temp)) {
            $albums->where('category_id', $this->filter_category_temp);
        }
        if (!empty($this->filter_tag_temp)) {
            $albums->whereHas('tags', function ($query) {
                $query->where('tags.id', $this->filter_tag_temp);
            });
        }

        $albums = $albums->latest()->paginate(10);
        return view('livewire.admin.album-form', compact('albums'));
    }
    public function applyFilter()
    {
        $this->filter_tag_temp = $this->filter_tag;
        $this->filter_category_temp = $this->filter_category;
    }
    public function resetFilter()
    {
        $this->reset(['search', 'filter_category', 'filter_tag', 'filter_tag_temp', 'filter_category_temp']);
    }
    public function resetFields()
    {
        $this->reset([
            'title',
            'description',
            'category_id',
            'cover_image',
            'new_images',
            'albumId',
            'isEditing',
            'modalTitle',
            'existingCover',
            'tags'
        ]);
    }

    public function openModal()
    {
        $this->resetFields();
        $this->resetValidation();
        $this->modalTitle = 'Add ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function submit()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'required',
            'category_id' => 'required|exists:album_categories,id',
            'cover_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'new_images' => 'required|array',
            'new_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'new_images.required' => 'The images field is required.',
            'new_images.*.image' => 'Each file must be an image.',
            'new_images.*.mimes' => 'Images must be of type: jpg, jpeg, png, webp.',
            'new_images.*.max' => 'Each image must not exceed 2MB.',
        ]);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->category_id,
        ];

        if ($this->cover_image) {
            $image = $this->cover_image;
            $path = 'uploads/albums/covers';
            $origPath = $image->store($path, 'public_root');

            $avifPath = '';
            $avifPath = ImageHelper::convertToAvif($origPath, $path);

            $upload = Upload::create([
                'original_name' => $image->getClientOriginalName(),
                'avif_path' => $avifPath,
            ]);

            $data['cover_image'] = $avifPath;
            $data['upload_id'] = $upload->id;

        } elseif ($this->existingCover) {
            $data['cover_image'] = $this->existingCover;
        }

        $album = Album::updateOrCreate(['id' => $this->albumId], $data);

        $album->tags()->sync($this->tags);

        foreach ($this->new_images as $img) {

            $image = $img;
            $path = 'uploads/albums/gallery';
            $origPath = $image->store($path, 'public_root');

            $avifPath = '';
            $avifPath = ImageHelper::convertToAvif($origPath, $path);

            $upload = Upload::create([
                'original_name' => $image->getClientOriginalName(),
                'avif_path' => $avifPath,
            ]);

            $imagPath = $avifPath;

            AlbumImage::create([
                'album_id' => $album->id,
                'image_path' => $imagPath,
                'upload_id' => $upload->id,
            ]);
        }

        $this->resetFields();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
        $this->showModal = false;

    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->resetFields();

        $album = Album::with('tags', 'images')->findOrFail($id);
        $this->title = $album->title;
        $this->description = $album->description;
        $this->category_id = $album->category_id;
        $this->existingCover = $album->cover_image;
        $this->tags = $album->tags->pluck('id')->toArray();

        $this->albumId = $album->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'required',
            'category_id' => 'required|exists:album_categories,id',
            'cover_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->category_id,
        ];

        if ($this->cover_image) {
            $image = $this->cover_image;
            $path = 'uploads/albums/covers';
            $origPath = $image->store($path, 'public_root');

            $avifPath = '';
            $avifPath = ImageHelper::convertToAvif($origPath, $path);

            $upload = Upload::create([
                'original_name' => $image->getClientOriginalName(),
                'avif_path' => $avifPath,
            ]);

            $data['upload_id'] = $upload->id;
            $data['cover_image'] = $avifPath;
        } elseif ($this->existingCover) {
            $data['cover_image'] = $this->existingCover;
        }

        $album = Album::updateOrCreate(['id' => $this->albumId], $data);

        $album->tags()->sync($this->tags);

        $this->resetFields();
        $this->showModal = false;
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Updated Successfully']);
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
        Album::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }
    public function updating()
    {
        $this->resetPage();
    }

    public function viewImages($id)
    {
        $this->reset('albumImages');
        $this->albumImages = AlbumImage::where('album_id', $id)->pluck('image_path', 'id');
        $this->addAlbumImgId = $id;
        $this->modalTitle = 'View ' . $this->pageTitle . ' Images';
        $this->viewModal = true;
    }

    public function confirmAlbumDelete($id)
    {
        $this->reset('deleteId');
        $this->deleteId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'deleteAlbumImage'
        ]);
    }

    #[On('deleteAlbumImage')]
    public function deleteAlbumImage()
    {
        AlbumImage::destroy($this->deleteId);
        $this->albumImages->forget($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Album image removed successfully!']);
    }

    public function addImages()
    {
        $this->validate([
            'update_new_images' => 'required|array',
            'update_new_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'update_new_images.required' => 'The images field is required.',
            'update_new_images.*.image' => 'Each file must be an image.',
            'update_new_images.*.mimes' => 'Images must be of type: jpg, jpeg, png, webp.',
            'update_new_images.*.max' => 'Each image must not exceed 2MB.',
        ]);
        foreach ($this->update_new_images as $img) {
            $image = $img;
            $path = 'uploads/albums/gallery';
            $origPath = $image->store($path, 'public_root');

            $avifPath = '';
            $avifPath = ImageHelper::convertToAvif($origPath, $path);

            $upload = Upload::create([
                'original_name' => $image->getClientOriginalName(),
                'avif_path' => $avifPath,
            ]);

            $imagPath = $avifPath;

            AlbumImage::create([
                'album_id' => $this->addAlbumImgId,
                'image_path' => $imagPath,
                'upload_id' => $upload->id,
            ]);
        }

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Album image added successfully!']);
        $this->albumImages = AlbumImage::where('album_id', $this->addAlbumImgId)->pluck('image_path', 'id');
        $this->reset('update_new_images');
    }

    public function removeCoverImage()
    {
        $this->cover_image = null;
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Preview image removed successfully!']);
    }
    public function removeNewImage(int $index): void
    {
        
        if (isset($this->new_images[$index])) {
            $this->new_images[$index]->delete();
            unset($this->new_images[$index]);
        
            $this->new_images = array_values($this->new_images);
        }
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Preview image removed successfully!']);
    }
    public function removealbumImage(int $index): void
    {
        
        if (isset($this->update_new_images[$index])) {
            $this->update_new_images[$index]->delete();
            unset($this->update_new_images[$index]);
        
            $this->update_new_images = array_values($this->update_new_images);
        }
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Preview image removed successfully!']);
    }
}
