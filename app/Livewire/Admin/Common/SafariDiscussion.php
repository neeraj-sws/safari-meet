<?php

namespace App\Livewire\Admin\Common;

use App\Models\SafariDiscussion as ModelsSafariDiscussion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SafariDiscussion extends Component
{
    public $type, $id;
    public $content, $userType,$is_admin;
    public $discussions = [];
    public $replyContent = [];
    public $replyBox = null;

    public function mount($type, $id, $usertype = 'admin')
    {
        $this->type = $type;
        $this->id = $id;
        $this->userType = ($usertype == 'admin') ? Auth::guard('admin')->user()  :   Auth::guard('web')->user();
        $this->is_admin = ($usertype == 'admin') ? 1  : 0;
        $this->loadDiscussions();
    }


    public function render()
    {
        return view('livewire.admin.common.safari-discussion');
    }

    public function loadDiscussions()
    {
        $this->discussions = ModelsSafariDiscussion::query()
            ->when($this->type == '2', fn($q) => $q->where('package_id', $this->id))
            ->when($this->type == '1', fn($q) => $q->where('share_safari_id', $this->id))
            // ->latest()
            ->orderBy('created_at')
            ->get();
        // dd($this->discussions);
    }


    public function save($parentId = null)
    {
        $content = $parentId ? ($this->replyContent[$parentId] ?? null) : $this->content;

        $this->validate([
            'content' => $parentId ? 'nullable' : 'required|string|max:500',
            'replyContent.*' => 'nullable|string|max:500',
        ]);

        $admin = Auth::guard('admin')->user();

        ModelsSafariDiscussion::create([
            'package_id'      => $this->type == 2 ? $this->id : null,
            'share_safari_id' => $this->type == 1 ? $this->id : null,
            'user_id'         => $this->userType->id,
            'content'         => $content,
            'is_admin'        => $this->is_admin,
            'parent_id'       => $parentId,
        ]);

        if ($parentId) {
            $this->replyContent[$parentId] = '';
            $this->replyBox = null;
        } else {
            $this->content = '';
        }

        $this->loadDiscussions();
        $this->dispatch('swal:toast', ['type' => 'success', 'message' => 'Comment added successfully!']);
    }

    public function toggleReplyBox($id)
    {
        $this->replyBox = $this->replyBox === $id ? null : $id;
    }

    public function deleteDiscussion($id)
    {
        $discussion = ModelsSafariDiscussion::findOrFail($id);
        $discussion->delete();

        $this->loadDiscussions();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Discussion deleted successfully!'
        ]);
    }
}
