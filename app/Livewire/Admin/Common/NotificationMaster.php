<?php

namespace App\Livewire\Admin\Common;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationMaster extends Component
{
    public $notifications = [], $unreadCount = 0, $type, $user;

    public function mount($type = 'admin')
    {
        $this->type = $type;
        $this->user = Auth::guard('web')->user();
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if ($this->type == 'admin') {
            $this->notifications = Notification::with(['sender', 'receiver'])
                ->latest()
                ->unread()
                ->take(10)
                ->get()->map(function ($item) {
                    $item->data = json_decode($item->data, true);
                    return $item;
                });
            $this->unreadCount = Notification::where('is_read', false)
                ->unread()
                ->count();
        } else {
            $this->notifications = Notification::with(['sender', 'receiver'])
                ->where('receiver_id', $this->user->id)
                ->where('receiver_type', get_class($this->user))
                ->latest()
                ->unread()
                ->take(10)
                ->get()->map(function ($item) {
                    $item->data = json_decode($item->data, true);
                    return $item;
                });
            $this->unreadCount = Notification::where('is_read', false)
                ->where('receiver_id', $this->user->id)
                ->where('receiver_type', get_class($this->user))
                ->unread()
                ->count();
        }
    }

    public function render()
    {
        return view('livewire.admin.common.notification-master');
    }

    public function markAllAsRead()
    {
        Notification::where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $this->loadNotifications();
    }

    public function markAsRead($id)
    {
        Notification::where('notification_id', $id)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        $this->loadNotifications();
    }
}
