<div>
    <div class="card mb-4 rounded-3">
        <div class="card-body">
            <form wire:submit.prevent="saveCoverImage">
                <div class="row align-items-center">
                    <!-- Display the uploaded cover image -->
                    @if ($coverImage)
                        <div class="col-md-12 mb-3">
                            <img src="{{ $coverImage->temporaryUrl() }}" alt="Cover Image" class="img-fluid" />
                        </div>
                    @endif
                    <div class="col-md-12 mb-3">
                        <label for="coverImage" class="form-label fw-semibold">Cover Image</label>
                        <input type="file" class="form-control" id="coverImage" wire:model="coverImage"
                            accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP">
                        <small>Expected Image 1800x300 px.</small><br>
                        @error('coverImage')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Save Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="saveCoverImage">Save</span>
                            <span wire:loading wire:target="saveCoverImage">Uploading...</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
