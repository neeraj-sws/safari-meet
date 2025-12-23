<!-- Inclusions Characteristics -->
<livewire:travel-agent.shared-safari.details.inclusions
    :package="$sharedSafar"
    :characterstic="$hasActiveData"
    :type="1"
    :table="'safari'"
    :key="'inclusions-' . $showNavTab->id"
    :section="'user'" />

<div class="d-flex justify-content-end gap-2" wire:key="nav-buttons-{{ $showNavTab->id }}">
    @php
        $routeName = $type == 'edit' ? 'edit.saharedshafari' : 'createsaharedshafari';
    @endphp
    <a href="{{ route($routeName, ['slug' => $sharedSafari->slug, 'type' => 'upload']) }}"
        class="btn btn-sm border-bg blue-border-hover rounded-1 px-4 text-blue">
        Back
    </a>
    <a type="button" wire:click="toggleStatus({{ $showNavTab->id + 1 }})"
        class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1 px-4">
        Next
    </a>
</div>
