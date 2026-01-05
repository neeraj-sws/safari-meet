<!-- Upload Image Tab -->
<div class="col-12 mb-3">
    <label class="form-label">Upload Display Image</label>
    <input type="file" wire:model="display_image" id="display_image"
        accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
        class="form-control @error('display_image') is-invalid @enderror">
    @error('display_image')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="col-md-12 mb-4">
    <label class="form-label">
        {{ $isEditing ? 'Current' : 'Preview' }}
    </label>
    <div class="border bg-light text-center p-2 position-relative" style="height: 143px; overflow: hidden;">
        <div wire:loading wire:target="display_image" class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Uploading...</span>
        </div>

        @if ($display_image)
            <img src="{{ $display_image->temporaryUrl() }}" class="img-fluid h-100 object-fit-contain">
            <button type="button"
                class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle z-3"
                style="padding:0.2rem 0.4rem" wire:click="removeDisplayImage">
                ×
            </button>
        @elseif ($isEditing && !empty($previousImage))
            <img src="{{ asset($previousImage) }}" class="img-fluid h-100 object-fit-contain">
        @else
            <span class="text-muted d-flex align-items-center justify-content-center h-100">
                No Image Selected
            </span>
        @endif
    </div>
</div>

<!-- Actions -->
<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('createsaharedshafari', ['slug' => $sharedSafari->slug, 'type' => 'details']) }}"
        class="btn btn-sm border-bg blue-border-hover rounded-1 px-4 text-blue">
        Back
    </a>
    <button type="submit" class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1 px-4">
        Next
    </button>
</div>
