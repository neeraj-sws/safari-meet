<!-- Safari Detail Page Skeleton Implementation Example -->
<!-- Usage in your Livewire Detail component view -->

<div>
    <!-- Hero Section Skeleton -->
    <div wire:loading.flex wire:target="loadDetail">
        @include('components.skeletons.detail-page-skeleton')
    </div>

    <!-- Real Content -->
    <div wire:loading.remove wire:target="loadDetail">
        <!-- Your actual detail page content here -->
    </div>
</div>

<!-- Alternative: For pages that load faster, show skeleton on initial mount -->

<div>
    @if ($loading)
        @include('components.skeletons.detail-page-skeleton')
    @else
        <!-- Your actual detail page content here -->
    @endif
</div>
