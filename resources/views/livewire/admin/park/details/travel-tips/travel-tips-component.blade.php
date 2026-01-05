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
                                    wire:change.live="toggleStatus({{ $characterDetails['park_details_tabs_id'] }})"
                                    @checked($characterDetails['status']) id="{{ $characterDetails['park_details_tabs_id'] }}"
                                    type="checkbox" role="switch">
                            </div>
                        </div>
                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                @php $slug = Str::slug($characterDetails['title'], '_'); @endphp
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','weather-info')"
                                    class="list-group-item py-1 {{ $activeTabe == 'weather-info' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('weather-info')"><span>Weather Info</span></a>
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','safety-tips')"
                                    class="list-group-item py-1 {{ $activeTabe == 'safety-tips' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('safety-tips')"><span>Safety Tips</span></a>
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','what-to-carry')"
                                    class="list-group-item py-1 {{ $activeTabe == 'what-to-carry' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('what-to-carry')"><span>What to Carry</span></a>
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','best-time-to-visit')"
                                    class="list-group-item py-1 {{ $activeTabe == 'best-time-to-visit' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('best-time-to-visit')"><span>Best Time to Visit</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                @if ($activeTabe == 'weather-info')
                    <livewire:admin.park.details.travel-tips.weather-info :park="$park" :characterstic="$characterDetails"
                        :key="'weather-info-' . $characterDetails['park_details_tabs_id']" />
                @elseif ($activeTabe == 'safety-tips')
                    <livewire:admin.park.details.travel-tips.safety-tips :park="$park" :characterstic="$characterDetails"
                        :key="'safari-traval-info-' . $characterDetails['park_details_tabs_id']" />
                @elseif ($activeTabe == 'what-to-carry')
                    <livewire:admin.park.details.travel-tips.what-to-carry :park="$park" :characterstic="$characterDetails"
                        :key="'what-to-carry-' . $characterDetails['park_details_tabs_id']" />
                @elseif ($activeTabe == 'best-time-to-visit')
                    <livewire:admin.park.details.travel-tips.best-time-to-visity :park="$park" :characterstic="$characterDetails"
                        :key="'best-time-to-visit-' . $characterDetails['park_details_tabs_id']" />
                @endif
            </div>
        </div>
    </div>
</div>
