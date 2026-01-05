<?php

namespace App\Livewire\Admin\Common;

use App\Models\Notification as Model;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class ShowAllNotification extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function markAsRead($id)
    {
        $notification = Model::find($id);

        if ($notification && !$notification->is_read) {
            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    public function render()
    {
        $items = Model::with(['sender', 'receiver'])
            ->when($this->search, function ($query) {
                $query->where('message', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(20);

        return view('livewire.admin.common.show-all-notification', compact('items'));
    }
}
