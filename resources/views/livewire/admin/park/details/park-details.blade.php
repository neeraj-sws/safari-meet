<div>
    <div class="container">
        @include('livewire.components.breadcrumb', [
            'menu' => $pageTitle,
            'submenus' => [['Parks' => route('admin.park.park')], 'Details'],
            'backButton' => true,
            'backUrl' => route('admin.park.park'),
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
                    <livewire:admin.park.details.key-info.keyinfo-component :park="$parkData" :characterstic="$hasActiveData"
                        :key="'keyinfo-' . $characterstic->id" />
                @elseif ($showNavTab->id == 2)
                    <livewire:admin.park.details.about.about-component :park="$parkData" :characterstic="$hasActiveData"
                        :key="'AboutPark-' . $characterstic->id" />
                @elseif ($showNavTab->id == 3)
                    <livewire:admin.park.details.information.information-component :park="$parkData" :characterstic="$hasActiveData"
                        :key="'SafariInformation-' . $characterstic->id" />
                @elseif ($showNavTab->id == 4)
                    <livewire:admin.park.details.accommodation.park-accommodation :park="$parkData" :characterstic="$hasActiveData"
                        :key="'parkAccommodation-' . $characterstic->id" />
                @elseif ($showNavTab->id == 5)
                    <livewire:admin.park.details.wildlife.wildlife-component :park="$parkData" :characterstic="$hasActiveData"
                        :key="'Wildlife-' . $characterstic->id" />
                @elseif ($showNavTab->id == 6)
                    <livewire:admin.park.details.reachability.reachability-component :park="$parkData"
                        :characterstic="$hasActiveData" :key="'Reachability-' . $characterstic->id" />
                @elseif ($showNavTab->id == 7)
                    <livewire:admin.park.details.travel-tips.travel-tips-component :park="$parkData" :characterstic="$hasActiveData"
                        :key="'TravelTips-' . $characterstic->id" />
                @elseif ($showNavTab->id == 9)
                    <livewire:admin.park.details.seo.seo-component :park="$parkData" :characterstic="$hasActiveData"
                        :key="'seo-' . $characterstic->id" />
                @elseif ($showNavTab->id == 11)
                    <livewire:admin.park.details.faq.park-faq :park="$parkData" :characterstic="$hasActiveData"
                        :key="'park-faq-' . $characterstic->id" />
                @else
                    <livewire:admin.park.details.tabs.dynamic-tab-component :park="$parkData" :characterstic="$hasActiveData"
                        :key="'dynamic-' . $showNavTab->id" />
                @endif

            </div>
        </div>

    </div>
</div>
