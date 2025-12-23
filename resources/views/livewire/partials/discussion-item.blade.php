<div class="discussion-item mb-3">
    <div class="d-flex align-items-start">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($discussion->is_admin ? $discussion->admin->name ?? 'Admin' : $discussion->user->name ?? 'User') }}&background=random"
            class="rounded-circle me-3" width="40" height="40" alt="avatar">

        <div class="flex-grow-1">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold">
                        {{ $discussion->is_admin ? $discussion->admin->name ?? 'Admin' : $discussion->user->name ?? 'User' }}
                    </span>
                    <small class="text-muted">{{ $discussion->created_at->diffForHumans() }}</small>
                </div>

                @auth
                    <a href="javascript:void(0)" wire:click="discussionReport({{ $discussion->id }})"
                        title="Report this message" class="text-danger ms-2">
                        <i class="fa-solid fa-flag"></i>
                    </a>
                @endauth
            </div>

            <p class="mb-2 mt-1">{{ $discussion->content }}</p>

            @if ($level < 3)
                <a href="javascript:void(0)" wire:click="discussionReplyBox({{ $discussion->id }})"
                    class="text-primary text-decoration-none small fw-semibold">
                    <i class="fa fa-reply me-1"></i> Reply
                </a>
            @endif

            @if ($level < 3 && $discussion->replies && $discussion->replies->count())
                <div class="ms-4 mt-3 border-start ps-3">
                    @foreach ($discussion->replies as $reply)
                        @include('livewire.partials.discussion-item', [
                            'discussion' => $reply,
                            'level' => $level + 1,
                        ])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
