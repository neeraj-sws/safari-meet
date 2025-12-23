<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="row">
                    <div class="col-lg-12">
                        <div class=" p-4 ">
                            <div class="mb-3">
                                @php $editorId = 'threat-' . $this->getId(); @endphp
                                <livewire:admin.common.ckeditor-component model="Short Description" :value="$short_description"
                                    editor-id="{{ $editorId }}" wire:model.defer="short_description" />
                                @error('short_description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    Upload Image <span class="text-danger">*</span>
                                </label>

                                <input type="file" wire:model="image"
                                    accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                    class="form-control @error('image') is-invalid @enderror">
                                <small>Expected aspect ratio is 3:4 (e.g. 600 x 800 px).</small><br>
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="border border-1 p-4 rounded">
                            <label class="form-label">
                                {{ $isEditing ? 'Current' : 'Preview' }}
                            </label>

                            <div class="border bg-light text-center p-2 position-relative"
                                style="height: 143px; overflow: hidden;">

                                @if ($image)
                                    <div wire:loading.delay wire:target="image"
                                        class="d-flex align-items-center justify-content-center h-100 position-absolute w-100 bg-white z-3"
                                        style="top: 0; left: 0;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Uploading...</span>
                                        </div>
                                    </div>
                                @endif

                                <div wire:loading.remove wire:target="image" class="h-100 position-relative">
                                    @if ($image)
                                        <img src="{{ $image->temporaryUrl() }}"
                                            class="img-fluid h-100 object-fit-contain">
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle z-3"
                                            style="padding:0.2rem 0.4rem" wire:click="removeOverViewImage">
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
                    </div>
                    <div class="col-lg-12">
                        <div class="my-3">
                            @php $editorId = 'Addthreat-' . $this->getId(); @endphp
                            <livewire:admin.common.ckeditor-component model="Threat" :value="$threat"
                                editor-id="{{ $editorId }}" wire:model.defer="threat" />
                            @error('threat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 text-end mt-4">
                        <button type="submit" wire:target="store" wire:loading.attr="disabled" class="btn btn-primary"
                            id="submitOverview">
                            <span wire:loading.remove wire:target="store">
                                Submit
                            </span>
                            <span wire:loading wire:target="store">
                                <span class="spinner-border spinner-border-sm me-1" role="status"
                                    aria-hidden="true"></span>
                                Submitting...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
