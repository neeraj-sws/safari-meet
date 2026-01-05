<div>
    @if ($view == 'desktop')
        @include('livewire.front.auth.partials.follow-list-desktop', [
            'activeStatus' => $activeStatus,
            'followinglists' => $followinglists,
            'followerlists' => $followerlists,
        ])
    @else
        @include('livewire.front.auth.partials.follow-list-mobile', [
            'type' => $type,
            'followinglists' => $followinglists,
            'followerlists' => $followerlists,
        ])
    @endif

</div>
