<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="bs-stepper-pan">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="">
                                    @php $editorId = 'overVirew-' . $this->getId(); @endphp
                                    <livewire:admin.common.ckeditor-component model="about" :value="$about"
                                        editor-id="{{ $editorId }}" wire:model.defer="about" />
                                      @error('about')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="border border-1 p-4 rounded">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Upload Image <span class="text-danger">*</span>
                                        </label>

                                        <input type="file" wire:model="overview_image"
                                        accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                            class="form-control @error('overview_image') is-invalid @enderror">
                                        <small>Expected aspect ratio is 4:3 (e.g. 800x600 px).</small><br>
                                        @error('overview_image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <label class="form-label">
                                        {{ $isEditing ? 'Current' : 'Preview' }}
                                    </label>

                                    <div class="border bg-light text-center p-2 position-relative"
                                        style="height: 143px; overflow: hidden;">

                                        @if ($overview_image)
                                            <div wire:loading.delay wire:target="overview_image"
                                                class="d-flex align-items-center justify-content-center h-100 position-absolute w-100 bg-white z-3"
                                                style="top: 0; left: 0;">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Uploading...</span>
                                                </div>
                                            </div>
                                        @endif

                                        <div wire:loading.remove wire:target="overview_image"
                                            class="h-100 position-relative">
                                            @if ($overview_image)
                                                <img src="{{ $overview_image->temporaryUrl() }}"
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
                                                <span
                                                    class="text-muted d-flex align-items-center justify-content-center h-100">
                                                    No Image Selected
                                                </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button type="submit" wire:target="store" wire:loading.attr="disabled"
                                    class="btn btn-primary" id="submitOverview">
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
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
