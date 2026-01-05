<div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            @foreach (['Length', 'Weight', 'Height'] as $trait)
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>{{ $trait }} Male <span class="text-danger">*</span></label>
                                            <input type="text" wire:model="traits.{{ $trait }}.Male"
                                            oninput="filterAndFormatInputs(this,{allowNumbers:true,allowAlpha:true,allowedSpecialChars:`,–.()''/-`})"
                                            class="form-control @error("traits.$trait.Male") is-invalid @enderror"
                                            placeholder="Male {{ $trait }}">
                                        @error("traits.$trait.Male")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label>{{ $trait }} Female <span class="text-danger">*</span></label>
                                        <input type="text" wire:model="traits.{{ $trait }}.Female"
                                             oninput="filterAndFormatInputs(this,{allowNumbers:true,allowAlpha:true,allowedSpecialChars:`,–.()''/-`})"
                                        class="form-control @error("traits.$trait.Female") is-invalid @enderror"
                                        placeholder="Female {{ $trait }}">
                                    @error("traits.$trait.Female")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="position-relative">
                        @php $editorId = 'Appearance-' . $this->getId(); @endphp
                        <livewire:admin.common.ckeditor-component model="Appearance" :value="$appearance_short_discription"
                            editor-id="{{ $editorId }}" wire:model.defer="appearance_short_discription" />
                        @error('appearance_short_discription')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-12 text-end mt-4">
                    <button type="submit" wire:target="store" wire:loading.attr="disabled"
                        class="btn btn-primary" id="submitOverview">
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
</div>
