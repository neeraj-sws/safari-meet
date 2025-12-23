<div class="container" id="details">

    @include('livewire.components.breadcrumb', [
        'menu' => $pageTitle,
        'submenus' => [[$pageTitle => route('admin.sharedsafari.share.safari')], 'Details'],
        'backButton' => true,
        'backUrl' => route('admin.sharedsafari.share.safari'),
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
                <livewire:admin.share-safari.details.inclusions :package="$shareSafari" :characterstic="$hasActiveData" :type="1"
                    :table="'safari'" :key="'inclusions-' . $characterstic->id" />
            @elseif ($showNavTab->id == 2)
                <livewire:admin.share-safari.details.inclusions :package="$shareSafari" :characterstic="$hasActiveData" :type="2"
                    :table="'safari'" :key="'exclusions-' . $characterstic->id" />
            @elseif ($showNavTab->id == 3)
                <livewire:admin.share-safari.details.things-to-carry :package="$shareSafari" :characterstic="$hasActiveData"
                    :key="'thingstocarry-' . $characterstic->id" />
            @elseif ($showNavTab->id == 4)
                <livewire:admin.share-safari.details.f-a-q-component :package="$shareSafari" :characterstic="$hasActiveData"
                    :key="'faq-' . $characterstic->id" />
            @elseif ($showNavTab->id == 5)
                <livewire:admin.share-safari.details.discussion :package="$shareSafari" :characterstic="$hasActiveData"
                    :key="'discussion-' . $characterstic->id" />
            @elseif ($showNavTab->id == 6)
                <livewire:admin.share-safari.details.personal-chat :package="$shareSafari" :characterstic="$hasActiveData"
                    :key="'discussion-' . $characterstic->id" />
            @else
                <livewire:admin.share-safari.details.common-tabs :package="$shareSafari" :type="1"
                    :characterstic="$hasActiveData" :key="$characterstic->id" />
            @endif
        </div>
    </div>
</div>
