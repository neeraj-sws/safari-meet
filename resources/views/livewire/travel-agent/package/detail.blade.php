<div class="container" id="details">
    @include('livewire.travel-agent.common.breadcrumb', [
    'menu' => $pageTitle,
    'submenus' => [['Package ' => route('agent.package.package')], 'Details'],
    'backButton' => true,
    'backUrl' => route('agent.package.package'),
    ])

    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills mb-3" role="tablist">
                @foreach ($characterstics as $characterstic)
                @php $slug = Str::slug($characterstic?->title, '_'); @endphp
                <li class="nav-item" role="presentation">
                    <a class="nav-link pe-auto {{ $showNavTab->id == $characterstic->id ? 'active' : '' }}"
                        data-bs-toggle="pill" href="#" onclick="updateTab('{{ $slug }}')"
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
            <livewire:admin.package.details.banner-images :package="$package" :characterstic="$hasActiveData"
                :key="'bannerImages-' . $characterstic->id" />
            @elseif ($showNavTab->id == 2)
            <livewire:admin.package.details.itinerary :package="$package" :characterstic="$hasActiveData"
                :key="'itinerary-' . $characterstic->id" />
            @elseif ($showNavTab->id == 3)
            <livewire:admin.package.details.inclusions :package="$package" :characterstic="$hasActiveData" :type="1"
                :key="'inclusions-' . $characterstic->id" />
            @elseif ($showNavTab->id == 4)
            <livewire:admin.package.details.inclusions :package="$package" :characterstic="$hasActiveData" :type="2"
                :key="'exclusions-' . $characterstic->id" />
            @elseif ($showNavTab->id == 5)
            <livewire:admin.package.details.safari-accommodations :package="$package" :characterstic="$hasActiveData"
                :key="'accommodations-' . $characterstic->id" />
            @elseif ($showNavTab->id == 6)
            <livewire:admin.package.details.ratings :package="$package" :characterstic="$hasActiveData" :type="2"
                :key="'exclusions-' . $characterstic->id" />
            @elseif ($showNavTab->id == 7)
            <livewire:admin.package.details.things-to-carry :package="$package" :characterstic="$hasActiveData"
                :key="'thingstocarry-' . $characterstic->id" />
            @elseif ($showNavTab->id == 8)
            <livewire:admin.package.details.f-a-q-component :package="$package" :characterstic="$hasActiveData"
                :key="'ratings-' . $characterstic->id" />
            @elseif ($showNavTab->id == 9)
            <livewire:admin.package.details.discussion :package="$package" :characterstic="$hasActiveData"
                :key="'discussion-' . $characterstic->id" />
            @else
            <livewire:admin.package.details.common-tabs :package="$package" :type="2" :characterstic="$hasActiveData"
                :key="$characterstic->id" />
            @endif

        </div>
    </div>
</div>
