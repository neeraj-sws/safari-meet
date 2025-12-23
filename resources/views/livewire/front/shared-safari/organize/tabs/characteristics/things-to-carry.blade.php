<!-- Things to Carry Characteristics -->
<livewire:travel-agent.shared-safari.details.things-to-carry
    :package="$sharedSafar"
    :characterstic="$hasActiveData"
    :key="'thingstocarry-' . $showNavTab->id"
    :section="'user'" />

<div class="d-flex justify-content-end gap-2" wire:key="nav-buttons-{{ $showNavTab->id }}">
    @php
        $routeName = $type == 'edit' ? 'edit.saharedshafari' : 'createsaharedshafari';
    @endphp
    <a type="button"
        href="{{ route($routeName, ['slug' => $sharedSafari->slug, 'type' => 'other', 'subtype' => 'exclusions']) }}"
        class="btn btn-sm border-bg blue-border-hover rounded-1 px-4 text-blue">
        Back
    </a>
    <button type="button" wire:click="toggleStatus({{ $showNavTab->id + 2 }})"
        class="btn btn-sm btn-success blue-btn-hover border-0 rounded-1 px-4">
       {{ $sharedSafar->is_paid == 1 ? 'Submit' : 'Pay & Submit' }}
    </button>
</div>
