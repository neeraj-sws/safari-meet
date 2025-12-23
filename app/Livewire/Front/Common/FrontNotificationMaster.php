<?php

namespace App\Livewire\Front\Common;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FrontNotificationMaster extends Component
{
    public $notifications = [], $unreadCount = 0, $user;

    public function mount()
    {
        $this->user = Auth::guard('web')->user();
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Notification::with(['sender', 'receiver'])
            ->where('receiver_id', $this->user->id)
            ->where('receiver_type', get_class($this->user))
            ->latest()
            ->unread()
            ->get()->map(function ($item) {
                $item->data = json_decode($item->data, true);
                return $item;
            });

        $this->unreadCount = Notification::where('receiver_id', $this->user->id)
            ->where('is_read', false)
            ->where('receiver_id', $this->user->id)
            ->where('receiver_type', get_class($this->user))
            ->unread()
            ->count();
    }

    public function markAllAsRead()
    {
        Notification::where('receiver_id', $this->user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $this->loadNotifications();
    }

    public function markAsRead($id)
    {
        Notification::where('notification_id', $id)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.front.common.front-notification-master');
    }
}
