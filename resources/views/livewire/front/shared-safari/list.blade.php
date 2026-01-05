<div wire:init="firstTimeLoader">
    @php
    use App\Models\SafariAllottedSeat;
    use App\Helpers\SettingHelper;
    @endphp
    @if ($heroSecion)
    <section id="home-hero"
        class="listing-page-hero d-flex align-items-center justify-content-center text-center text-white mb-4"
        style="background-image: url('{{ asset('front-assets/images/banner-image/home-hero-banner.png') }}');"
        wire:key="hero-section">
        <div class="container-lg container-padding">
            <div class="bannertext text-center">
                <h1 class="text-white">Join or Organize a Shared Safari</h1>
            </div>
        </div>
    </section>
    @endif

    <main>
        <div class="container-lg container-inner-padding">
            <div class="row g-3 position-relative" style="min-height: 100vh;">
                <!-- Sidebar Filter -->
                <aside class="col-12 col-lg-3 mt-lg-3 mt-0" wire:key="sidebar-filter">
                    @auth
                    @if (Auth::guard('web')->user()->user_type == 1 && Auth::guard('web')->user()->status == 1)
                    <a href="{{ route('createsaharedshafari') }}"
                        class="w-100 px-4 mb-1 btn btn-sm btn-primary blue-btn-hover rounded-2" data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="{{ Auth::guard('web')->user()->status != 1 ? 'Verify/Update your profile to create safari' : 'Create Shared Safari' }}">
                        Create Shared Safari
                    </a>
                    @elseif(Auth::guard('web')->user()->user_type == 0)
                    <a href="{{ route('createsaharedshafari') }}"
                        class="w-100 px-4 mb-1 btn btn-sm btn-primary blue-btn-hover rounded-2" data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="{{ Auth::guard('web')->user()->status != 1 ? 'Verify/Update your profile to create safari' : 'Create Shared Safari' }}">
                        Create Shared Safari
                    </a>
                    @endif
                    @endauth

                    <livewire:front.common.safaries-side-bar :type="'shared-safari'" :key="'shared-safari-sidebar'" />
                </aside>

                <!-- Main Content -->
                <div class="col-12 col-lg-9 main-content-scroll position-relative" wire:key="main-content">

                    <div class="filter-applied-container" wire:key="filters-container">
                        <div class="d-sm-flex align-items-center justify-content-between mb-2 flex-wrap">
                            <div class="what's-found mb-lg-0 mb-3" wire:key="found-count">
                                <p class="mb-0">
                                    We found <b>{{ $shareSafaris->total() }}</b> Active Shared Safari
                                </p>
                            </div>
                            <div class="d-lg-inline-block d-flex align-items-center justify-content-between mb-3">
                                <div class="sort-by mb-sm-0" wire:key="sort-by">
                                    <select class="form-select custom-dropdown" wire:model.live="orderbyfilter">
                                        <option value="">All</option>
                                        <option value="popular">Popular</option>
                                        <option value="latest">Latest</option>
                                        <option value="trending">Trending</option>
                                        <option value="top">Top Rated</option>
                                    </select>
                                </div>
                                <!-- Filter Toggle Button (Visible on Mobile) -->
                                <div class="d-lg-none" wire:key="mobile-filter-btn">
                                    <button class="btn" id="openFilter">
                                        <svg class="me-1 small" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="var(--text-dark)">
                                            <path
                                                d="M440-120v-240h80v80h320v80H520v80h-80Zm-320-80v-80h240v80H120Zm160-160v-80H120v-80h160v-80h80v240h-80Zm160-80v-80h400v80H440Zm160-160v-240h80v80h160v80H680v80h-80Zm-480-80v-80h400v80H120Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Active Filters -->
                        <div class="select-filter-box d-flex align-items-center gap-2 flex-wrap mb-2"
                            wire:key="active-filters">
                            @foreach ($allFiltersValue as $key => $labels)
                            @if (is_array($labels))
                            @foreach ($labels as $label)
                            <div class="filter-options rounded-pill bg-accent d-inline-block px-3 py-1"
                                wire:key.prevent="filter-{{ $key }}-{{ $label }}">
                                <p class="text-white mb-0">
                                    {{ $label }}
                                    <a href="javascript:void(0)" class="text-decoration-none"
                                        wire:click="removeFilterValue('{{ $key }}', '{{ $label }}')">
                                        <i class="fa-solid fa-xmark text-white ps-1"></i>
                                    </a>
                                </p>
                            </div>
                            @endforeach
                            @else
                            <div class="filter-options rounded-pill bg-accent d-inline-block px-3 py-1"
                                wire:key.prevent="filter-{{ $key }}">
                                <p class="text-white mb-0">
                                    {{ $labels }}
                                    <a href="javascript:void(0)" class="text-decoration-none"
                                        wire:click="removeFilter('{{ $key }}')">
                                        <i class="fa-solid fa-xmark text-white ps-1"></i>
                                    </a>
                                </p>
                            </div>
                            @endif
                            @endforeach

                            @if (!empty($allFiltersValue))
                            <div class="clear-all-btn" wire:key="clear-all-btn">
                                <a href="javascript:void(0)" wire:click.prevent="clearAll"
                                    class="text-decoration-none text-blue">Clear All</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- Skeleton Loader during Livewire requests (filter, pagination, sort) -->
                    <div wire:loading.delay
                        wire:target="firstTimeLoader,page, orderbyfilter, applyFilters, removeFilter, removeFilterValue, clearAll">
                        @include('components.skeletons.listing-skeleton', ['count' => 3, 'type' => 'safari'])
                    </div>

                    <!-- Real Content: Visible when data is loaded -->
                    <div class="safari-content-wrapper" wire:loading.remove
                        wire:target="firstTimeLoader,page, orderbyfilter, applyFilters, removeFilter, removeFilterValue, clearAll"
                        id="safariContent">
                        @if ($shareSafaris->count() > 0)
                        <!-- Safari Listing -->
                        <section id="join-shared-safari" class="mb-md--5 mb--3 pb--1" wire:key="safari-listing">
                            <div class="card-container row align-items-center justify-content-start gx-3">
                                @foreach ($shareSafaris as $shareSafari)
                                <div class="col-xl-4 col-sm-6 join-safari-card-box mt-3 rounded-3"
                                    wire:key="safari-{{ $shareSafari->id }}">
                                    <div class="card rounded-3">
                                        @php
                                        $allottedSeatCount = $shareSafari->allottedSeat->sum('number_of_seat');
                                        $totalSeat = $shareSafari->share_seats - $allottedSeatCount;
                                        @endphp
                                        {{-- <small class="top-rated-park text-white bg-warning">Top Rated</small> --}}
                                        @if ($showBookedSafari)
                                        @if ($totalSeat == 0)
                                        <small class="limited-availability">All Seat Booked</small>
                                        @endif
                                        @endif
                                        <!-- Card Image -->
                                        <a href="{{ route('shared-safari.detail', $shareSafari->slug) }}">
                                            @if (!empty($shareSafari->display_image))
                                            <img class="card-img-top rounded-top-3"
                                                style="width:100%; height:220px; object-fit:cover;"
                                                src="{{ asset($shareSafari->display_image) }}" alt="Card image">
                                            @else
                                            <img class="card-img-top rounded-top-3"
                                                style="width:100%; height:220px; object-fit:cover;"
                                                src="{{ asset('assets/images/GPT-1.png') }}" alt="Card image">
                                            @endif
                                        </a>
                                        <!-- Card Body -->
                                        <div class="card-body p-0">
                                            <div class="card-body-inner border-bottom p-0">
                                                <div class="card-title border-bottom p-2">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h4 class="mb-0 card-text">
                                                            {{ ucwords($shareSafari->title) }}
                                                        </h4>
                                                    </div>
                                                    <div class="cityplace-text">
                                                        <span>{{ ucwords($shareSafari->park->name) }},
                                                            {{ ucwords($shareSafari->park->state->name) }}</span>
                                                    </div>
                                                </div>
                                                <div class="card-text p-2">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="text-center">
                                                            <p class="mb-0 total-safari">Safari</p>
                                                            <p class="mb-0 total-safari-in-number">{{
                                                                $shareSafari->no_of_safari }}</p>
                                                        </div>
                                                        <div class="text-center">
                                                            <p class="mb-0 total-seat">Seats</p>
                                                            <p class="mb-0 total-seat-in-number">
                                                                {{ $totalSeat }} </p>
                                                        </div>
                                                        <div class="text-center">
                                                            <p class="mb-0 organizer">Organized by</p>
                                                            @if ($shareSafari->organized_type === 'admin')
                                                            <p class="mb-0 organizer_name">Admin</p>
                                                            @else
                                                            <p class="mb-0 organizer_name">
                                                                {{ $organizerName =
                                                                optional($shareSafari->organizer)->name ?? 'Unknown' }}
                                                            </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body-inner price-container flex-wrap p-0">
                                                <div
                                                    class="starting-price d-flex align-items-center justify-content-between border-bottom p-2">
                                                    <p class="mb-0">Price:</p>
                                                    <div>
                                                        <span class="mb-0 text-muted">
                                                            ₹
                                                            {{ SettingHelper::formatPrice($shareSafari->min_price_pp) }}
                                                            - ₹
                                                            {{ SettingHelper::formatPrice($shareSafari->max_price_pp) }}
                                                        </span>
                                                    </div>

                                                </div>
                                                <div class="text-end my-2 pb-1 text-center">
                                                    <a href="{{ route('shared-safari.detail', $shareSafari->slug) }}"
                                                        id="join_safari_{{ $shareSafari->id }}"
                                                        class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                @if ($shareSafaris->hasPages())
                                <div class="col-12 d-flex justify-content-center align-items-center mt-4 pt-2 gap-2"
                                    wire:key="pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($shareSafaris->onFirstPage())
                                    <button class="btn btn-sm btn-secondary" disabled>
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </button>
                                    @else
                                    <button wire:click="$set('page', {{ $shareSafaris->currentPage() - 1 }})"
                                        class="btn btn-sm btn-primary blue-btn-hover border-0">
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </button>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($shareSafaris->getUrlRange(max(1, $shareSafaris->currentPage() - 2),
                                    min($shareSafaris->lastPage(), $shareSafaris->currentPage() + 2)) as $page => $url)
                                    @if ($page == $shareSafaris->currentPage())
                                    <button class="btn btn-sm btn-primary blue-btn-hover border-0" disabled>
                                        {{ $page }}
                                    </button>
                                    @else
                                    <button wire:click="$set('page', {{ $page }})"
                                        class="btn btn-sm btn-outline-primary">
                                        {{ $page }}
                                    </button>
                                    @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($shareSafaris->hasMorePages())
                                    <button wire:click="$set('page', {{ $shareSafaris->currentPage() + 1 }})"
                                        class="btn btn-sm btn-primary blue-btn-hover border-0">
                                        Next <i class="fas fa-chevron-right"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-sm btn-secondary" disabled>
                                        Next <i class="fas fa-chevron-right"></i>
                                    </button>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </section>
                        @else
                        <div class="text-center">
                            <img src="{{ asset('front-assets/images/cat-with-magnifying-glass-illustration-svg-png-download-11511372.png') }}"
                                class="freepikimg" style="width:350px;">
                            <h6>Data Not Found</h6>
                        </div>
                        @endif
                    </div>
                    <!-- End safari-content-wrapper -->
                </div>
            </div>
        </div>
    </main>
</div>
@push('scripts')

<script>
    document.addEventListener('livewire:navigated', function() {
        Livewire.on('scrollToTop', function() {
            setTimeout(function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 100);
        });
    });

    Livewire.on('scrollToTop', function() {
        setTimeout(function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }, 100);
    });
</script>
@endpush
