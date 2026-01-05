<div class="container">
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
                <button class="btn btn-primary ms-auto" wire:click="openModal"> <i class="lni lni-plus"></i> Add {{ $pageTitle }}</button>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row g-1 g-md-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">
                <div class="col">
                    <div class="form-group">
                        <select id="filter_category" class="form-select select2" wire:model="filter_category"
                            placeholder="Select Category">
                            <option value="">Select Category</option>
                            @foreach ($categories as $categoryId => $categoryValue)
                                <option value="{{ $categoryId }}">{{ $categoryValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <select id="filter_tag" class="form-select select2" wire:model="filter_tag"
                            placeholder="Select Tag">
                            <option value="">Select Tag</option>
                            @foreach ($tagsList as $tagId => $tagValue)
                                <option value="{{ $tagId }}">{{ $tagValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-info text-white rounded-0 me-2"
                        wire:click="applyFilter">Apply</button>
                    <button type="button" class="btn btn-info text-white rounded-0"
                        wire:click="resetFilter">Clear</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div>
                <input type="text" class="form-control ms-auto mb-3" placeholder="Search"
                    wire:model.live.debounce.300ms="search" style="max-width:200px;">
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Tags</th>
                            <th class="text-center">Images</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($albums as $index => $album)
                            <tr>
                                <td>{{ $albums->total() - ($albums->firstItem() + $index) + 1 }}</td>
                                <td>
                                    @if ($album->cover_image)
                                        <img src="{{ asset($album->cover_image) }}" width="60">
                                    @else
                                        <em>No image</em>
                                    @endif
                                </td>
                                <td>{{ $album->title }}</td>
                                <td>{{ $album->category->name ?? '-' }}</td>
                                <td>{{ $album->tags->pluck('name')->implode(', ') ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="cursor-pointer" wire:click="viewImages({{ $album->id }})">
                                        {{ $album->images()->count() }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning"
                                        wire:click="edit({{ $album->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger"
                                        wire:click="confirmDelete({{ $album->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $albums->links() }}

            <!-- Modal -->
            <div class="modal @if ($showModal) show @endif" tabindex="-1"
                style="opacity:1; background-color:#0606068c; display:@if ($showModal) block @endif">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form wire:submit.prevent="{{ $isEditing ? 'update' : 'submit' }}">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ $modalTitle }}</h4>
                                <button type="button" class="btn-close" wire:click="$set('showModal', false)"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Album Title <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        wire:model="title" placeholder="Enter title">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label class="form-label">Description <span class="text-danger">*</span> </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description"
                                        placeholder="Enter description"></textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label class="form-label">Category <span class="text-danger">*</span> </label>
                                    <select class="form-control select2 @error('category_id') is-invalid @enderror"
                                        wire:model="category_id" id="category_id" placeholder="Select Category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $categoryId => $categoryValue)
                                            <option value="{{ $categoryId }}" @selected($categoryId == $category_id)>
                                                {{ $categoryValue }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tags -->
                                <div class="mb-3">
                                    <label class="form-label">Tags <span class="text-danger">*</span> </label>
                                    <select multiple class="form-control select2 @error('tags') is-invalid @enderror"
                                        wire:model="tags" id="tags" placeholder="Select Tag">
                                        @foreach ($tagsList as $tagId => $tagValue)
                                            <option value="{{ $tagId }}" @selected($tagId == $tags)>
                                                {{ $tagValue }}</option>
                                        @endforeach
                                    </select>
                                    @error('tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Cover Image -->
                                <div class="mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-10">
                                            <label class="form-label">Cover Image <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                                class="form-control @error('cover_image') is-invalid @enderror"
                                                wire:model="cover_image">
                                            @error('cover_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 align-self-end">
                                            @if ($cover_image)
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ $cover_image->temporaryUrl() }}" alt="Cover Preview"
                                                        class="img-thumbnail"
                                                        style="max-width: 80px; max-height: 80px;">
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle"
                                                        wire:click="removeCoverImage"
                                                        style="padding: 0.25rem 0.4rem; font-size: 0.7rem;">×</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($existingCover)
                                        <div class="mt-2">
                                            <label>Current Cover Image <span class="text-danger">*</span> </label><br>
                                            <img src="{{ asset($existingCover) }}" width="120">
                                        </div>
                                    @endif
                                </div>
                                @if (!$isEditing)
                                    <div class="mb-3">
                                        <label class="form-label">Upload Images (Multiple) <span
                                                class="text-danger">*</span> </label>
                                        <input type="file" accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG"
                                            class="form-control @error('new_images') is-invalid @enderror"
                                            wire:model="new_images" multiple>
                                        @error('new_images')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @foreach ($errors->get('new_images.*') as $messages)
                                            @foreach ($messages as $msg)
                                                <div class="invalid-feedback d-block">{{ $msg }}</div>
                                            @endforeach
                                        @endforeach
                                        @if ($new_images)
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                @foreach ($new_images as $index => $img)
                                                    <div class="position-relative" style="width: 80px; height: 80px"
                                                        wire:key="new_image_{{ $index }}">

                                                        <img src="{{ $img->temporaryUrl() }}" alt="Preview"
                                                            class="img-thumbnail w-100 h-100 object-fit-cover">

                                                        <button type="button"
                                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle"
                                                            style="padding:0.1rem 0.35rem"
                                                            wire:click="removeNewImage({{ $index }})">
                                                            ×
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    {{ $isEditing ? 'Update' : 'Save' }}
                                    <i class="spinner-border spinner-border-sm" wire:loading></i>
                                </button>
                                <button type="button" class="btn btn-secondary"
                                    wire:click="$set('showModal', false)" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal @if ($viewModal) show @endif" tabindex="-1"
                style="opacity:1; background-color:#0606068c; display:@if ($viewModal) block @endif">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ $modalTitle }}</h4>
                            <button type="button" class="btn-close" wire:click="$set('viewModal', false)"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4">
                                @foreach ($albumImages as $albumImageKey => $albumImageValue)
                                    <div class="col position-relative">
                                        <div wire:click="confirmAlbumDelete({{ $albumImageKey }})"
                                            class="bg-danger text-white rounded-circle position-absolute album-img-remove">
                                            X</div>
                                        <img src="{{ asset($albumImageValue) }}" alt="" class="img-fluid">
                                    </div>
                                @endforeach
                            </div>
                            <div class="my-3">
                                <label class="form-label">Upload Images (Multiple) <span class="text-danger">*</span>
                                </label>
                                <input type="file" accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                    class="form-control @error('update_new_images') is-invalid @enderror"
                                    wire:model="update_new_images" multiple>
                                @error('update_new_images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @foreach ($errors->get('update_new_images.*') as $messages)
                                    @foreach ($messages as $msg)
                                        <div class="invalid-feedback d-block">{{ $msg }}</div>
                                    @endforeach
                                @endforeach
                                @if ($update_new_images)
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        @foreach ($update_new_images as $index => $new_image)
                                            <div class="position-relative" style="width: 80px; height: 80px"
                                                wire:key="new_image{{ $index }}">

                                                <img src="{{ $new_image->temporaryUrl() }}" alt="Preview"
                                                    class="img-thumbnail w-100 h-100 object-fit-cover">

                                                <button type="button"
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle"
                                                    style="padding:0.1rem 0.35rem"
                                                    wire:click="removealbumImage({{ $index }})">
                                                    ×
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" wire:click="addImages"
                                wire:loading.attr="disabled">
                                Add Images
                                <i class="spinner-border spinner-border-sm" wire:loading></i>
                            </button>
                            <button type="button" class="btn btn-secondary" wire:click="$set('viewModal', false)"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <style>
            .album-img-remove {
                right: 2px;
                width: 20px;
                text-align: center;
                top: -6px;
                height: 20px;
                cursor: pointer;
            }
        </style>
    @endpush
</div>
