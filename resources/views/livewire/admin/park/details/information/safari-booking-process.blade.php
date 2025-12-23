<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="row">
                    <div class="col-md-12">
                        @php $editorId = 'bookingprocess-' . $this->getId(); @endphp
                        <livewire:admin.common.ckeditor-component model="Safari booking Process" :value="$bookingProcess"
                            editor-id="{{ $editorId }}" wire:model.defer="bookingProcess" />
                        @error('bookingProcess')
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
