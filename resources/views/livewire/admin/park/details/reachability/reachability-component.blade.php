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
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','reachability')"
                                    class="list-group-item py-1 {{ $activeTabe == 'reachability' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('reachability')"><span>Reachability</span></a>
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','important-cities')"
                                    class="list-group-item py-1 {{ $activeTabe == 'important-cities' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('important-cities')"><span>Important Cities</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                @if ($activeTabe == 'reachability')
                    <livewire:admin.park.details.reachability.reachability :park="$park" :characterstic="$characterDetails"
                        :key="'reachability-' . $characterDetails['park_details_tabs_id']" />
                @elseif ($activeTabe == 'important-cities')
                    <livewire:admin.park.details.reachability.important-cities :park="$park" :characterstic="$characterDetails"
                        :key="'important-cities-' . $characterDetails['park_details_tabs_id']" />
                @endif
            </div>
        </div>
    </div>
</div>
