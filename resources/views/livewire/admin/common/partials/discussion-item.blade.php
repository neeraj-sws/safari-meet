<div>
    <div class="mb-3">
        <div class="d-flex {{ $discussion->is_admin ? 'justify-content-end' : 'justify-content-start' }}">
            <div class="chat-bubble {{ $discussion->is_admin ? 'admin-bubble' : 'user-bubble' }}">
                <div class="d-flex align-items-center mb-1">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($discussion->is_admin ? $discussion->admin->name ?? 'Admin' : $discussion->user->name ?? 'User') }}&background=random"
                        class="rounded-circle me-2" width="30" height="30">
                    <strong>{{ $discussion->is_admin ? $discussion->admin->name ?? 'Admin' : $discussion->user->name ?? 'User' }}</strong>
                </div>

                <p class="mb-1">{{ $discussion->content }}</p>
                <small class="chat-meta">{{ $discussion->created_at->format('M d, Y h:i A') }}</small>

                <div class="mt-1 d-flex gap-2">
                    <a href="javascript:;" wire:click="toggleReplyBox({{ $discussion->id }})" class="text-light small">
                        <i class="fas fa-reply"></i> Reply
                    </a>
                    <a href="javascript:;" wire:click="deleteDiscussion({{ $discussion->id }})"
                        class="text-danger small">
                        <i class="fas fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        </div>

        {{-- Replies (recursive) --}}
        @foreach ($discussion->replies as $reply)
            <div class="ms-5 mt-2">
                @include('livewire.admin.common.partials.discussion-item', ['discussion' => $reply])
            </div>
        @endforeach
    </div>

</div>
