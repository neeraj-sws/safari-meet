<!-- Skeleton Loader for Safari Cards -->
<!-- Shows while Livewire is fetching data, hidden when data loads via wire:loading.remove -->
<section id="join-shared-safari-skeleton" class="mb-md--5 mb--3 pb--1" wire:key="safari-skeleton">
    <div class="card-container row align-items-center justify-content-start gx-3">
        <!-- Render 6 skeleton cards (responsive: 3 on desktop, 2 on tablet, 1 on mobile) -->
        @for ($i = 0; $i < 6; $i++)
            <div class="col-xl-4 col-sm-6 join-safari-card-box mt-3 rounded-3" wire:key="skeleton-{{ $i }}">
                <div class="card rounded-3 skeleton-card">
                    <!-- Skeleton Image: 220px height matching real card -->
                    <div class="skeleton-image rounded-top-3" style="height: 220px; width: 100%;"></div>

                    <!-- Skeleton Card Body -->
                    <div class="card-body p-0">
                        <!-- Card Title Section -->
                        <div class="card-body-inner border-bottom p-0">
                            <div class="card-title border-bottom p-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <!-- Skeleton Title -->
                                    <div class="skeleton-text skeleton-title" style="width: 70%; height: 24px;"></div>
                                </div>
                                <!-- Skeleton Location/City -->
                                <div class="skeleton-text" style="width: 60%; height: 16px; margin-top: 8px;"></div>
                            </div>

                            <!-- Skeleton Stats (Safari, Seats, Organizer) -->
                            <div class="card-text p-2">
                                <div class="d-flex justify-content-between">
                                    <!-- Safari Count -->
                                    <div class="text-center">
                                        <div class="skeleton-text" style="width: 50px; height: 14px; margin: 0 auto 8px;"></div>
                                        <div class="skeleton-text" style="width: 30px; height: 18px; margin: 0 auto;"></div>
                                    </div>
                                    <!-- Seats -->
                                    <div class="text-center">
                                        <div class="skeleton-text" style="width: 50px; height: 14px; margin: 0 auto 8px;"></div>
                                        <div class="skeleton-text" style="width: 30px; height: 18px; margin: 0 auto;"></div>
                                    </div>
                                    <!-- Organizer -->
                                    <div class="text-center">
                                        <div class="skeleton-text" style="width: 70px; height: 14px; margin: 0 auto 8px;"></div>
                                        <div class="skeleton-text" style="width: 60px; height: 18px; margin: 0 auto;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Price Section -->
                        <div class="card-body-inner price-container flex-wrap p-0">
                            <div class="starting-price d-flex align-items-center justify-content-between border-bottom p-2">
                                <div class="skeleton-text" style="width: 50px; height: 16px;"></div>
                                <div class="skeleton-text" style="width: 120px; height: 16px;"></div>
                            </div>

                            <!-- Skeleton Button -->
                            <div class="text-end my-2 pb-1 text-center">
                                <div class="skeleton-button" style="width: 120px; height: 36px; margin: 0 auto;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</section>

<style>
    /* ============================================
       Skeleton Loader Styles
       ============================================ */

    /* Base skeleton element styling */
    .skeleton-text,
    .skeleton-image,
    .skeleton-button {
        background-color: #e9ecef;
        background-image: linear-gradient(
            90deg,
            #e9ecef 0%,
            #f0f3f7 50%,
            #e9ecef 100%
        );
        background-size: 200% 100%;
        background-position: 200% 0;
        border-radius: 4px;
        display: block;

        /* Shimmer animation */
        animation: skeleton-shimmer 2s infinite;
    }

    /* Image skeleton specific styling */
    .skeleton-image {
        border-radius: 8px;
        margin-bottom: 0;
    }

    /* Button skeleton styling */
    .skeleton-button {
        border-radius: 6px;
        margin: 0 auto;
    }

    /* Title skeleton - slightly larger */
    .skeleton-title {
        margin: 0 auto;
    }

    /* Shimmer animation - smooth left to right gradient effect */
    @keyframes skeleton-shimmer {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }

    /* Ensure skeleton card maintains proper spacing */
    .skeleton-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: box-shadow 0.3s ease;
    }

    /* Optional: Reduce animation on reduced motion preferences */
    @media (prefers-reduced-motion: reduce) {
        .skeleton-text,
        .skeleton-image,
        .skeleton-button {
            animation: none;
            background-image: none;
            background-color: #e9ecef;
        }
    }

    /* Optional: Optimize for dark mode if your app supports it */
    @media (prefers-color-scheme: dark) {
        .skeleton-text,
        .skeleton-image,
        .skeleton-button {
            background-color: #rgba(11,97,94,0.08) !important;
            background-image: linear-gradient(
                90deg,
                #2d3748 0%,
                #4a5568 50%,
                #2d3748 100%
            );
        }
    }
</style>
