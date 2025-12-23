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
                                    @checked($characterDetails['status']) id="{{ $characterDetails['package_details_tabs_id'] }}" type="checkbox"
                                    role="switch">
                            </div>
                        </div>
                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                <a href="javascript:;"
                                    class="list-group-item py-1 {{ $activeTabe == 'Itinerary' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('Itinerary')"><span>Itinerary</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-10">
                <div class="secion-itinerary package-accordion mb-4" id="secion-itinerary">
                    <livewire:admin.common.itinerary :type="'2'" :id="$package->id">
                </div>
            </div>
        </div>
    </div>
</div>
