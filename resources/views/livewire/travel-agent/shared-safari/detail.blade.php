<div class="container" id="details">

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ $pageTitle }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('agent.shared-safari.safari') }}" class="btn btn-primary ms-auto"> <i
                        class="lni lni-arrow-left"></i></a>
            </div>
        </div>
    </div>

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
                <livewire:travel-agent.shared-safari.details.inclusions :package="$shareSafari" :characterstic="$hasActiveData"
                    :type="1" :table="'safari'" :key="'inclusions-' . $characterstic->id" />
            @elseif ($showNavTab->id == 2)
                <livewire:travel-agent.shared-safari.details.inclusions :package="$shareSafari" :characterstic="$hasActiveData"
                    :type="2" :table="'safari'" :key="'exclusions-' . $characterstic->id" />
            @elseif ($showNavTab->id == 3)
                <livewire:travel-agent.shared-safari.details.things-to-carry :package="$shareSafari" :characterstic="$hasActiveData"
                    :key="'thingstocarry-' . $characterstic->id" />
            @elseif ($showNavTab->id == 4)
                <livewire:travel-agent.shared-safari.details.f-a-q-component :package="$shareSafari" :characterstic="$hasActiveData"
                    :key="'faq-' . $characterstic->id" />
            @elseif ($showNavTab->id == 5)
                <livewire:travel-agent.shared-safari.details.discussion :package="$shareSafari" :characterstic="$hasActiveData"
                    :key="'discussion-' . $characterstic->id" />
            @else
                <livewire:travel-agent.shared-safari.details.common-tabs :package="$shareSafari" :type="1"
                    :characterstic="$hasActiveData" :key="$characterstic->id" />
            @endif

        </div>
    </div>
</div>
