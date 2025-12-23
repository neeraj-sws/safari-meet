<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit="save">
                <div class="row">
                    <!-- Facebook Link -->
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Facebook Link</label>
                        <input class="form-control @error('key.facebook_link') is-invalid @enderror" type="url"
                            wire:model="key.facebook_link">
                        @error('key.facebook_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <label class="form-label">Enable Facebook Link</label>
                            <input class="form-check-input" type="checkbox" role="switch" wire:model="key.facebook_status">
                        </div>
                    </div>

                    <!-- Twitter Link -->
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Twitter Link</label>
                        <input class="form-control @error('key.twitter_link') is-invalid @enderror" type="url"
                            wire:model="key.twitter_link">
                        @error('key.twitter_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <label class="form-label">Enable Twitter Link</label>
                            <input class="form-check-input" type="checkbox" role="switch" wire:model="key.twitter_status">
                        </div>
                    </div>

                    <!-- Instagram Link -->
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Instagram Link</label>
                        <input class="form-control @error('key.instagram_link') is-invalid @enderror" type="url"
                            wire:model="key.instagram_link">
                        @error('key.instagram_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <label class="form-label">Enable Instagram Link</label>
                            <input class="form-check-input" type="checkbox" role="switch"
                                wire:model="key.instagram_status">
                        </div>
                    </div>

                    <!-- LinkedIn Link -->
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">LinkedIn Link</label>
                        <input class="form-control @error('key.linkedin_link') is-invalid @enderror" type="url"
                            wire:model="key.linkedin_link">
                        @error('key.linkedin_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <label class="form-label">Enable LinkedIn Link</label>
                            <input class="form-check-input" type="checkbox" role="switch" wire:model="key.linkedin_status">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Pinterest Link</label>
                        <input class="form-control @error('key.pinterest_link') is-invalid @enderror" type="url"
                            wire:model="key.pinterest_link">
                        @error('key.pinterest_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <label class="form-label">Enable Pinterest Link</label>
                            <input class="form-check-input" type="checkbox" role="switch" wire:model="key.pinterest_status">
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        Save
                        <i class="spinner-border spinner-border-sm" wire:loading></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
