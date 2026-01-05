<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">User Shared Safari Price *</label>
                        <input type="number" class="form-control" wire:model.defer="key.USER_SAFARI_PRICE">
                        @error('key.USER_SAFARI_PRICE') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Agent Shared Safari Price *</label>
                        <input type="number" class="form-control" wire:model.defer="key.AGENT_SAFARI_PRICE">
                        @error('key.AGENT_SAFARI_PRICE') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Agent Package Safari Price *</label>
                        <input type="number" class="form-control" wire:model.defer="key.AGENT_PACKAGE_PRICE">
                        @error('key.AGENT_PACKAGE_PRICE') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">QR Code Image</label>
                        <input type="file"
                            class="form-control"
                            accept="image/*"
                            wire:model="key.QR_IMAGE">

                        @error('key.QR_IMAGE') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Preview before upload --}}
                    @if ($key['QR_IMAGE'])
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Preview (New)</label><br>
                            <img src="{{ $key['QR_IMAGE']->temporaryUrl() }}"
                                 class="img-thumbnail"
                                 style="max-height: 150px;">
                        </div>
                    @endif

                    {{-- Show saved image --}}
                    @if ($existingQrImage && !$key['QR_IMAGE'])
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Current QR Code</label><br>
                            <img src="{{ asset($existingQrImage) }}"
                                 class="img-thumbnail"
                                 style="max-height: 150px;">
                        </div>
                    @endif

                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        Save
                        <span wire:loading wire:target="save" class="spinner-border spinner-border-sm"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
