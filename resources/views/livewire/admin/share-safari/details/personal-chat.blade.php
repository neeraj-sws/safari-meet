<div>
    <div class="container">

        <style>
            .card-body::-webkit-scrollbar,
            .px-3.py-3::-webkit-scrollbar {
                width: 6px;
            }

            .card-body::-webkit-scrollbar-thumb,
            .px-3.py-3::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 10px;
            }

            .card-body::-webkit-scrollbar-thumb:hover,
            .px-3.py-3::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }

            textarea:focus {
                box-shadow: none !important;
            }
        </style>
        <main>
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">{{ $pageTitle }}</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ route('admin.sharedsafari.share.safari') }}" class="btn btn-primary ms-auto"> <i
                                class="lni lni-arrow-left"></i></a>
                    </div>
                </div>
            </div>
            <div class="container-lg">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h5 class="fw-bold text-primary">
                            <i class="fas fa-comments me-2"></i>Messages
                        </h5>
                    </div>
                    <div class="col-md-12">
                        <div class="row g-3">
                            <!-- LEFT SIDEBAR -->
                            <div class="col-xxl-3 col-xl-4 col-md-4">
                                <div class="card shadow-sm border-0 rounded-3" style="height: 470px; overflow: hidden;">
                                    <div class="card-header bg-light border-0 py-3 px-3">
                                        <h6 class="mb-0 fw-semibold text-secondary">Chats</h6>
                                    </div>
                                    <div class="card-body p-0" style="height: 420px; overflow-y: auto;">
                                        @if ($safariConversations->isEmpty())
                                            <div class="text-center text-muted mt-4">
                                                <i class="fas fa-comment-dots fa-2x mb-2"></i>
                                                <p class="small mb-0">No conversations yet</p>
                                            </div>
                                        @else
                                            @foreach ($safariConversations as $conversation)
                                                @php
                                                    $chatUser =
                                                        $conversation->creator_id === $currentAuth->id &&
                                                        $conversation->creator_type === get_class($currentAuth)
                                                            ? $conversation->participant
                                                            : $conversation->creator;
                                                    $isActive = optional($selectedUser)->id === $chatUser->id;
                                                    $lastMessage = $conversation->messages->first();
                                                @endphp
                                                <a href="javascript:void(0)"
                                                    wire:click="selectConversation({{ $chatUser->id }})">
                                                    <div
                                                        class="d-flex align-items-center gap-2 px-3 py-2 border-bottom {{ $isActive ? 'bg-primary bg-opacity-10 border-start border-primary border-4' : 'bg-white' }}">
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($chatUser->name) }}&background=random"
                                                            class="rounded-circle" width="42" height="42">
                                                        <div class="flex-grow-1">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center">
                                                                <span class="fw-semibold">{{ $chatUser->name }}</span>
                                                                <small
                                                                    class="text-muted">{{ optional($lastMessage)->created_at?->diffForHumans() }}</small>
                                                            </div>
                                                            <small
                                                                class="text-muted d-block">{{ Str::limit(optional($lastMessage)->message, 30) }}</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT CHAT WINDOW -->
                            <div class="col-xxl-9 col-xl-8 col-md-8">
                                <div class="card shadow-sm border-0 rounded-3" style="height: 470px; overflow: hidden;">
                                    @if ($conversationId)
                                        <!-- Chat Header -->
                                        <div class="d-flex align-items-center border-bottom bg-light p-3">
                                            @php
                                                $firstMessage = $chatConversationMessage->first();
                                                $chatPartner = $firstMessage
                                                    ? ($firstMessage->sender_id === $currentAuth->id &&
                                                    $firstMessage->sender_type === get_class($currentAuth)
                                                        ? $firstMessage->receiver
                                                        : $firstMessage->sender)
                                                    : $selectedUser;
                                            @endphp
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($chatPartner->name ?? 'User') }}&background=random"
                                                class="rounded-circle me-3" width="48" height="48">
                                            <div>
                                                <h6 class="fw-semibold mb-0">{{ $chatPartner->name ?? 'User' }}</h6>
                                            </div>
                                        </div>

                                        <!-- Messages -->
                                        <div class="px-3 py-3 bg-white" style="height: 330px; overflow-y: auto;">
                                            @foreach ($chatConversationMessage as $message)
                                                @php $isMine = ($message->sender_id === $currentAuth->id && $message->sender_type === get_class($currentAuth)); @endphp
                                                <div
                                                    class="d-flex mb-3 {{ $isMine ? 'justify-content-end' : 'justify-content-start' }}">
                                                    <div class="p-2 rounded-3 shadow-sm"
                                                        style="max-width: 70%; {{ $isMine ? 'background-color:#0d6efd;color:white;border-bottom-right-radius:5px;' : 'background-color:#f8f9fa;border-bottom-left-radius:5px;' }}">
                                                        <div>{{ $message->message }}</div>
                                                        <small
                                                            class="d-block mt-1 text-end {{ $isMine ? 'text-white-50' : 'text-muted' }}"
                                                            style="font-size: 0.7rem;">
                                                            {{ $message->created_at->format('h:i A') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Input -->
                                        <div class="border-top p-3 bg-light">
                                            <form wire:submit.prevent="saveChate">
                                                <div class="d-flex align-items-center gap-2">
                                                    <textarea wire:model="chatContent" rows="1" placeholder="Write a message..."
                                                        class="form-control border-0 shadow-sm rounded-pill px-3 py-2" style="resize:none;"></textarea>
                                                    <button type="submit"
                                                        class="btn btn-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                                        style="width: 42px; height: 42px;">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </div>
                                                @error('chatContent')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </form>
                                        </div>
                                    @else
                                        <!-- Empty State -->
                                        <div
                                            class="d-flex justify-content-center align-items-center h-100 text-muted flex-column">
                                            <i class="fas fa-comments fa-3x mb-3 opacity-50"></i>
                                            <p class="fw-semibold mb-0">Select a chat to start messaging</p>
                                            <small>Choose a conversation from the sidebar</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const conversationId = @json($conversationId);

        if (!conversationId) return;

        window.Echo.private(`conversation.${conversationId}`)
            .listen('.MessageSent', (e) => {
                console.log('New message received:', e);
                Livewire.dispatch('realtimeMessageReceived', {
                    message: e.message
                });
            });
    });
</script>
