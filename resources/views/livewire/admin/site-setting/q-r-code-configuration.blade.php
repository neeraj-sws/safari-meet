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
                        <label class="form-label">UPI ID *</label>
                        <input type="text" class="form-control" wire:model="key.UPI_ID">
                        @error('key.UPI_ID') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">UPI Merchant Name *</label>
                        <input type="text" class="form-control" wire:model="key.UPI_MERCHANT_NAME">
                        @error('key.UPI_MERCHANT_NAME') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

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
