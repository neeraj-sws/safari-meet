<div>
    <style>
        .chat-thread {
            display: flex;
            flex-direction: column;
        }

        .chat-bubble {
            max-width: 75%;
            padding: 10px 15px;
            border-radius: 15px;
            color: #fff;
            position: relative;
        }

        .user-bubble {
            background-color: #6c757d;
            border-bottom-left-radius: 0;
        }

        .admin-bubble {
            background-color: #6f42c1;
            border-bottom-right-radius: 0;
        }

        .chat-meta {
            font-size: 0.75rem;
            opacity: 0.85;
        }

        .reply-preview {
            border-left: 4px solid #6f42c1;
            background: #f8f9fa;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.85rem;
        }
    </style>

    <div class="card shadow-sm rounded-3">
        <div class="card-body p-3" style="max-height: 500px; overflow-y:auto;">
            <h5 class="fw-bold mb-3">Discussion</h5>

            <div class="chat-thread">
                @foreach ($discussions->where('parent_id', null) as $d)
                    <div class="mb-3">
                        <div class="d-flex {{ $d->is_admin ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="chat-bubble {{ $d->is_admin ? 'admin-bubble' : 'user-bubble' }}">
                                <div class="d-flex align-items-center mb-1">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($d->is_admin ? $d->admin->name ?? 'Admin' : $d->user->name ?? 'User') }}&background=random"
                                        class="rounded-circle me-2" width="30" height="30">
                                    <strong>{{ $d->is_admin ? $d->admin->name ?? 'Admin' : $d->user->name ?? 'User' }}</strong>
                                </div>
                                <p class="mb-1">{{ $d->content }}</p>
                                <small class="chat-meta">{{ $d->created_at->format('M d, Y h:i A') }}</small>

                                <div class="mt-1">
                                    <a href="javascript:;" wire:click="toggleReplyBox({{ $d->id }})"
                                        class="text-light small">
                                        <i class="fas fa-reply"></i> Reply
                                    </a>
                                    <a href="javascript:;" wire:click="deleteDiscussion({{ $d->id }})"
                                        class="text-danger small">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        @foreach ($d->replies as $reply)
                            <div
                                class="d-flex {{ $reply->is_admin ? 'justify-content-end' : 'justify-content-start' }} ms-5 mt-2">
                                <div class="chat-bubble {{ $reply->is_admin ? 'admin-bubble' : 'user-bubble' }}">
                                    <div class="d-flex align-items-center mb-1">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->is_admin ? $reply->admin->name ?? 'Admin' : $reply->user->name ?? 'User') }}&background=random"
                                            class="rounded-circle me-2" width="25" height="25">
                                        <strong>{{ $reply->is_admin ? $reply->admin->name ?? 'Admin' : $reply->user->name ?? 'User' }}</strong>
                                    </div>
                                    <p class="mb-1">{{ $reply->content }}</p>
                                    <small class="chat-meta">{{ $reply->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <form wire:submit.prevent="save({{ $replyBox ?? 'null' }})">
                @if ($replyBox)

                    @php $parent = $discussions->find($replyBox); @endphp
                    @if ($parent)
                        <div class="reply-preview mb-2 d-flex justify-content-between align-items-center">
                            <div>
                                <small
                                    class="fw-bold">{{ $parent->is_admin ? $parent->admin->name ?? 'Admin' : $parent->user->name ?? 'User' }}</small>
                                <small class="text-muted ms-2">{{ $parent->created_at->format('d/m/Y H:i') }}</small>
                                <p class="mb-0 small text-muted">{{ Str::limit($parent->content, 80) }}</p>
                            </div>
                            <button type="button" wire:click="$set('replyBox', null)"
                                class="btn-close btn-sm"></button>
                        </div>
                    @endif
                @endif

                <textarea wire:model="{{ $replyBox ? 'replyContent.' . $replyBox : 'content' }}" class="form-control" rows="2"
                    placeholder="Type a message..."></textarea>

                <div class="text-end mt-2">
                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save({{ $replyBox ?? 'null' }})">Send</span>
                        <span wire:loading wire:target="save({{ $replyBox ?? 'null' }})">
                            <span class="spinner-border spinner-border-sm"></span> Sending...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
