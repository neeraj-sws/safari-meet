<div class="container" id="homepagebanner">
    <div class="page-breadcrumb flex-wrap d-flex align-items-center mb-3">
        <div>
            <h6 class="breadcrumb-title pe-2 fs-24  border-0 text-black fw-600">{{ $pageTitle }} </h6>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4">
        <!-- Form Card -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="title" class="form-label">Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        wire:model="title" placeholder="Enter Title Here...">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">
                                        Upload Display Image <span class="text-danger">*</span>
                                    </label>

                                    <input type="file" wire:model="display_image" accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                        class="form-control @error('display_image') is-invalid @enderror">

                                    @error('display_image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">
                                        {{ $isEditing ? 'Current' : 'Preview' }}
                                    </label>

                                    <div class="border bg-light text-center p-2 position-relative"
                                        style="height: 200px;">

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
                                            <span
                                                class="text-muted d-flex align-items-center justify-content-center h-100">
                                                No Image Selected
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ $isEditing ? 'Update' : 'Save' }}
                                <i class="spinner-border spinner-border-sm" wire:loading.delay wire:target="{{ $isEditing ? 'update' : 'store' }}"></i>
                            </button>
                            <button type="button" wire:click="resetFields" class="btn btn-sm btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
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
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($species as $index => $specie)
                                    <tr wire:key="{{ $specie->id }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ asset($specie->display_image) }}" alt="Image"
                                                    class="img-fluid"
                                                    style="height: 40px; width: auto; object-fit: contain;">
                                                <span>{{ $specie->title }}</span>
                                            </div>
                                        </td>
                                        {{-- <td>{{ $specie->title }}</td> --}}
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    wire:change="toggleStatus({{ $specie->id }})"
                                                    @checked($specie->status)>
                                            </div>
                                        </td>
                                        <td>
                                             <a href="javascript:void(0)" wire:click="edit({{ $specie->id }})" title="Edit">
                                                <i class="bx bx-edit text-dark fs-5"></i>
                                            </a>
                                            <a href="javascript:void(0)" wire:click="confirmDelete({{ $specie->id }})" title="Delete">
                                                <i class="bx bx-trash text-danger fs-5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $species->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
