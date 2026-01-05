<div>
    <!-- Add Diet Button -->
    <div class="col-lg-12 mt-3 text-end">
        <button type="button" class="btn btn-primary" wire:click="addAbout">Add About</button>
    </div>

    <!-- Inline About Form -->
    @if ($showAboutModal)
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $modalTitle }}</h5>
                <button class="btn btn-sm btn-danger" wire:click="$set('showAboutModal', false)">×</button>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="saveAbout">
                    <!-- Heading Input -->
                    <div class="mb-3" x-data="{ heading: @entangle('heading') }">
                        <label class="form-label">Heading <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control text-capitalize @error('heading') is-invalid @enderror"
                            oninput="filterAndFormatInputs(this, {allowAlpha: true, allowNumbers:true,allowedSpecialChars: '-()./,&:\'?\''})"
                            x-model="heading">
                        @error('heading')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Upload Image <span class="text-danger">*</span></label>
                            <input type="file" wire:model="aboutImage"
                                accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                class="form-control @error('aboutImage') is-invalid @enderror">
                            <small>Expected aspect ratio is 3:4 (e.g. 600x800 px).</small> <br>
                            @error('aboutImage')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label>Preview</label>
                            <div class="border bg-light text-center p-2 position-relative"
                                style="height: 143px; overflow: hidden;">
                                @if ($aboutImage)
                                    <div wire:loading.delay wire:target="aboutImage"
                                        class="d-flex align-items-center justify-content-center h-100 position-absolute w-100 bg-white z-3"
                                        style="top: 0; left: 0;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Uploading...</span>
                                        </div>
                                    </div>
                                @endif
                                <div wire:loading.remove wire:target="aboutImage" class="h-100 position-relative">
                                    @if ($aboutImage)
                                        <img src="{{ $aboutImage->temporaryUrl() }}"
                                            class="img-fluid h-100 object-fit-contain">
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle z-3"
                                            style="padding:0.2rem 0.4rem" wire:click="removeAboutImage">×</button>
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
                    </div>

                    <hr>

                    @php $editorId = 'AddAbout-' . $this->getId(); @endphp
                    <livewire:admin.common.ckeditor-component wire:model.defer="description"
                        editor-id="{{ $editorId }}" model="AddAbout" :value="$description" :key="$editorId" />
                    @error('description')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror

                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-secondary me-2"
                            wire:click="$set('showAboutModal', false)">Cancel</button>

                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="saveAbout">Save</span>
                            <span wire:loading wire:target="saveAbout">
                                <span class="spinner-border spinner-border-sm me-1" role="status"
                                    aria-hidden="true"></span>
                                Saving...
                            </span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    @endif

    <!-- Diet List -->
    <div class="row mt-4">
        @forelse ($aboutData as $about)
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <strong>{{ $about->title }}</strong>
                        <div>
                            <button type="button" wire:click="editAbout({{ $about->id }})"
                                class="btn btn-sm btn-light text-dark me-1">Edit</button>
                            <button type="button" wire:click="deleteAbout({{ $about->id }})"
                                class="btn btn-sm btn-danger">Delete</button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (!empty($about->short_description))
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <small>{!! $about->short_description !!}</small>
                                    </div>
                                </li>
                            </ul>
                        @else
                            <p class="text-muted">No details added yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted text-center">No About added yet.</p>
            </div>
        @endforelse
    </div>
</div>
