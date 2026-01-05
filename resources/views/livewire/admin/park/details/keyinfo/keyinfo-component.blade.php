<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-grid my-3">
                        <div class="form-check form-switch form-check-info">
                            <label class="form-check-label">Show In Front</label>
                            <input class="form-check-input"
                                wire:change.live="toggleStatus({{ $characterDetails['park_details_tabs_id'] }})"
                                @checked($characterDetails['status']) id="{{ $characterDetails['park_details_tabs_id'] }}"
                                type="checkbox" role="switch">
                        </div>
                    </div>
                    <div class="fm-menu">
                        <div class="list-group list-group-flush">
                            @php $slug = Str::slug($characterDetails['title'], '_'); @endphp
                            <a href="javascript:;" onclick="updateTab('{{ $slug }}','park-overview')"
                                class="list-group-item py-1 {{ $activeTabe == 'park-overview' ? 'active text-white' : '' }}"
                                wire:click="changeTab('park-overview')"><span>Park Overview</span></a>
                            <a href="javascript:;" onclick="updateTab('{{ $slug }}','safari-travel-info')"
                                class="list-group-item py-1 {{ $activeTabe == 'safari-travel-info' ? 'active text-white' : '' }} "
                                wire:click="changeTab('safari-travel-info')"><span>Safari and Travel Info</span></a>
                            <a href="javascript:;" onclick="updateTab('{{ $slug }}','safari-travel-info')"
                                class="list-group-item py-1 {{ $activeTabe == 'timing-and-cost' ? 'active text-white' : '' }} "
                                wire:click="changeTab('timing-and-cost')"><span>Timings & Cost</span></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-12 col-lg-9">
            @if ($activeTabe == 'park-overview')
                <livewire:admin.park.details.key-info.park-overview :park="$park" :characterstic="$characterDetails"
                    :key="'overview-' . $characterDetails['park_tabs_id']" />
            @elseif ($activeTabe == 'safari-travel-info')
                <livewire:admin.park.details.key-info.safari-travel-info :park="$park" :characterstic="$characterDetails"
                    :key="'safari-traval-info-' . $characterDetails['park_tabs_id']" />
            @elseif ($activeTabe == 'timing-and-cost')
                <livewire:admin.park.details.key-info.timing-and-cost :park="$park" :characterstic="$characterDetails"
                    :key="'timing-and-cost-' . $characterDetails['park_tabs_id']" />
            @endif
        </div>
    </div>
</div>
