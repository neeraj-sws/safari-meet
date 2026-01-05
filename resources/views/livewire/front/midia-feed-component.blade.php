<div class="container py-5" style="max-width: 680px;">
    @foreach ($posts as $key => $post)
        <div class="post-card bg-white shadow-sm border mb-4" wire:key="post-{{ $post->id }}">
            @php
                $avatarUrl = $post?->user?->profile_photo_path ? asset($post?->user?->profile_photo_path) : null;
                $fallbackInitial = strtoupper(substr($post->user->name, 0, 1));
                $bgColor = '#' . substr(md5($post->user->id), 0, 6);
            @endphp

            <div class="d-flex align-items-center px-4 py-3 justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    @if ($avatarUrl)
                        <img src="{{ $avatarUrl }}" class="rounded-circle" width="40" height="40"
                            alt="{{ $post->user->name }}">
                    @else
                        <div class="user-avatar rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                            style="width: 40px; height: 40px; background-color: {{ $bgColor }};">
                            {{ $fallbackInitial }}
                        </div>
                    @endif

                    <div>
                        <div class="fw-semibold text-dark">{{ $post->user->name }}</div>
                        <div class="text-muted small">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">

                    {{-- Follow / Unfollow --}}
                    @if (Auth::check() && Auth::id() != $post->user->id)
                        <button wire:click="toggleFollow({{ $post->user->id }})"
                            class="btn btn-sm {{ $this->isFollowing($post->user->id) ? 'btn-outline-secondary' : 'btn-primary' }}">
                            {{ $this->isFollowing($post->user->id) ? 'Unfollow' : 'Follow' }}
                        </button>
                    @else
                        <div style="width: 90px;"></div>
                    @endif

                    {{-- 3-dot dropdown --}}
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fs-5"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li>
                                    <a class="dropdown-item text-danger" href="javascript:void(0)"
                                        wire:click="openReportModal({{ $post->id }})">
                                        <i class="fa-solid fa-flag me-2"></i> Report
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>



            <!-- Post Content -->
            <div class="px-4 pb-3">
                <p class="text-dark mb-3">{{ $post->caption }}</p>

                <!-- Tags -->
                {{-- <div class="d-flex flex-wrap gap-2">
                    @foreach ($post->tags ?? [] as $tag)
                        <span class="tag"
                            style="background-color: #dbeafe; color: #1d4ed8;">#{{ $tag }}</span>
                    @endforeach
                </div> --}}
            </div>

            <!-- Post Image -->
            @if ($post->media_url)
                <div class="mt-3">
                    @if ($post->type === 'video')
                        <video id="video{{ $post->id }}" controls muted loop playsinline
                            class="w-100 rounded shadow-sm" style="height: 288px; object-fit: cover;">
                            <source src="{{ asset($post->media_url) }}" type="video/mp4">
                        </video>
                    @elseif ($post->type === 'image')
                        <img src="{{ asset($post->media_url) }}" class="w-100 rounded shadow-sm"
                            style="height: 288px; object-fit: cover;">
                    @endif
                </div>
            @endif

            <!-- Engagement -->
            <div class="px-4 py-3 border-top border-bottom d-flex justify-content-between small text-muted">
                <div class="d-flex align-items-center">
                    <div class="like-avatars me-2">
                        @foreach ($post?->likes->take(3) as $like)
                            <div class="like-avatar"
                                style="background-color: #{{ substr(md5($like->user->user_id), 0, 6) }};"></div>
                        @endforeach
                    </div>

                    @php
                        $likeCount = $post->likes->count();
                        $firstLiker = $post->likes->first()?->user->name ?? null;
                    @endphp

                    @if ($likeCount > 0)
                        <span>
                            Liked by <span class="fw-medium">{{ $firstLiker }}</span>
                            @if ($likeCount > 1)
                                <a href="javascript:void(0)" id="likelink{{ $key }}"
                                    wire:click="showlikesModalData({{ $post->id }})"
                                    class="fw-medium text-decoration-none">
                                    and {{ $likeCount - 1 }} others
                                </a>
                            @endif
                        </span>
                    @else
                        <span>No likes yet</span>
                    @endif
                </div>

                <div>
                    <span>{{ $post->comments->count() }} comments</span>
                </div>
            </div>


            <!-- Actions -->
            <div class="px-4 py-2 border-bottom d-flex justify-content-between">
                <button wire:click="likePost({{ $post->id }})"
                    class="action-btn btn d-flex align-items-center gap-2 {{ $post->likes->contains('user_id', auth()->id()) ? 'text-danger' : 'text-muted' }}">
                    <i
                        class="{{ $post->likes->contains('user_id', auth()->id()) ? 'fas fa-heart' : 'far fa-heart' }} fa-lg"></i>
                    <span>Like</span>
                </button>

                <button wire:click="$toggle('showComments.{{ $post->id }}')"
                    class="action-btn btn d-flex align-items-center gap-2 text-muted">
                    <i class="far fa-comment fa-lg"></i>
                    <span>Comment</span>
                </button>

                {{-- <button class="action-btn btn d-flex align-items-center gap-2 text-muted">
                    <i class="far fa-share-from-square fa-lg"></i>
                    <span>Share</span>
                </button> --}}
            </div>

            <!-- Comments -->

            @if ($showComments[$post->id] ?? false)
                <div class="comment-section px-4 py-4">
                    @foreach ($post->comments as $comment)
                        @php
                            $user = $comment->user;
                            $avatarUrl = $user?->profile_photo_path ? asset($user?->profile_photo_path) : null;
                            $fallbackInitial = strtoupper(substr($user?->name, 0, 1));
                            $bgColor = '#' . substr(md5($user?->id), 0, 6);
                        @endphp

                        <div class="d-flex mb-3">
                            @if ($avatarUrl)
                                <img src="{{ $avatarUrl }}" class="rounded-circle me-3" width="32"
                                    height="32" alt="{{ $user->name }}">
                            @else
                                <div class="comment-avatar rounded-circle d-flex align-items-center justify-content-center me-3 text-white fw-bold"
                                    style="width: 32px; height: 32px; background-color: {{ $bgColor }};">
                                    {{ $fallbackInitial }}
                                </div>
                            @endif

                            <div class="flex-grow-1">
                                <div class="comment-bubble">
                                    <span class="fw-semibold text-dark">{{ $user->name }}</span>
                                    <p class="text-dark mb-0">{{ $comment->comment }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="d-flex align-items-center mt-4">
                        <div class="comment-avatar me-3"
                            style="background: linear-gradient(to right, #9ca3af, #4b5563); width: 40px; height: 40px; border-radius: 50%;">
                        </div>

                        <form class="flex-grow-1 d-flex" wire:submit.prevent="addComment({{ $post->id }})">
                            <input type="text" wire:model="newComment.{{ $post->id }}"
                                placeholder="Write a comment..."
                                class="form-control rounded-pill border-0 bg-light px-3 py-2 me-2">
                            <button type="submit"
                                class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                    @error('newComment.' . $post->id)
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror

                </div>
            @endif
        </div>
    @endforeach

    <!-- Report Modal -->
    @if ($showReportModal)
        <div class="modal fade  show d-block" tabindex="-1" style="display:block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Report Discussion</h6>
                        <button type="button" class="btn-close" wire:click="$set('showReportModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="resion" class="form-label">Select Reason <span
                                    class="text-danger">*</span></label>
                            <select wire:model="selectedResion" class="form-select">
                                <option value="">-- Choose Reason --</option>
                                @foreach ($reportResions as $resion)
                                    <option value="{{ $resion->id }}">{{ $resion->title }}</option>
                                @endforeach
                            </select>
                            @error('selectedResion')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (optional)</label>
                            <textarea wire:model.defer="notes" class="form-control" rows="3" placeholder="Add any additional info..."></textarea>
                            @error('notes')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm"
                            wire:click="$set('showReportModal', false)">Cancel</button>
                        <button class="btn btn-primary btn-sm" wire:click="submitReport">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($showLikeModel)
        <div class="modal fade show" id="exampleScrollableModal" tabindex="-1" style="display: block;"
            aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Likes</h5>
                        <button type="button" class="btn-close" wire:click="$set('showLikeModel', false)"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Profile</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($PostLikesLists as $like)
                                    <tr>
                                        <td>{{ $like->user->username ? $like->user->username : $like->user->name }}
                                        </td>
                                        <td>
                                            <img src="{{ $like->user->profile_photo_path }}" alt="Profile Photo"
                                                width="40" height="40" class="rounded-circle">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($hasMoreLikes)
                            <button wire:click="loadMoreLikes" class="btn btn-primary">Load More</button>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('showLikeModel', false)">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Load More -->
    @if ($posts->hasMorePages())
        <div class="text-center mt-4">
            <button wire:click="loadMore" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-medium">
                Load More Posts
            </button>
        </div>
    @endif
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const videos = document.querySelectorAll('video');

            let lastVisibleVideo = null;

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    const video = entry.target;

                    if (entry.isIntersecting && entry.intersectionRatio >= 0.7) {
                        // Pause previous visible video
                        if (lastVisibleVideo && lastVisibleVideo !== video) {
                            lastVisibleVideo.pause();
                            lastVisibleVideo.muted = true;
                        }

                        lastVisibleVideo = video;

                        // Play current video
                        const playPromise = video.play();
                        if (playPromise !== undefined) {
                            playPromise.catch(err => console.log('Autoplay blocked:', err));
                        }
                    } else if (video === lastVisibleVideo) {
                        video.pause();
                    }
                });
            }, {
                threshold: 0.7
            });

            videos.forEach(video => {
                observer.observe(video);
            });

            // Enable sound only for currently visible video on first interaction
            const enableSound = () => {
                if (lastVisibleVideo) {
                    lastVisibleVideo.muted = false;
                    lastVisibleVideo.volume = 1.0;
                    const playPromise = lastVisibleVideo.play();
                    if (playPromise !== undefined) {
                        playPromise.catch(err => console.log('Play with sound blocked:', err));
                    }
                }
            };

            document.addEventListener('click', enableSound, {
                once: true
            });
            document.addEventListener('scroll', enableSound, {
                once: true
            });
        });
    </script>
@endpush
