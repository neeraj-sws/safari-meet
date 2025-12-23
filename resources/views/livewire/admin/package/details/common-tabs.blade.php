<div>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid my-3">
                                <div class="form-check form-switch form-check-info">
                                    <label class="form-check-label">Show In Front</label>
                                    <input class="form-check-input"
                                        wire:change.live="toggleStatus({{ $characterDetails['package_details_tabs_id'] }})"
                                        @checked($characterDetails['status'])
                                        id="{{ $characterDetails['package_details_tabs_id'] }}" type="checkbox"
                                        role="switch">
                                </div>
                            </div>
                            <div class="fm-menu">
                                <div class="list-group list-group-flush">
                                    <a href="javascript:;"
                                        class="list-group-item py-1 {{ $activeTabe == 'discussion' ? 'active text-white' : '' }}"
                                        wire:click="changeTab('discussion')"><span>{{ $pageTitle }}</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-10">
                    <div class="card">
                        <div class="card-body">
                            <form wire:submit.prevent="store">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="">
                                                <div class="mb-3">
                                                    @php $editorId =  $package->slug.'-' . $this->getId(); @endphp
                                                    <livewire:admin.common.ckeditor-component
                                                        model="{{ $pageTitle }}" :value="$short_description"
                                                        editor-id="{{ $editorId }}"
                                                        wire:model.defer="short_description" />
                                                    @error('short_description')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-end mt-4">
                                            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="store">Save</span>
                                                <span wire:loading wire:target="store">
                                                    <span class="spinner-border spinner-border-sm"></span> Saving...
                                                </span>
                                            </button>
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
