<div class="container">
    <div class="row">
        <div class="col-lg-2">
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
                            <a href="javascript:;" onclick="updateTab('{{ $slug }}','about')"
                                class="list-group-item py-1 {{ $activeTabe == 'about' ? 'active text-white' : '' }}"
                                wire:click="changeTab('about')"><span>About</span></a>
                            <a href="javascript:;" onclick="updateTab('{{ $slug }}','zoological-identity')"
                                class="list-group-item py-1 {{ $activeTabe == 'zoological-identity' ? 'active text-white' : '' }} "
                                wire:click="changeTab('zoological-identity')"><span>Zoological Identity</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            @if ($activeTabe == 'about')
                <livewire:admin.species.details.overview.about :species="$species" :characterstic="$characterDetails" :key="'about-' . $characterDetails['species_details_characterstic_id']" />
            @elseif ($activeTabe == 'zoological-identity')
                <livewire:admin.species.details.overview.zoological-identity :species="$species" :characterstic="$characterDetails"
                    :key="'zoological-identity-' . $characterDetails['species_details_characterstic_id']" />
            @endif
        </div>
    </div>
</div>
