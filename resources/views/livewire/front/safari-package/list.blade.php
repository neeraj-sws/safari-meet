<div wire:init="loadPackages">
    @php
    use App\Helpers\SettingHelper;
    @endphp
    @if ($heroSecion)
    <section id="home-hero"
        style="background-image: url('{{ asset('front-assets/images/banner-image/home-hero-banner.png') }}');"
        class="listing-page-hero d-flex align-items-center justify-content-center text-center text-white mb-4">
        <div class="container-lg container-padding">
            <div class="bannertext text-center">
                <h1 class="text-white">Join or Organize a Package Safari</h1>
            </div>
        </div>
    </section>
    @endif

    <main>
        <div class="container-lg container-inner-padding" wire:key="package-listing">
            <div class="row g-3 position-relative " style="min-height: 100vh;">
                <!-- Sidebar Filter -->
                <aside class="col-12 col-lg-3 mt-lg-3 mt-0">
                    <livewire:front.common.safaries-side-bar :type="'package'" :key="'package'" />
                </aside>
                <!-- Main Content -->
                <div class="col-12 col-lg-9 main-content-scroll">

                    <div class="filter-applied-container">
                        <div class="d-sm-flex align-items-center justify-content-between mb-2 flex-wrap">
                            <div class="what's-found mb-lg-0 mb-3">
                                <p class="mb-0">We found <b>{{ $packages->total() }}</b> Active Shared Safari</p>
                            </div>
                            <div class="d-lg-inline-block d-flex align-items-center justify-content-between mb-3">
                                <div class="sort-by mb-sm-0">
                                    <select class="form-select custom-dropdown" wire:model.live="orderbyfilter">
                                        <option value="">All</option>
                                        <option value="popular">Popular</option>
                                        <option value="latest">Latest</option>
                                        <option value="trending">Trending</option>
                                        <option value="top">Top Rated</option>
                                    </select>
                                </div>
                                <!-- Filter Toggle Button (Visible on Mobile) -->
                                <div class="d-lg-none">
                                    <button class="btn" id="openFilter">
                                        <svg class="me-1 small" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="var(--text-dark)">
                                            <path
                                                d="M440-120v-240h80v80h320v80H520v80h-80Zm-320-80v-80h240v80H120Zm160-160v-80H120v-80h160v-80h80v240h-80Zm160-80v-80h400v80H440Zm160-160v-240h80v80h160v80H680v80h-80Zm-480-80v-80h400v80H120Z" />
                                        </svg></button>
                                </div>
                            </div>
                        </div>
                        <div class="select-filter-box d-flex align-items-center gap-2 flex-wrap mb-2">
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
                            <div class="clear-all-btn">
                                <a href="javascript:void(0)" wire:click="clearAll"
                                    class="text-decoration-none text-blue">Clear All</a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Global Skeleton Loader - Show by default on page load, hide on Livewire updates -->
                    <div wire:loading.delay wire:target="loadPackages, page, orderbyfilter, removeFilter, removeFilterValue, clearAll" id="skeletonLoader" style="flex-wrap: wrap; gap: 12px;">
                        @include('components.skeletons.listing-skeleton', ['count' => 6, 'type' => 'package'])
                    </div>

                    <!-- Real Content - Show when page loads, hide during Livewire updates -->
                    <div wire:loading.remove  wire:target="loadPackages, page, orderbyfilter, removeFilter, removeFilterValue, clearAll" id="safariContent">
                    <section id="join-shared-safari" class="mb-md--5 mb--3 pb--1">
                        <div class="card-container row align-items-stretch justify-content-start gx-3">
                            @if ($packages->count() > 0)
                            @foreach ($packages as $shareSafari)
                            <div class="col-xl-4 col-sm-6 join-safari-card-box mt-3 rounded-3 d-flex"
                                id="safari-package-no-{{ $shareSafari->id }}">
                                <div class="card rounded-3 w-100">
                                    <!-- Card Image -->
                                    <img class="card-img-top rounded-top-3"
                                        src="{{ asset($shareSafari->display_image) }}" alt="Card image">
                                    <!-- Card Body -->
                                    <div class="card-body p-0 d-flex flex-column">
                                        <div class="card-body-inner border-bottom" style="min-height: 215px">
                                            <div class="card-title border-bottom pb-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h4 class="mb-0 card-text text-truncate">
                                                        {{ ucwords($shareSafari->title) }}
                                                    </h4>
                                                    <div class="count-days px-2 rounded-1">
                                                        <span class="text-white">
                                                            {{ $shareSafari?->end_tour }}N/{{ $shareSafari?->start_tour
                                                            }}D
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="cityplace-text text-truncate">
                                                    <span> {{ ucwords($shareSafari->park->name) }},
                                                        {{ ucwords($shareSafari->park->state->name) }}</span>
                                                </div>
                                            </div>

                                            <div class="card-text">
                                                <!-- Highlights partition -->
                                                <div>

                                                    <ul
                                                        class="highlights highlights-grid knowfor-list ps-0 d-flex flex-wrap align-items-center">
                                                        @php
                                                        $inclusionList = App\Helpers\UserHelper::inclusionList(
                                                        $shareSafari->tour_highlights,
                                                        );
                                                        @endphp
                                                        @if (count($inclusionList) > 0)
                                                        @foreach ($inclusionList as $list)
                                                        <li
                                                            class="card-list-text d-flex align-items-center gap-1 mb-md-0 mb-1">
                                                            @php
                                                            $iconWithSize = str_replace(
                                                            '<i', '<i style="font-size: 10px;"' , $list->icon,
                                                                );
                                                                @endphp
                                                                {!! $iconWithSize !!}
                                                                <p class="mb-0 text-truncate">
                                                                    {{ $list->title }}</p>
                                                        </li>
                                                        @endforeach
                                                        @endif
                                                    </ul>
                                                </div>

                                                <!-- Known for partition -->
                                                <div class="knowfor-list mt-2 mb-1">
                                                    <h6 class="mb-1">Known For:</h6>
                                                </div>
                                                <ul
                                                    class="highlights highlights-grid knowfor-list ps-0 d-flex flex-wrap align-items-center">
                                                    @php
                                                    $wildlife = $shareSafari?->park?->wildlife ?? [];
                                                    @endphp
                                                    @if (count($wildlife) > 0)
                                                    @foreach ($wildlife as $list)
                                                    <li
                                                        class="card-list-text d-flex align-items-center gap-1 mb-md-0 mb-1">
                                                        <i class="fa fa-circle" style="font-size: 6px;"
                                                            aria-hidden="true"></i>
                                                        <p class="mb-0 text-truncate">
                                                            {{ $list->species->name }}</p>
                                                    </li>
                                                    @endforeach
                                                    @endif

                                                </ul>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex align-items-center justify-content-between card-body-inner py-2 price-container flex-wrap mt-auto">
                                            <div class="starting-price">
                                                <p class="mb-0">Starting Price:</p>
                                                <span class="mb-0 text-muted">₹ {{
                                                    SettingHelper::formatPrice($shareSafari->min_price_pp) }}</span>
                                            </div>
                                            <a href="{{ route('safari-package.detail', $shareSafari->slug) }}"
                                                id="join_safari_{{ $shareSafari->id }}"
                                                class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1 ">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                            @if ($packages->hasPages())
                            <div class="col-12 d-flex justify-content-center align-items-center mt-4 pt-2 gap-2">
                                {{-- Previous Page Link --}}
                                @if ($packages->onFirstPage())
                                <button class="btn btn-sm btn-secondary" disabled>
                                    <i class="fas fa-chevron-left"></i> Previous
                                </button>
                                @else
                                <button wire:click="$set('page', {{ $packages->currentPage() - 1 }})"
                                    class="btn btn-sm btn-primary blue-btn-hover border-0">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </button>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($packages->getUrlRange(max(1, $packages->currentPage() - 2),
                                min($packages->lastPage(), $packages->currentPage() + 2)) as $page => $url)
                                @if ($page == $packages->currentPage())
                                <button class="btn btn-sm btn-primary blue-btn-hover border-0" disabled>
                                    {{ $page }}
                                </button>
                                @else
                                <button wire:click="$set('page', {{ $page }})" class="btn btn-sm btn-outline-primary">
                                    {{ $page }}
                                </button>
                                @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($packages->hasMorePages())
                                <button wire:click="$set('page', {{ $packages->currentPage() + 1 }})"
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
                            @else
                            <div class="text-center">
                                <img src="{{ asset('front-assets/images/cat-with-magnifying-glass-illustration-svg-png-download-11511372.png') }}"
                                    class="freepikimg" style="width:350px;">
                                <h6>Data Not Found</h6>
                            </div>
                            @endif
                        </div>
                    </section>
                    </div>
                    <!-- End safari-content-wrapper -->
                    @if ($heroSecion)
                    <section id="top-rated-park" class="mt-4 pt-2">
                        <livewire:front.common.top-rated-parks-carousel :key="'toprated'" />
                    </section>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    // Only handle scroll to top - let Livewire handle loader visibility
    if (window.Livewire) {
        Livewire.on('scrollToTop', function() {
            setTimeout(function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 100);
        });
    }
</script>
