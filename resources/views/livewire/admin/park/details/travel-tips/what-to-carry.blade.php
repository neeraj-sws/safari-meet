<div id="AddWhattoCarry">
    <div class="text-end mb-3">
        @if (!$showForm)
        <button class="btn btn-primary" type="button" wire:click="showToCarry" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="showToCarry">Add What to Carry</span>
            <span wire:loading wire:target="showToCarry">
                <span class="spinner-border spinner-border-sm"></span> Loading...
            </span>
        </button>
        @else
        <button class="btn btn-danger" type="button" wire:click="hideToCarry" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="hideToCarry">Hide What to Carry</span>
            <span wire:loading wire:target="hideToCarry">
                <span class="spinner-border spinner-border-sm"></span> Hiding...
            </span>
        </button>
        @endif
    </div>

    @if ($showForm)
    <div class="card mb-3">
        <div class="card-header">Add What to Carry</div>
        <div class="card-body">
            <form wire:submit.prevent="storeWhatToCarry">
                <div class="mb-3">
                    <label class="form-label">What To Carry <sup class="text-danger">*</sup></label>
                    <select wire:model="whattocarry" id="whattocarry" class="form-select select2" multiple>
                        <option value="">-- Select Items --</option>
                        @foreach ($thingsToCarries as $carry)
                        <option value="{{ $carry->id }}">{{ $carry->title }}</option>
                        @endforeach
                    </select>
                    @error('whattocarry')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="text-end mb-2">
                    <button type="button" class="btn btn-sm btn-primary" wire:click="AddBlankFormList"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="AddBlankFormList">Add fields</span>
                        <span wire:loading wire:target="AddBlankFormList">
                            <span class="spinner-border spinner-border-sm"></span> Adding...
                        </span>
                    </button>
                </div>

                @foreach ($FormList as $index => $list)
                <div class="border p-3 mb-2">
                    <div class="text-end mb-2">
                        <button type="button" class="btn btn-sm btn-danger" wire:click="removeFormList({{ $index }})"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="removeFormList({{ $index }})">Remove</span>
                            <span wire:loading wire:target="removeFormList({{ $index }})">
                                <span class="spinner-border spinner-border-sm"></span>
                            </span>
                        </button>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model="FormList.{{ $index }}.heading"
                            placeholder="Enter Title Here...">
                        @error("FormList.$index.heading")
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Short Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" wire:model="FormList.{{ $index }}.short_description"
                            rows="3"></textarea>
                        @error("FormList.$index.short_description")
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                @endforeach

                <div class="text-end">
                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="storeWhatToCarry">Save</span>
                        <span wire:loading wire:target="storeWhatToCarry">
                            <span class="spinner-border spinner-border-sm"></span> Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Heading</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bestWhatToCarry as $item)
                    <tr>
                        <td>{{ $item->heading }}</td>
                        <td>{{ $item->short_description }}</td>
                        <td>
                            @if ($item->image)
                            <img src="{{ asset($item->image) }}" style="height:40px;">
                            @else
                            <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-secondary" wire:click="EditWhatToCarry({{ $item->id }})"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="EditWhatToCarry({{ $item->id }})">Edit</span>
                                <span wire:loading wire:target="EditWhatToCarry({{ $item->id }})">
                                    <span class="spinner-border spinner-border-sm"></span>
                                </span>
                            </button>

                            <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $item->id }})"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="confirmDelete({{ $item->id }})">Delete</span>
                                <span wire:loading wire:target="confirmDelete({{ $item->id }})">
                                    <span class="spinner-border spinner-border-sm"></span>
                                </span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No data found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing {{ $bestWhatToCarry->firstItem() }} to {{ $bestWhatToCarry->lastItem() }} of
                    {{ $bestWhatToCarry->total() }} entries
                </div>

                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-primary" wire:click="previousPage"
                        wire:loading.attr="disabled" wire:target="previousPage" @disabled($bestWhatToCarry->onFirstPage())>
                        <span wire:loading.remove wire:target="previousPage">Previous</span>
                        <span wire:loading wire:target="previousPage">
                            <span class="spinner-border spinner-border-sm me-1"></span>Loading...
                        </span>
                    </button>

                    @for ($page = 1; $page <= $bestWhatToCarry->lastPage(); $page++)
                        <button
                            class="btn btn-sm {{ $bestWhatToCarry->currentPage() == $page ? 'btn-primary' : 'btn-outline-primary' }}"
                            wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled"
                            wire:target="gotoPage({{ $page }})">
                            <span wire:loading.remove wire:target="gotoPage({{ $page }})">{{ $page }}</span>
                            <span wire:loading wire:target="gotoPage({{ $page }})">
                                <span class="spinner-border spinner-border-sm me-1"></span>
                            </span>
                        </button>
                        @endfor

                        <button class="btn btn-sm btn-outline-primary" wire:click="nextPage"
                            wire:loading.attr="disabled" wire:target="nextPage"
                            @disabled(!$bestWhatToCarry->hasMorePages())>
                            <span wire:loading.remove wire:target="nextPage">Next</span>
                            <span wire:loading wire:target="nextPage">
                                <span class="spinner-border spinner-border-sm me-1"></span>Loading...
                            </span>
                        </button>
                </div>
            </div>

        </div>
    </div>
    @if ($showEditForm)
    <div class="modal  show " tabindex="-1" style="opacity:1; background-color:#0606068c; display: block ">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit What To Carry</h5>
                    <button type="button" wire:click="closeEditModal" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="updateWhatToCarry">
                    <div class="modal-body">
                        <div class="">
                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('heading') is-invalid @enderror"
                                    wire:model="heading" placeholder="Enter Heading Here...">
                                @error('heading')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Short Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('short_description') is-invalid @enderror"
                                    wire:model="short_description" rows="3"
                                    placeholder="Enter Short Description"></textarea>
                                @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3 align-items-center">
                                <div class="col-12">
                                    <label class="form-label">Display Image <span class="text-danger">*</span></label>
                                    <input type="file" wire:model="image"
                                        accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                        class="form-control @error('image') is-invalid @enderror">
                                    @error('image')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">
                                        @if ($image)
                                        Preview
                                        @elseif ($previousImage)
                                        Current
                                        @else
                                        No Image
                                        @endif
                                    </label>
                                    <div class="border bg-light text-center p-2 position-relative overflow-hidden"
                                        style="height: 200px;">
                                        <div wire:loading.remove wire:target="image" class="h-100 position-relative">
                                            @if ($image)
                                            <img src="{{ $image->temporaryUrl() }}"
                                                class="img-fluid h-100 object-fit-contain">
                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle z-3"
                                                style="padding:0.2rem 0.4rem" wire:click="removeImage">
                                                ×
                                            </button>
                                            @elseif ($showEditForm && !empty($previousImage))
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
                    <div class="modal-footer">
                        <button type="button" wire:click="closeEditModal" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="updateWhatToCarry">Save</span>
                            <span wire:loading wire:target="updateWhatToCarry">
                                <span class="spinner-border spinner-border-sm"></span> Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
