<!-- Skeleton for Park Cards -->
<!-- Usage: @include('components.skeletons.park-card-skeleton') -->
<div class="skeleton-card">
    <!-- Park Image -->
    <div class="skeleton-image h-220"></div>

    <!-- Card Body -->
    <div class="skeleton-card-body">
        <!-- Park Name -->
        <div class="skeleton-text title" style="margin-bottom: 8px;"></div>

        <!-- Location/State -->
        <div class="skeleton-text subtitle" style="margin-bottom: 12px;"></div>

        <!-- Description Lines -->
        <div class="skeleton-text line-long" style="margin-bottom: 8px;"></div>
        <div class="skeleton-text line-medium" style="margin-bottom: 12px;"></div>

        <!-- Wildlife Species (List) -->
        <div class="mb-3">
            <div class="skeleton-text" style="height: 12px; width: 60%; margin-bottom: 8px;"></div>
            <div class="d-flex flex-wrap gap-2">
                <div class="skeleton-badge small"></div>
                <div class="skeleton-badge small"></div>
                <div class="skeleton-badge small"></div>
            </div>
        </div>

        <!-- Best Time to Visit -->
        <div class="mb-3">
            <div class="skeleton-text" style="height: 12px; width: 60%; margin-bottom: 8px;"></div>
            <div class="skeleton-text line-medium"></div>
        </div>

        <!-- View Details Button -->
        <div class="skeleton-button sm" style="width: 100%;"></div>
    </div>
</div>
