<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        @php $editorId = 'physicalAppereacnce-' . $this->getId(); @endphp
                        <livewire:admin.common.ckeditor-component model="Adaptations" :value="$adaptations_short_discription"
                            editor-id="{{ $editorId }}" wire:model.defer="adaptations_short_discription" />
                        @error('adaptations_short_discription')
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
