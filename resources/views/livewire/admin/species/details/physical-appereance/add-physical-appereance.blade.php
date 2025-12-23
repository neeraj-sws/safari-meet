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
                                    wire:change.live="toggleStatus({{ $characterDetails['species_details_characterstic_id'] }})"
                                    @checked($characterDetails['status'])
                                    id="{{ $characterDetails['species_details_characterstic_id'] }}" type="checkbox"
                                    role="switch">
                            </div>
                        </div>
                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                @php $slug = Str::slug($characterDetails['title'], '_'); @endphp
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','adaptations')"
                                    class="list-group-item py-1 {{ $activeTabe == 'adaptations' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('adaptations')"><span>Adaptations</span></a>
                                 <a href="javascript:;" onclick="updateTab('{{ $slug }}','adaptation-details')"
                                    class="list-group-item py-1 {{ $activeTabe == 'adaptation-details' ? 'active text-white' : '' }} "
                                    wire:click="changeTab('adaptation-details')"><span>Adaptations Details</span></a>
                                 <a href="javascript:;" onclick="updateTab('{{ $slug }}','appearance')"
                                    class="list-group-item py-1 {{ $activeTabe == 'appearance' ? 'active text-white' : '' }} "
                                    wire:click="changeTab('appearance')"><span>Appearance</span></a>
                                 <a href="javascript:;" onclick="updateTab('{{ $slug }}','diet')"
                                    class="list-group-item py-1 {{ $activeTabe == 'diet' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('diet')"><span>Diet</span></a>
                                 <a href="javascript:;" onclick="updateTab('{{ $slug }}','diet-details')"
                                    class="list-group-item py-1 {{ $activeTabe == 'diet-details' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('diet-details')"><span>Diet Details</span></a>
                                 <a href="javascript:;" onclick="updateTab('{{ $slug }}','habitat')"
                                    class="list-group-item py-1 {{ $activeTabe == 'habitat' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('habitat')"><span>Habitat</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-10">
                @if ($activeTabe == 'adaptations')
                    <livewire:admin.species.details.physical-appereance.adaptations :species="$species" :characterstic="$characterDetails"
                        :key="'adaptations-' . $characterDetails['species_details_characterstic_id']" />
                @elseif ($activeTabe == 'adaptation-details')
                    <livewire:admin.species.details.physical-appereance.adaptation-details :species="$species"
                        :characterstic="$characterDetails" :key="'adaptation-details-' . $characterDetails['species_details_characterstic_id']" />
                @elseif ($activeTabe == 'appearance')
                    <livewire:admin.species.details.physical-appereance.appearance :species="$species" :characterstic="$characterDetails"
                        :key="'appearance-' . $characterDetails['species_details_characterstic_id']" />
                @elseif ($activeTabe == 'diet')
                    <livewire:admin.species.details.lifestyle.diet :species="$species" :characterstic="$characterDetails"
                        :key="'diet-' . $characterDetails['species_details_characterstic_id']" />
                @elseif ($activeTabe == 'diet-details')
                    <livewire:admin.species.details.lifestyle.diet-details-component :species="$species"
                        :characterstic="$characterDetails" :key="'diet-details' . $characterDetails['species_details_characterstic_id']" />
                @elseif ($activeTabe == 'habitat')
                    <livewire:admin.species.details.lifestyle.habitat :species="$species" :characterstic="$characterDetails"
                        :key="'habitat-' . $characterDetails['species_details_characterstic_id']" />
                @endif
            </div>
        </div>
    </div>
</div>
