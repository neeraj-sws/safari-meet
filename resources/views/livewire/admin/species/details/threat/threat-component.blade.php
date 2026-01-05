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
                                    @checked($characterDetails['status'])
                                    id="{{ $characterDetails['species_details_characterstic_id'] }}" type="checkbox"
                                    role="switch">
                            </div>
                        </div>
                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                @php $slug = Str::slug($characterDetails['title'], '_'); @endphp
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','threats')"
                                    class="list-group-item py-1 {{ $activeTabe == 'threats' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('threats')"><span>Threats</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                @if ($activeTabe == 'threats')
                    <livewire:admin.species.details.threat.threats :species="$species" :characterstic="$characterDetails"
                        :key="'about-' . $characterDetails['species_details_characterstic_id']" />
                @endif
            </div>
        </div>
    </div>
</div>
