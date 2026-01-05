<div>
    <div class="container py-4">
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">
                    {{ $editingPostId ? 'Edit Post' : 'Create New Post' }}
                </h5>

                <form wire:submit.prevent="save">
                    <div class="mb-3">
                        <label class="form-label">Type of Post <sup class="text-danger">*</sup></label>
                        <select wire:model="type_of_media" id="type_of_media" class="form-select select2">
                            <option value="">Select Type</option>
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                        @error('type_of_media')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Park <sup class="text-danger">*</sup></label>
                        <select wire:model="park" id="park" class="form-select select2">
                            <option value="">Select Park</option>
                            @foreach ($parks as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('park')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    @if ($type_of_media == 'image')
                        <div class="mb-3">
                            <label class="form-label">Upload Image</label>
                            <input type="file" wire:model="image" class="form-control"
                                accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" class="rounded shadow-sm" width="200">
                        @elseif ($editingPostId && $existingMedia)
                            <img src="{{ asset($existingMedia) }}" class="rounded shadow-sm" width="200">
                        @endif
                    @elseif($type_of_media == 'video')
                        <div class="mb-3">
                            <label class="form-label">Upload Video</label>
                            <input type="file" wire:model="video" class="form-control"
                                accept=".mp4,.mov,.avi,.mkv,.flv,.webm">
                            @error('video')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($video)
                            <video width="320" height="180" controls class="rounded">
                                <source src="{{ $video->temporaryUrl() }}">
                            </video>
                        @elseif ($editingPostId && $existingMedia)
                            <video width="320" height="180" controls class="rounded">
                                <source src="{{ asset($existingMedia) }}">
                            </video>
                        @endif
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Blog Content</label>
                        <textarea wire:model="content" rows="4" class="form-control" placeholder="Write something..."></textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4 rounded-pill position-relative"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">
                                {{ $editingPostId ? 'Update Blog' : 'Post Blog' }}
                            </span>
                            <span wire:loading wire:target="save">
                                <i class="fa fa-spinner fa-spin me-2"></i> Please wait...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Blog List --}}
        <div class="row g-3">
            @forelse ($posts as $post)
                <div class="col-md-6" id="social-{{ $post->id }}">
                    <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden">
                        @if ($post->type === 'image')
                            <img src="{{ asset($post->media_url) }}" class="card-img-top rounded-top-4"
                                style="height:200px; object-fit:cover;">
                        @elseif($post->type === 'video')
                            <video width="100%" height="200" controls class="rounded-top-4">
                                <source src="{{ asset($post->media_url) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif

                        <div class="card-body">
                            <p class="mb-2">{{ $post->caption }}</p>
                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>

                            <div class="dropdown position-absolute top-0 end-0 m-2">
                                <button class="btn btn-sm btn-light rounded-circle border-0" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    {{-- <li><a class="dropdown-item" href="javascript:void(0)"
                                            wire:click="edit({{ $post->id }})">Edit</a></li> --}}
                                    <li><a class="dropdown-item text-danger" href="javascript:void(0)"
                                            wire:click="delete({{ $post->id }})">Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted mt-3">No blog posts yet. Create your first one!</p>
            @endforelse
        </div>
    </div>
</div>
