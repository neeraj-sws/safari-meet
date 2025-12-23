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
                                    wire:change="toggleStatus({{ $characterDetails['park_details_tabs_id'] }})"
                                    @checked($characterDetails['status']) id="{{ $characterDetails['park_details_tabs_id'] }}"
                                    type="checkbox" role="switch">
                            </div>
                        </div>
                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                @php $slug = Str::slug($characterDetails['title'], '_'); @endphp
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','safari-information')"
                                    class="list-group-item py-1 {{ $activeTabe == 'safari-information' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('safari-information')"><span>Safari Information</span></a>
                                <a href="javascript:;"
                                    onclick="updateTab('{{ $slug }}','safari-booking-process')"
                                    class="list-group-item py-1 {{ $activeTabe == 'safari-booking-process' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('safari-booking-process')"><span>Safari Booking
                                        Process</span></a>
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','park-dos')"
                                    class="list-group-item py-1 {{ $activeTabe == 'park-dos' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('park-dos')"><span>Park Do's</span></a>
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','park-donts')"
                                    class="list-group-item py-1 {{ $activeTabe == 'park-donts' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('park-donts')"><span>Park Dont's</span></a>
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','zone-list')"
                                    class="list-group-item py-1 {{ $activeTabe == 'zone-list' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('zone-list')"><span>Zone List</span></a>
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','park-timing')"
                                    class="list-group-item py-1 {{ $activeTabe == 'park-timing' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('park-timing')"><span>Park Timings</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                @if ($activeTabe == 'safari-information')
                    <livewire:admin.park.details.information.information :park="$park" :characterstic="$characterDetails"
                        :key="'information-' . $characterDetails['park_details_tabs_id']" />
                @elseif ($activeTabe == 'safari-booking-process')
                    <livewire:admin.park.details.information.safari-booking-process :park="$park" :characterstic="$characterDetails"
                        :key="'safari-booking-process-' . $characterDetails['park_details_tabs_id']" />
                @elseif ($activeTabe == 'park-dos')
                    <livewire:admin.park.details.information.park-dos :park="$park" :characterstic="$characterDetails"
                        :key="'park-dos-' . $characterDetails['park_details_tabs_id']" />
                @elseif ($activeTabe == 'park-donts')
                    <livewire:admin.park.details.information.park-donts :park="$park" :characterstic="$characterDetails"
                        :key="'park-donts-' . $characterDetails['park_details_tabs_id']" />
                @elseif ($activeTabe == 'zone-list')
                    <livewire:admin.park.details.information.zone-manager :$park characterstic="$characterDetails"
                        :key="'zone-list-' . $characterDetails['park_details_tabs_id']" />
                @elseif ($activeTabe == 'park-timing')
                    <livewire:admin.park.details.information.park-timing-component :$park
                        characterstic="$characterDetails" :key="'park-timing-' . $characterDetails['park_details_tabs_id']" />
                @endif
            </div>
        </div>
    </div>
</div>
