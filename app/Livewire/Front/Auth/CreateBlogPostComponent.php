<?php

namespace App\Livewire\Front\Auth;

use App\Helpers\ImageHelper;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\MediaPost;
use App\Models\Park;
use Illuminate\Support\Facades\Auth;

class CreateBlogPostComponent extends Component
{
    use WithFileUploads;

    public $image, $video, $content, $posts;
    public $editingPostId = null, $existingMedia = null, $type_of_media, $parks = [], $park;

    public function mount()
    {
        $this->parks = Park::where('status', 1)->pluck('name', 'park_id')->toArray();
        $this->loadPosts();
    }

    public function render()
    {
        return view('livewire.front.auth.create-blog-post-component');
    }

    public function loadPosts()
    {
        $this->posts = MediaPost::where('user_id', Auth::id())->with(['user', 'adminUser', 'park'])
            ->latest()
            ->get();
    }

    public function rules()
    {
        $rules = [
            'type_of_media' => 'required|in:image,video',
            'content' => 'nullable|string|max:1000',
            'park' => 'required|exists:parks,park_id',
        ];

        // File validation rules
        if (!$this->editingPostId) {
            if ($this->type_of_media === 'image') {
                $rules['image'] = 'required|mimes:jpg,jpeg,png,webp|max:10240'; // 10MB
            } elseif ($this->type_of_media === 'video') {
                $rules['video'] = 'required|mimes:mp4,mov,avi,mkv,flv,webm|max:51200'; // 50MB
            }
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        $path = 'uploads/social/posts';
        $mediaPath = '';

        if ($this->editingPostId) {
            // Update
            $post = MediaPost::find($this->editingPostId);
            if (!$post) return;

            if ($this->type_of_media === 'image' && $this->image) {
                $imagePath = $this->image->store("$path/images", 'public_root');
                $mediaPath = ImageHelper::convertToAvif($imagePath, "$path/images");
            } elseif ($this->type_of_media === 'video' && $this->video) {
                $mediaPath = $this->video->store("$path/videos", 'public_root');
            } else {
                $mediaPath = $post->media_url;
            }

            $post->update([
                'caption' => $this->content,
                'media_url' => $mediaPath,
                'type' => $this->type_of_media,
                'park_id' => $this->park,
            ]);

            $msg = 'Media updated successfully!';
        } else {
            // Create
            if ($this->type_of_media === 'image') {
                $imagePath = $this->image->store("$path/images", 'public_root');
                $mediaPath = ImageHelper::convertToAvif($imagePath, "$path/images");
            } elseif ($this->type_of_media === 'video') {
                $mediaPath = $this->video->store("$path/videos", 'public_root');
            }

            MediaPost::create([
                'user_id' => Auth::id(),
                'user_type' => 'user',
                'media_url' => $mediaPath,
                'caption' => $this->content,
                'type' => $this->type_of_media,
                'park_id' => $this->park,
                'visibility' => 'public',
            ]);

            $msg = 'Media created successfully!';
        }

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => $msg,
        ]);

        $this->reset(['image', 'video', 'content', 'editingPostId', 'existingMedia', 'type_of_media','park']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->loadPosts();
    }


    public function edit($id)
    {
        $post = MediaPost::find($id);
        if ($post) {
            $this->editingPostId = $id;
            $this->content = $post->caption;
            $this->type_of_media = $post->type;
            $this->existingMedia = $post->media_url;
        }
    }

    public function delete($id)
    {
        $post = MediaPost::find($id);
        if ($post) {
            $post->delete();
            $this->dispatch('swal:toast', [
                'type' => 'success',
                'message' => 'Blog deleted successfully!',
            ]);
            $this->loadPosts();
        }
    }
}
