<div wire:init="firstTimeLoading">
    <!-- Hero Section -->
    <section id="home-hero"
        style="background-image: url('{{ asset('front-assets/images/banner-image/home-hero-banner.png') }}');"
        class="listing-page-hero d-flex align-items-center justify-content-center text-center text-white mb-4">
        <div class="container-lg container-padding">
            <div class="bannertext text-center">
                <h1 class="text-white">Explore National Park</h1>
            </div>
        </div>
    </section>

    <main>
        <div class="container-lg container-inner-padding">
            <div class="row g-3 position-relative mb-5" style="min-height: 100vh;">
                <!-- Sidebar Filter -->
                <aside class="col-12 col-lg-3 mt-lg-3 mt-0" wire:key="filter-sidebar-{{ now()->timestamp }}">
                    <div class="filter-sidebar-wrapper rounded-3 border shadow-sm">
                        <div class="filter-sidebar-content rounded-3 p-3">
                            <div class="d-flex justify-content-end d-lg-none">
                                <button class="btn-close" id="closeFilter" aria-label="Close"></button>
                            </div>

                            <h5 class="filter-title text-blue mb-0">Select Filters</h5>

                            <!-- State Filter -->
                            <div class="filter-group py-3 border-bottom mb-0">
                                <label for="stateSelect" class="form-label">Select State</label>
                                <select class="form-select select2" id="stateSelect" wire:model.live="stateSelect">
                                    <option value="">Select State</option>
                                    @foreach ($states as $id => $name)
                                    <option value="{{ $id }}" @selected($stateSelect==$id)>
                                        {{ ucwords($name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Park Filter -->
                            <div class="filter-group py-3 border-bottom mb-0">
                                <label for="parkSelect" class="form-label">Select Wild Life Sanctuaries</label>
                                <select class="form-select select2" id="parkSelect" wire:model.live="parkSelect">
                                    <option value="">Select Wild Life Sanctuaries</option>
                                    @foreach ($park_datas as $id => $name)
                                    <option value="{{ $id }}" @selected($parkSelect==$id)>
                                        {{ ucwords($name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Species Filter -->
                            <div class="filter-group py-3 border-bottom mb-0">
                                <label for="speciesSelect" class="form-label">Select Species</label>
                                <select class="form-select select2" id="speciesSelect" wire:model.live="speciesSelect">
                                    <option value="">Select Species</option>
                                    @foreach ($species as $id => $name)
                                    <option value="{{ $id }}" @selected($speciesSelect==$id)>
                                        {{ ucwords($name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Best Time Filter (Accordion) -->
                            @if ($BestTimesVisits->isNotEmpty())
                            <div class="accordion" id="filterAccordion">
                                <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed bg-transparent px-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                            aria-expanded="false" aria-controls="collapseOne">
                                            Best time to visit
                                        </button>
                                    </h2>
                                    <div id="collapseOne"
                                        class="accordion-collapse collapse {{ !empty($bestTimeSelect) ? 'show' : '' }}"
                                        aria-labelledby="headingOne" data-bs-parent="#filterAccordion">
                                        <div class="accordion-body pt-0">
                                            @foreach ($BestTimesVisits as $visit)
                                            <div class="form-check" wire:key="accordion-filter-{{ $visit->id }}">
                                                <input class="form-check-input" type="checkbox"
                                                    wire:model.live="bestTimeSelect" id="weather_{{ $visit->id }}"
                                                    value="{{ $visit->id }}">
                                                <label class="form-check-label" for="weather_{{ $visit->id }}">
                                                    {{ $visit->title }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </aside>


                <!-- Main Content -->
                <div class="col-12 col-lg-9 main-content-scroll">
                    <div class="filter-applied-container">
                        <div class="d-sm-flex align-items-center justify-content-between mb-2 flex-wrap">
                            <div class="what's-found mb-lg-0 mb-3">
<<<<<<< HEAD
                                <p class="mb-0">We found <b>{{ $totalCount }}</b> Active {{ Str::plural('Park', $totalCount) }}</p>
=======
                                <p class="mb-0">We found <b>{{ count($parks) }}</b> Active Park</p>
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
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
                            @foreach ($allFiltersValue as $key => $label)
                            @if (is_array($label))
                            @foreach ($label as $singleLabel)
                            <div class="filter-options rounded-pill bg-accent d-inline-block px-3 py-1"
                                wire:key="filter-{{ $key }}-{{ Str::slug($singleLabel) }}">
                                <p class="text-white mb-0">
                                    {{ $singleLabel }}
                                    <a href="javascript:void(0)"
                                        wire:click.prevent="removeFilterValue('{{ $key }}', '{{ $singleLabel }}')"
                                        class="text-decoration-none">
                                        <i class="fa-solid fa-xmark text-white ps-1"></i>
                                    </a>
                                </p>
                            </div>
                            @endforeach
                            @else
                            <div class="filter-options rounded-pill bg-accent d-inline-block px-3 py-1"
                                wire:key="filter-{{ $key }}">
                                <p class="text-white mb-0">
                                    {{ $label }}
                                    <a href="javascript:void(0)" wire:click.prevent="removeFilter('{{ $key }}')"
                                        class="text-decoration-none">
                                        <i class="fa-solid fa-xmark text-white ps-1"></i>
                                    </a>
                                </p>
                            </div>
                            @endif
                            @endforeach
                            @if (!empty($allFiltersValue))
                            <div class="clear-all-btn" wire:key="clear-all-btn">
                                <a href="javascript:void(0)" wire:click.prevent="clearAll"
                                    class="text-decoration-none text-blue">
                                    Clear All
                                </a>
                            </div>
                            @endif
                        </div>

                    </div>

                    <!-- Global Skeleton Loader -->
                    <div wire:loading.flex
                        wire:target="firstTimeLoading, stateSelect, speciesSelect, parkSelect,bestTimeSelect,orderbyfilter, loadMore, clearAll,removeFilter, removeFilterValue ">
                        @include('components.skeletons.listing-skeleton', ['count' => 6, 'type' => 'park'])
                    </div>

                    <!-- Real Content -->
                    <div wire:loading.remove  wire:target="firstTimeLoading, stateSelect, speciesSelect, parkSelect,bestTimeSelect,orderbyfilter, loadMore, clearAll,removeFilter, removeFilterValue ">
                        <section id="join-shared-safari" class="mb-md--5 mb--3 pb--1">
                            <div class="card-container row align-items-stretch gx-3">
                                @if (count($parks) > 0)
                                @foreach ($parks as $park)
                                <div class="col-xl-4 col-sm-6 join-safari-card-box mt-3 rounded-3 d-flex"
                                    wire:key="park-card-{{ $park->id }}">
                                    <div class="card rounded-3 w-100">
                                        @if ($park->popular == 1)
                                        <small class="top-rated-park text-white bg-warning">Popular</small>
                                        @elseif($park->trending == 1)
                                        <small class="top-rated-park text-white bg-warning">Trending</small>
                                        @endif
                                        <!-- Card Image -->
                                        <img class="card-img-top rounded-top-3" src="{{ asset($park->display_image) }}"
                                            alt="Card image">
                                        <!-- Card Body -->
                                        <div class="card-body p-0 d-flex flex-column rounded-bottom-3">
                                            <div class="card-title border-bottom p-2 mb-0 bg-card">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h4 class="mb-0 card-main-heading">
                                                        {{ ucwords($park->name) }}
                                                    </h4>
                                                </div>
                                                <div class="cityplace-text">
                                                    <span>{{ ucwords($park->name) }},
                                                        {{ ucwords($park?->state?->name) }}</span>
                                                </div>
                                            </div>
                                            <div class="card-body-inner p-2 pt-1">

                                                <div class="card-text">
                                                    <!-- Park description partition -->
                                                    <div
                                                        class="park-description border-bottom card-lines-divider pb-1 mb-1">
                                                        <p class="mb-0">
                                                            {{ ucwords($park->short_description) }}
                                                        </p>
                                                    </div>
                                                    @php
                                                    $bestTimes = $park->parkBestTimes
                                                    ->filter(
                                                    fn($data) => $data?->weather?->start &&
                                                    $data?->weather?->end,
                                                    )
                                                    ->map(function ($data) {
                                                    try {
                                                    $start = Carbon\Carbon::parse(
                                                    $data->weather->start,
                                                    )
                                                    ->startOfMonth()
                                                    ->format('F');
                                                    $end = Carbon\Carbon::parse($data->weather->end)
                                                    ->endOfMonth()
                                                    ->format('F');
                                                    return "$start-$end";
                                                    } catch (\Exception $e) {
                                                    return null;
                                                    }
                                                    })
                                                    ->filter()
                                                    ->values()
                                                    ->toArray();
                                                    @endphp

                                                    @if (!empty($bestTimes))
                                                    <div class="knowfor-list mb-2 d-flex align-items-center">
                                                        <h6 class="mb-0">Best Time:</h6>
                                                        <p class="mb-0 ps-2">{{ implode(', ', $bestTimes) }}
                                                        </p>
                                                    </div>
                                                    @endif

                                                    @if ($park->wildlife->isNotEmpty())
                                                    <div class="knowfor-list mt-1 mb-1">
                                                        <h6 class="mb-0">Wildlife Found:</h6>
                                                    </div>

                                                    <ul
                                                        class="highlights highlights-grid knowfor-list ps-0 d-flex flex-wrap align-items-center mb-2">
                                                        @foreach ($park->wildlife as $wildSpecies)
                                                        <li
                                                            class="card-list-text d-flex align-items-center gap-1 mb-md-0 mb-1">
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <p class="mb-0">
                                                                {{ ucfirst($wildSpecies?->species?->name) }}
                                                            </p>

                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                    @if ($park->parkSafariTypes->isNotEmpty())
                                                    <!-- Safari Type partition -->
                                                    <div class="knowfor-list mt-1 mb-1">
                                                        <h6 class="mb-0">Safari Type:</h6>
                                                    </div>
                                                    <ul
                                                        class="highlights highlights-grid knowfor-list ps-0 d-flex flex-wrap align-items-center mb-sm-2">
                                                        @foreach ($park->parkSafariTypes as $safariType)
                                                        <li
                                                            class="card-list-text d-flex align-items-center gap-1 mb-md-0 mb-1">
                                                            <i class="fa-solid fa-check link-text"></i>
                                                            <p class="mb-0">
                                                                {{ ucfirst($safariType->safari_type->name) }}
                                                            </p>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    @endif


                                                </div>
                                            </div>
                                            <div class="price-container text-center pb-3 pt-sm-2 mt-auto">
                                                <a href="{{ route('park.detail', $park->slug) }}"
                                                    class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1 px-3">View
                                                    Details</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @if ($parks->count() >= $perPage)
                                <div class="col-12 text-center mt-4 pt-2">
                                    <button wire:click="loadMore" wire:loading.remove
                                        class="btn btn-primary blue-btn-hover btn-sm border-0 px-3">
                                        Load More
                                    </button>
                                    <div wire:loading wire:target="loadMore">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @else
                                <div class="text-center">
                                    <img src="{{ asset('front-assets/images/cat-with-magnifying-glass-illustration-svg-png-download-11511372.png') }}"
                                        class="freepikimg" style="width:250px;">
                                    <h6>Data Not Found</h6>
                                </div>
                                @endif
                            </div>
                        </section>
                    </div>
                    <!-- End wire:loading.remove -->
                    <!-- Top Rated Park  -->
                    <section id="top-rated-park" class="mt-4 pt-2">
                        <livewire:front.common.top-rated-parks-carousel :key="'top-rated-parks-carousel'" />
                    </section>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
    Livewire.on('filtersCleared', () => {
            // Reset Select2 manually if used
            $('#stateSelect').val('').trigger('change');
            $('#parkSelect').val('').trigger('change');

            document.querySelectorAll('.form-check-input[type="checkbox"]').forEach(cb => {
                cb.checked = false;
            });
        });
</script>
@endpush
