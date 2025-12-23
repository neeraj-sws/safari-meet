<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">{{ $menu }}</div>

    <div class="ps-3 flex-grow-1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0 d-flex align-items-center">
                <li class="breadcrumb-item">
                    <a href="{{ route('agent.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>

                @foreach ($submenus as $key => $item)
                @php
                $label = is_array($item) ? array_key_first($item) : $item;
                $url = is_array($item) ? $item[$label] : null;
                @endphp

                @if ($loop->last)
                <li class="breadcrumb-item active" aria-current="page">{{ $label }}</li>
                @else
                @if ($url)
                <li class="breadcrumb-item">
                    <a href="{{ $url }}">{{ $label }}</a>
                </li>
                @else
                <li class="breadcrumb-item">{{ $label }}</li>
                @endif
                @endif
                @endforeach
            </ol>
        </nav>
    </div>

    @isset($backButton)
    <div class="ms-auto">
        <a href="{{ $backUrl ?? url()->previous() }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> {{ $backText ?? 'Back' }}
        </a>
    </div>
    @endisset

    @isset($addButton)
    <div class="ms-auto">
        <div class="btn-group">
            @if (!empty($addUrl))
            <a href="{{ $addUrl }}" class="btn btn-primary ms-auto">
                <i class="lni lni-plus"></i> {{ $addText ?? 'Add' }} {{ $pageTitle ?? '' }}
            </a>
            @else
            <button class="btn btn-primary ms-auto" wire:click="{{ $addButton }}">
                <i class="lni lni-plus"></i> {{ $addText ?? 'Add' }} {{ $pageTitle ?? '' }}
            </button>
            @endif
        </div>
    </div>
    @endisset
</div>
