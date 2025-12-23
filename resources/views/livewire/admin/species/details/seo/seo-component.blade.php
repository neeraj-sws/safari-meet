<div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="store">
                            <!-- Meta Title -->
                            <div class="mb-3">
                                <label class="form-label">Meta Title <span class="text-danger">*</span> </label>
                                <small class="text-muted float-end" id="meta-Title-count"
                                    x-text="$wire.meta_title.length"></small>
                                <textarea
                                    class="form-control text-capitalize @error('meta_title') is-invalid @enderror "
                                    rows="2" wire:model="meta_title"
                                    oninput="filterAndFormatInputs(this,{allowAlpha:true,allowNumbers:true,allowedSpecialChars:`,:''.|()/-`})"
                                    placeholder="Enter Meta Title"></textarea>
                                @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Meta Description -->
                            <div class="mb-3">
                                <label class="form-label">Meta Description <span class="text-danger">*</span> </label>
                                <small class="text-muted float-end" id="meta-Title-count"
                                    x-text="$wire.meta_description.length"></small>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                    oninput="filterAndFormatInputs(this,{allowAlpha:true,allowNumbers:true,allowedSpecialChars:`,:''.|()/-`})"
                                    wire:model="meta_description" rows="3"
                                    placeholder="Enter Meta Description"></textarea>
                                @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Meta Image -->
                            <div class="mb-3">
                                <label class="form-label">Meta Image (Optional)</label>

                                <input type="file" class="form-control @error('meta_image') is-invalid @enderror"
                                    wire:model="meta_image" accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP">

                                @error('meta_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <!-- Preview -->
                                @if($meta_image)
                                <div class="mt-2">
                                    <img src="{{ $meta_image->temporaryUrl() }}" class="img-thumbnail"
                                        style="max-width: 200px;">
                                </div>
                                @elseif($species->meta_image)
                                <div class="mt-2">
                                    <img src="{{ asset($species->meta_image) }}" class="img-thumbnail"
                                        style="max-width: 200px;">
                                </div>
                                @endif
                            </div>


                            <div class="text-end">
                                <button type="submit" class="btn btn-sm btn-primary px-5" wire:loading.attr="disabled">
                                    {{ $isEditing ? 'Update' : 'Save' }}
                                    <i class="spinner-border spinner-border-sm" wire:loading.delay
                                        wire:target="{{ $isEditing ? 'update' : 'store' }}"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
