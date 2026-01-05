<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        @php $editorId = 'Habitat-' . $this->getId(); @endphp
                        <livewire:admin.common.ckeditor-component model="Short Description" :value="$habitatt_short_description"
                            editor-id="{{ $editorId }}" wire:model.defer="habitatt_short_description" />
                        @error('habitatt_short_description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
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
