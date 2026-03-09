<div class="container">
    @include('livewire.components.breadcrumb', [
        'menu' => 'Species',
        'submenus' => ['Species'],
        'addButton' => 'openModal',
        'addText' => 'Add',
        'pageTitle' => 'Species',
    ])
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
                            <th>Name</th>
                            <th>Status</th>
                            <th>Top Species</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($species as $index => $specie)
                            <tr wire:key="{{ $specie->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $specie->name }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            wire:change="toggleStatus({{ $specie->id }})"
                                            @checked($specie->status)>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            wire:change="toggleStatusToSpecies({{ $specie->id }})"
                                            @checked($specie->top_species)>
                                    </div>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="text-center" title="Edit"
                                        wire:click="edit({{ $specie->id }})">
                                        <i class="bx bx-edit text-dark fs-5"></i>
                                    </a>
                                    <a href="{{ route('admin.species.add-species', $specie->uuid) }}"
                                        class="text-center" title="Details">
                                        <i class="bx bx-detail fs-5 text-dark"></i>
                                    </a>
                                    {{-- <a href="javascript:void(0)" class="text-center" title="Upload Image">
                                        <i class="lni lni-image fs-5 text-dark"></i>
                                    </a> --}}
                                    <a href="javascript:void(0)" wire:click="confirmDelete({{ $specie->id }})"
                                        title="Delete">
                                        <i class="bx bx-trash text-danger fs-5"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <x-pagination :paginator="$species" />
            </div>

            <!-- Modal -->
            <div class="modal @if ($showModal) show @endif" tabindex="-1"
                style="opacity:1; background-color:#0606068c; display:@if ($showModal) block @endif">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ $modalTitle }}</h4>
                                <button type="button" class="btn-close" wire:click="$set('showModal', false)"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="name" class="form-label">Species Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            wire:model="name"
                                            oninput="filterAndFormatInputs(this,{allowAlpha:true,capitalizeWords:true,allowedSpecialChars:`,:''()/-`})"
                                            placeholder="Enter Species Name Here...">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <div class="border border-1 p-4 rounded">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Upload Image <span class="text-danger">*</span>
                                                        </label>

                                                        <input type="file" wire:model="display_image"
                                                            accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                                            class="form-control @error('display_image') is-invalid @enderror">
                                                        <small>Expected aspect ratio is 1:1 (e.g. 200x200
                                                            px).</small><br>
                                                        @error('display_image')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">
                                                        {{ $isEditing ? 'Current' : 'Preview' }}
                                                    </label>
                                                    <div class="border bg-light text-center p-2 position-relative"
                                                        style="height: 143px; overflow: hidden;">

                                                        @if ($display_image)
                                                            <div wire:loading.delay wire:target="display_image"
                                                                class="d-flex align-items-center justify-content-center h-100 position-absolute w-100 bg-white z-3"
                                                                style="top: 0; left: 0;">
                                                                <div class="spinner-border text-primary" role="status">
                                                                    <span class="visually-hidden">Uploading...</span>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div wire:loading.remove wire:target="display_image"
                                                            class="h-100 position-relative">
                                                            @if ($display_image)
                                                                <img src="{{ $display_image->temporaryUrl() }}"
                                                                    class="img-fluid h-100 object-fit-contain">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle z-3"
                                                                    style="padding:0.2rem 0.4rem"
                                                                    wire:click="removeDisplayImage">
                                                                    ×
                                                                </button>
                                                            @elseif ($isEditing && !empty($previousImage))
                                                                <img src="{{ asset($previousImage) }}"
                                                                    class="img-fluid h-100 object-fit-contain">
                                                            @else
                                                                <span
                                                                    class="text-muted d-flex align-items-center justify-content-center h-100">
                                                                    No Image Selected
                                                                </span>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="border border-1 p-4 rounded">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Banner Image <span class="text-danger">*</span>
                                                        </label>

                                                        <input type="file" wire:model="banner_image"
                                                            accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                                            class="form-control @error('banner_image') is-invalid @enderror">
                                                        <small>Expected 1800 * 600 px.</small><br>
                                                        @error('banner_image')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">
                                                        {{ $isEditing ? 'Current' : 'Preview' }}
                                                    </label>
                                                    <div class="border bg-light text-center p-2 position-relative"
                                                        style="height: 143px; overflow: hidden;">

                                                        @if ($banner_image)
                                                            <div wire:loading.delay wire:target="banner_image"
                                                                class="d-flex align-items-center justify-content-center h-100 position-absolute w-100 bg-white z-3"
                                                                style="top: 0; left: 0;">
                                                                <div class="spinner-border text-primary"
                                                                    role="status">
                                                                    <span class="visually-hidden">Uploading...</span>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div wire:loading.remove wire:target="banner_image"
                                                            class="h-100 position-relative">
                                                            @if ($banner_image)
                                                                <img src="{{ $banner_image->temporaryUrl() }}"
                                                                    class="img-fluid h-100 object-fit-contain">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle z-3"
                                                                    style="padding:0.2rem 0.4rem"
                                                                    wire:click="removeBannerImage">
                                                                    ×
                                                                </button>
                                                            @elseif ($isEditing && !empty($previousBannerImage))
                                                                <img src="{{ asset($previousBannerImage) }}"
                                                                    class="img-fluid h-100 object-fit-contain">
                                                            @else
                                                                <span
                                                                    class="text-muted d-flex align-items-center justify-content-center h-100">
                                                                    No Image Selected
                                                                </span>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="$set('showModal', false)" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                    {{ $isEditing ? 'Update' : 'Save' }}
                                    <i class="spinner-border spinner-border-sm" wire:loading></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
