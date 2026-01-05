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
                                    wire:change.live="toggleStatus({{ $characterDetails['shared_safari_details_tabs_id'] }})"
                                    @checked($characterDetails['status']) id="{{ $characterDetails['shared_safari_details_tabs_id'] }}" type="checkbox"
                                    role="switch">
                            </div>
                        </div>
                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                <a href="javascript:;"
                                    class="list-group-item py-1 {{ $activeTabe == 'thingstocarry' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('thingstocarry')"><span>Things To Carry</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                <livewire:admin.common.things-to-carry :type="'1'" :id="$safari->id">
            </div>
        </div>
    </div>
</div>
