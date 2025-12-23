<div>
    <li class="nav-item dropdown">

        <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown">
          <i class="fa-solid fa-bell fs-6 text-dark"></i>
            @if ($unreadCount > 0)
            <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle p-1"
                style="font-size: 10px;">{{ $unreadCount }}</span>
            @endif
        </a>

        <div class="dropdown-menu dropdown-menu-end p-0 shadow border-0 rounded-3" style="width: 330px;">

            <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center"
                style="background:#085055;">
                <p class="m-0   text-white">Notifications</p>

                <a href="javascript:void(0)" wire:click="markAllAsRead" class="small text-white text-decoration-none" style="cursor:pointer;">Mark
                    all read</a>
            </div>

            <div class="notifications-wrapper" style="max-height:260px; overflow-y:auto;">

                @forelse ($notifications as $item)
                <a href="{{ $item->data['safari_url'] ?? '#' }}" wire:click="markAsRead({{ $item->id }})"
                    class="text-decoration-none d-block px-3 py-2 border-bottom"
                    style="background: {{ $item->is_read ? '#ffffff' : '#f4f7f7' }};">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-dark m-0" style="font-size: 16px"> {{ $item->heading }}</p>

                        <small class="text-muted" style="font-size:12px">{{ $item->created_at->diffForHumans() }}</small>
                    </div>
                    <p class=" text-dark mb-1" style="font-size:13px">
                        {{ $item->message }}
                    </p>
                </a>
                @empty
                <p class="text-center text-muted py-3 m-0">No notifications found.</p>
                @endforelse

            </div>

            {{-- <div class="px-3 py-2 border-top text-center" style="background:#085055;">
                <a href="#" class="  small text-white">
                    View All <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div> --}}

        </div>
    </li>
</div>
