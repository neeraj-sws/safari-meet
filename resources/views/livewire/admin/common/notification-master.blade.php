<div>
    <li class="nav-item dropdown dropdown-large">
        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
            data-bs-toggle="dropdown">
            <span class="alert-count">{{ $unreadCount }}</span>
            <i class="bx bx-bell"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-end p-0">
            <div class="msg-header d-flex justify-content-between align-items-center p-3 border-bottom">
                <p class="msg-header-title mb-0">Notifications</p>
                <p class="msg-header-badge mb-0 text-primary fw-bold">{{ $unreadCount }} New</p>
            </div>

            <div class="notification-scroll" style="max-height: 380px; overflow-y: auto;">

                @foreach ($notifications as $notification)
                @php
                $user = $notification->sender ?? $notification->receiver;
                $photo = null;

                if ($user) {
                if (!empty($user->profile_photo)) {
                $photo = asset($user->profile_photo);
                } elseif (!empty($user->profile_photo_path)) {
                $photo = asset($user->profile_photo_path);
                }

                $name = $user->name ?? 'User';
                $initial = strtoupper(substr($name, 0, 1));
                }
                @endphp

                <a class="dropdown-item py-2" href="{{ $notification->data['safari_url'] ?? '#' }}"
                    wire:click="markAsRead({{ $notification->notification_id }})">
                    <div class="d-flex align-items-center">
                        @if ($photo)
                        <img src="{{ $photo }}" class="rounded-circle me-3" width="40" height="40">
                        @else
                        <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center me-3"
                            style="width:40px;height:40px;font-size:18px;">
                            {{ $initial }}
                        </div>
                        @endif

                        <div class="flex-grow-1">
                            <h6 class="msg-name mb-1">
                                {{ $name }}
                                <span class="msg-time float-end"> {{ $notification->created_at->diffForHumans()
                                    }}</span>
                            </h6>
                            <p class="msg-info text-muted small mb-0 text-wrap">
                                {{ $notification->message }}
                            </p>
                        </div>
                    </div>
                </a>
                @endforeach

            </div>

            <div class="text-center p-3 border-top">
                @if ($type == 'admin')
                <a href="{{ route('admin.allnotification') }}" class="btn btn-primary w-100">View All Notifications</a>
                @else
                <a href="{{ route('agent.allnotification') }}" class="btn btn-primary w-100">View All Notifications</a>
                @endif
            </div>
        </div>
    </li>
</div>
