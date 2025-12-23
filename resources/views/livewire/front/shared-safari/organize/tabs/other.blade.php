<!-- Other/Characteristics Tab -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
        @foreach ($characterstics as $characteristic)
            <li class="nav-item" role="presentation">
                <a class="nav-link pe-auto {{ $showNavTab->id == $characteristic->id ? 'active' : '' }}"
                    data-bs-toggle="pill" href="#" onclick="return false;" role="tab">
                    <div class="d-flex align-items-center">
                        <div class="tab-title text-dark">{{ $characteristic->title }}</div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>

<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade active show" role="tabpanel">
        @if ($showNavTab->id == 1)
            @include('livewire.front.shared-safari.organize.tabs.characteristics.inclusions')
        @elseif ($showNavTab->id == 2)
            @include('livewire.front.shared-safari.organize.tabs.characteristics.exclusions')
        @elseif ($showNavTab->id == 3)
            @include('livewire.front.shared-safari.organize.tabs.characteristics.things-to-carry')
        @else
            @include('livewire.front.shared-safari.organize.tabs.characteristics.common-tabs')
        @endif
    </div>
</div>
