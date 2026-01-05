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
                                    wire:change.live="toggleStatus({{ $characterstic['park_details_tabs_id'] }})"
                                    @checked($characterstic['status']) id="{{ $characterstic['park_details_tabs_id'] }}" type="checkbox"
                                    role="switch">
                            </div>
                        </div>
                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                <a href="javascript:;"
                                    class="list-group-item py-1 {{ $activeTabe == 'overview' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('overview')"><span>{{ $pageTitle }}</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="storeIntrestingFacts">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="">
                                            <div class="mb-3">
                                                @php $editorId =  $park->slug.'-' . $this->getId(); @endphp
                                                <livewire:admin.common.ckeditor-component model="{{ $pageTitle }}"
                                                    :value="$short_description" editor-id="{{ $editorId }}"
                                                    wire:model.defer="short_description" />
                                                @error('short_description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-end mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
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
