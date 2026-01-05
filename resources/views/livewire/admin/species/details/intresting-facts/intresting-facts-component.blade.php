<div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid my-3">
                            <div class="form-check form-switch form-check-info">
                                <label class="form-check-label">Show In Front</label>
                                <input class="form-check-input"
                                    wire:change.live="toggleStatus({{ $characterDetails['species_details_characterstic_id'] }})"
                                    @checked($characterDetails['status']) id="{{ $characterDetails['species_details_characterstic_id'] }}" type="checkbox"
                                    role="switch">
                            </div>
                        </div>
                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                 @php $slug = Str::slug($characterDetails['title'], '_'); @endphp
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','interesting-facts')"
                                    class="list-group-item py-1 {{ $activeTabe == 'interesting-facts' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('interesting-facts')"><span>Interesting Facts</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="bs-stepper linear">
                    <div class="bs-stepper-content">
                        <div class="card">
                            <div class="card-body">
                                <form wire:submit.prevent="store">
                                    <div id="test-l" class="bs-stepper-pan">
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        @php $editorId = 'InterestingFacts-' . $this->getId(); @endphp
                                                        <livewire:admin.common.ckeditor-component
                                                            model="Short Description" :value="$short_description"
                                                            editor-id="{{ $editorId }}"
                                                            wire:model.defer="short_description" />
                                                        @error('short_description')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 text-end mt-4">
                                                    <button type="submit" wire:target="store"
                                                        wire:loading.attr="disabled" class="btn btn-primary"
                                                        id="submitOverview">
                                                        <span wire:loading.remove wire:target="store">
                                                            Submit
                                                        </span>
                                                        <span wire:loading wire:target="store">
                                                            <span class="spinner-border spinner-border-sm me-1"
                                                                role="status" aria-hidden="true"></span>
                                                            Submitting...
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
