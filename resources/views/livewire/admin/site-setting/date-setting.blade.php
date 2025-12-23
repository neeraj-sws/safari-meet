<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit="save">
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="form-check form-switch">
                            <label class="form-label">Safari Date Start After</label>
                            <input class="form-control @error('key.safari_date_after') is-invalid @enderror "
                                type="number" role="switch" id="checkbox" wire:model="key.safari_date_after">
                            @error('key.safari_date_after')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="form-check form-switch">
                            <label class="form-label">Enquiry Date Start After</label>
                            <input class="form-control  @error('key.enquiry_date_after') is-invalid @enderror "
                                type="number" role="switch" id="checkbox" wire:model="key.enquiry_date_after">
                            @error('key.enquiry_date_after')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
