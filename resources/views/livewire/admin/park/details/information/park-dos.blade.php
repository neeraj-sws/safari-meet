<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="row">
                    <div class="col-md-12">
                        @php $editorId = 'parkruledos-' . $this->getId(); @endphp
                        <livewire:admin.common.ckeditor-component model="Park Rules Do's" :value="$doRules"
                            editor-id="{{ $editorId }}" wire:model.defer="doRules" />
                        @error('doRules')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="border border-1 p-4 rounded">
                            <div class="mb-3">
                                <label class="form-label">
                                    Upload Do's Image <span class="text-danger">*</span>
                                </label>

                                <input type="file" wire:model="dos_image"
                                    accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                    class="form-control @error('dos_image') is-invalid @enderror">
                                <small>Expected aspect ratio is 3:4 (e.g. 600x800 px).</small> <br>
                                @error('dos_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <label class="form-label">
                                {{ $isEditing ? 'Current' : 'Preview' }}
                            </label>

                            <div class="border bg-light text-center p-2 position-relative"
                                style="height: 143px; overflow: hidden;">

                                @if ($dos_image)
                                    <div wire:loading.delay wire:target="dos_image"
                                        class="d-flex align-items-center justify-content-center h-100 position-absolute w-100 bg-white z-3"
                                        style="top: 0; left: 0;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Uploading...</span>
                                        </div>
                                    </div>
                                @endif

                                <div wire:loading.remove wire:target="dos_image" class="h-100 position-relative">
                                    @if ($dos_image)
                                        <img src="{{ $dos_image->temporaryUrl() }}"
                                            class="img-fluid h-100 object-fit-contain">
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle z-3"
                                            style="padding:0.2rem 0.4rem" wire:click="removeDosImage">
                                            ×
                                        </button>
                                    @elseif ($isEditing && !empty($doPreviousImage))
                                        <img src="{{ asset($doPreviousImage) }}"
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
