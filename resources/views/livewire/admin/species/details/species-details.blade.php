<div class="container">
    @include('livewire.components.breadcrumb', [
        'menu' => $pageTitle,
        'submenus' => [['Species' => route('admin.species.species')], 'Details'],
        'backUrl' => true,
    ])

    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills mb-3" role="tablist">
                @foreach ($characterstics as $characterstic)
                    @php $slug = Str::slug($characterstic?->title, '_'); @endphp
                    <li class="nav-item" role="presentation">
                        <a class="nav-link pe-auto {{ $showNavTab->id == $characterstic->id ? 'active' : '' }}"
                            onclick="updateTab('{{ $slug }}')" data-bs-toggle="pill" href="#"
                            wire:click="toggleStatus({{ $characterstic->id }})" role="tab">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">{{ $characterstic->title }}</div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade active show" role="tabpanel">
            @if ($showNavTab->id == 1)
                <livewire:admin.species.details.overview.add-over-view :species="$species_Data" :characterstic="$hasActiveData"
                    :key="'overview-' . $characterstic->id" />
            @elseif ($showNavTab->id == 2)
                <livewire:admin.species.details.physical-appereance.physical-appereance :species="$species_Data"
                    :characterstic="$hasActiveData" :key="'physical-appereance-' . $characterstic->id" />
            @elseif ($showNavTab->id == 3)
                {{-- <livewire:admin.species.details.lifestyle.lifestyle-component :species="$species_Data" :characterstic="$hasActiveData"
                    :key="'lifestyle-' . $characterstic->id" /> --}}
            @elseif ($showNavTab->id == 4)
                <livewire:admin.species.details.threat.threat-component :species="$species_Data" :characterstic="$hasActiveData"
                    :key="'threat-' . $characterstic->id" />
            @elseif ($showNavTab->id == 5)
                <livewire:admin.species.details.intresting-facts.intresting-facts-component :species="$species_Data"
                    :characterstic="$hasActiveData" :key="'intresting-facts-' . $characterstic->id" />
            @elseif($showNavTab->id == 9)
                <livewire:admin.species.details.seo.s-e-o-component :species="$species_Data" :characterstic="$hasActiveData"
                    :key="'seo-' . $characterstic->id" />
            @else
                <livewire:admin.species.details.dynamic-tab.dynamic-tab-component :species="$species_Data" :characterstic="$hasActiveData"
                    :character="$characterstic" :key="'dynamic-tab-' . $hasActiveData['species_characterstics'] . $characterstic->id" />
            @endif

        </div>
    </div>

</div>
