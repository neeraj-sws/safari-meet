<?php

namespace App\Livewire\TravelAgent\Common;

use App\Models\Notification as Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.agent-app')]
class ShowAgentNotification extends Component
{
    use WithPagination;

    public $search = '', $user;

    protected $queryString = ['search'];

    public function mount()
    {
        $this->user = Auth::guard('web')->user();
    }

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
            ->where('receiver_id', $this->user->id)
            ->where('receiver_type', get_class($this->user))
            ->when($this->search, function ($query) {
                $query->where('message', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(20);

        return view('livewire.travel-agent.common.show-all-notification', compact('items'));
    }
}
