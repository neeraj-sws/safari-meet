<div class="container" id="amanity">
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
                        <div class="mb-3" x-data="{ title: @entangle('title') }">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                oninput="filterAndFormatInputs(this,{ allowAlpha: true,allowNumbers:true, capitalizeWords: true })"
                                x-model="title" x-on:input="title = title.replace(/\b\w/g, l => l.toUpperCase())"
                                placeholder="Enter Title Here...">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="col-md-12 mb-2">
                                <label class="form-label">
                                    Display Image <span class="text-danger">*</span>
                                </label>

                                <input type="file" wire:model="display_image"
                                    accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                    class="form-control @error('display_image') is-invalid @enderror">

                                @error('display_image')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">
                                    {{ $isEditing ? 'Current' : 'Preview' }}
                                </label>

                                <div class="border bg-light text-center p-2 position-relative" style="height: 200px;">

                                    @if ($display_image)
                                        <img src="{{ $display_image->temporaryUrl() }}"
                                            class="img-fluid h-100 object-fit-contain">
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle"
                                            style="padding:0.2rem 0.4rem" wire:click="removeDisplayImage">
                                            ×
                                        </button>
                                    @elseif ($isEditing && !empty($previousImage))
                                        <img src="{{ asset($previousImage) }}"
                                            class="img-fluid h-100 object-fit-contain">
                                    @else
                                        <span class="text-muted d-flex align-items-center justify-content-center h-100">
                                            No Image Selected
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-sm btn-primary px-5" wire:loading.attr="disabled">
                                {{ $isEditing ? 'Update' : 'Save' }}
                                <i class="spinner-border spinner-border-sm" wire:loading.delay
                                    wire:target="{{ $isEditing ? 'update' : 'store' }}"></i>
                            </button>
                            <button type="button" wire:click="resetForm"
                                class="btn btn-sm btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5" placeholder="Search..."
                            wire:model.live.debounce.300ms="search"> <span
                            class="position-absolute top-50 product-show translate-middle-y">
                            <i class="bx bx-search"></i></span>
                    </div>
                </div>




                <div class="card-body">
                    <div class="table-responsive ecs-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Mode</th>
                                    <th>Status</th>
                                    <th style="width: 80px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $index => $item)
                                    <tr wire:key="{{ $item->id }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ asset($item->display_image) }}" alt="Image"
                                                    class="img-fluid"
                                                    style="height: 40px; width: auto; object-fit: contain;">
                                                <span>{{ $item->title }}</span>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="{{ $index + 1 }}"
                                                    wire:change="toggleStatus({{ $item->id }})"
                                                    @checked($item->status)>
                                            </div>
                                        </td>
                                        <td class="text-center">
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
                                        <td colspan="3" class="text-center">No amenities found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
