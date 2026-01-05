<div>
    <div class="container">
        @include('livewire.components.breadcrumb', [
            'menu' => $pageTitle,
            'submenus' => [$pageTitle],
        ])
        <div class="row g-4">
            <!-- Form Card -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
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

                            @if ($type_of_media === 'image')
                                <div class="mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" wire:model="image" class="form-control"
                                       accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP" >
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @elseif($type_of_media == 'video')
                                <div class="mb-3">
                                    <label class="form-label">Video</label>
                                    <input type="file" wire:model="video" class="form-control"
                                        accept=".mp4,.mov,.avi,.mkv,.flv,.webm">
                                    @error('video')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Caption</label>
                                <textarea wire:model="caption" class="form-control" rows="3"></textarea>
                                @error('caption')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm px-5" wire:loading.attr="disabled">
                                    {{ $isEditing ? 'Update' : 'Save' }}
                                    <i class="spinner-border spinner-border-sm" wire:loading.delay></i>
                                </button>
                                <button type="button" wire:click="resetForm"
                                    class="btn btn-secondary btn-sm">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Media</th>
                                    <th>Caption</th>
                                    <th>Park</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $index => $item)
                                    <tr wire:key="item-{{ $item->id }}">
                                        <td>{{ $items->firstItem() + $index }}</td>
                                        <td>{{ ucfirst($item->type) }}</td>
                                        <td>
                                            <a href="javascript:void(0)"
                                                wire:click="showPreview('{{ $item->media_url }}')">
                                                @if ($item->type === 'image')
                                                    <img src="{{ asset($item->media_url) }}" width="80"
                                                        height="50" class="rounded" style="object-fit:cover;">
                                                @else
                                                    <video width="80" height="50" class="rounded" muted>
                                                        <source src="{{ asset($item->media_url) }}">
                                                    </video>
                                                @endif
                                            </a>
                                        </td>
                                        <td>{{ $item->caption }}</td>
                                        <td>{{ $item->park->name ?? '-' }}</td>
                                        <td>
                                            <a href="javascript:void(0)" wire:click="edit({{ $item->id }})"
                                                title="Edit">
                                                <i class="bx bx-edit text-dark fs-5"></i>
                                            </a>
                                            <a href="javascript:void(0)"
                                                wire:click="confirmDelete({{ $item->id }})" title="Delete">
                                                <i class="bx bx-trash text-danger fs-5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No Data Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Media Preview Modal -->
        @if ($show_preview)
            <div class="modal fade show" style="display: block;" tabindex="-1" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" wire:click="closePreview"></button>
                        </div>
                        <div class="modal-body">
                            @if ($previewUrl)
                                @if (Str::contains($previewUrl, ['.jpg', '.jpeg', '.png', '.webp', '.avif']))
                                    <img src="{{ $previewUrl }}" class="img-fluid rounded">
                                @else
                                    <video controls autoplay class="w-100 h-50 rounded">
                                        <source src="{{ $previewUrl }}" type="video/mp4">
                                    </video>
                                @endif
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closePreview">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
