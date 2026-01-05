<div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form wire:submit.prevent="storeTraveTip">
                    <div class="row">
                        <div class="col-md-12 p-4 ">
                            @php $editorId = 'safetyTips-' . $this->getId(); @endphp
                            <livewire:admin.common.ckeditor-component model="Safety Tips" :value="$safetyTips"
                                editor-id="{{ $editorId }}" wire:model.defer="safetyTips" />
                            @error('safetyTips')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-12 text-end mt-4">
                            <button type="submit" wire:target="storeTraveTip" wire:loading.attr="disabled"
                                class="btn btn-primary" id="submitOverview">
                                <span wire:loading.remove wire:target="storeTraveTip">
                                    Submit
                                </span>
                                <span wire:loading wire:target="storeTraveTip">
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
</div>
