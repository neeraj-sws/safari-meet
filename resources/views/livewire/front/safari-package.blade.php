<div>
    @if ($heroSecion)    
        <section id="home-hero"
            class="listing-page-hero d-flex align-items-center justify-content-center text-center text-white mb-4">
            <div class="container-lg container-padding">
                <div class="bannertext text-center">
                    <h1 class="text-white">Safari Package</h1>
                </div>
            </div>
        </section>
    @endif

    <main>
        <div class="container-lg container-inner-padding">
            <div class="row g-3 position-relative mb-5" style="min-height: 100vh;">
                <!-- Sidebar Filter -->
                <aside class="col-12 col-md-4 col-lg-3">
                    <div class="filter-sidebar-wrapper rounded-3 border shadow-sm">
                        <div class="filter-sidebar-content rounded-3 p-3">
                            <!-- Close Button for Mobile -->
                            <div class="d-flex justify-content-end d-md-none">
                                <button class="btn-close" id="closeFilter" aria-label="Close"></button>
                            </div>

                            <h5 class="filter-title text-blue mb-0">Select Filters</h5>

                            <!-- State Selection -->
                            <div class="filter-group py-3 border-bottom mb-0">
                                <label for="stateSelect" class="form-label">Select State</label>
                                <select class="form-select" id="stateSelect" wire:model.live="stateSelect">
                                    <option value="">Select State</option>
                                    @foreach ($states as $stateId => $stateValue)
                                        <option value="{{ $stateId }}">{{ ucwords($stateValue) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Species Selection -->
                            <div class="filter-group py-3 border-bottom mb-0">
                                <label for="speciesSelect" class="form-label">Select Species</label>
                                <select class="form-select" id="speciesSelect" name="species">
                                    <option selected disabled>Select Species</option>
                                     @foreach ($species as $specieId => $specieValue)
                                        <option value="{{ $specieId }}">{{ ucwords($specieValue) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- National Parks Selection -->
                            <div class="filter-group py-3 border-bottom mb-0">
                                <label for="speciesSelect" class="form-label">Select National Park</label>
                                <select class="form-select" id="speciesSelect" wire:model.live="parkSelect">
                                    <option value="">Select National Park</option>
                                    @foreach ($parks as $parkId => $parkValue)
                                        <option value="{{ $parkId }}">{{ ucwords($parkValue) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Accordion Filters -->
                            <div class="accordion" id="filterAccordion">

                                <!-- Best Time -->
                                <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed bg-transparent px-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                            aria-expanded="false" aria-controls="collapseOne">
                                            Best time to visit
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="headingOne" data-bs-parent="#filterAccordion">
                                        <div class="accordion-body pt-0">
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="monsoon"> <label class="form-check-label"
                                                    for="monsoon">Monsoon</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="prewin"> <label class="form-check-label"
                                                    for="prewin">Pre-Winters</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="winter"> <label class="form-check-label"
                                                    for="winter">Winters</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="summer"> <label class="form-check-label"
                                                    for="summer">Summer</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stay Category -->
                                <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed bg-transparent px-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            Stay Category
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo" data-bs-parent="#filterAccordion">
                                        <div class="accordion-body pt-0">

                                            @foreach ($stayCategory as $stayCategoryId => $stayCategoryValue)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="stayCategory_{{ $stayCategoryId }}"
                                                        wire:model.live="selectedStayCategories.{{ $stayCategoryId }}">

                                                    <label class="form-check-label"
                                                        for="stayCategory_{{ $stayCategoryId }}">
                                                        {{ ucwords($stayCategoryValue) }}
                                                    </label>
                                                </div>
                                            @endforeach


                                        </div>
                                    </div>
                                </div>

                                <!-- Included -->
                                <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed bg-transparent px-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree">
                                            Included
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#filterAccordion">
                                        <div class="accordion-body pt-0">
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="accommodation"> <label class="form-check-label"
                                                    for="accommodation">Accommodation</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="pickup"> <label class="form-check-label"
                                                    for="pickup">Pick &
                                                    Drop</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="camera"> <label class="form-check-label"
                                                    for="camera">Camera
                                                    Fee</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="permit"> <label class="form-check-label"
                                                    for="permit">Permit</label>
                                            </div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="guide"> <label class="form-check-label"
                                                    for="guide">Guide
                                                    Fee</label></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Organizers -->
                                <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                                    <h2 class="accordion-header" id="headingOrganizers">
                                        <button class="accordion-button collapsed bg-transparent px-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOrganizers"
                                            aria-expanded="false" aria-controls="collapseOrganizers">
                                            Organizers
                                        </button>
                                    </h2>
                                    <div id="collapseOrganizers" class="accordion-collapse collapse"
                                        aria-labelledby="headingOrganizers" data-bs-parent="#filterAccordion">
                                        <div class="accordion-body pt-0">
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="individual"> <label class="form-check-label"
                                                    for="individual">Individual</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="safari-operator"> <label class="form-check-label"
                                                    for="safari-operator">Safari Operator</label></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Theme -->
                                <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                                    <h2 class="accordion-header" id="headingTheme">
                                        <button class="accordion-button collapsed bg-transparent px-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTheme"
                                            aria-expanded="false" aria-controls="collapseTheme">
                                            Theme
                                        </button>
                                    </h2>
                                    <div id="collapseTheme" class="accordion-collapse collapse"
                                        aria-labelledby="headingTheme" data-bs-parent="#filterAccordion">
                                        <div class="accordion-body pt-0">
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="photography"> <label class="form-check-label"
                                                    for="photography">Photography</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="safari-experience"> <label class="form-check-label"
                                                    for="safari-experience">Safari Experience</label></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Budget -->
                                <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                                    <h2 class="accordion-header" id="headingFive">
                                        <button class="accordion-button collapsed bg-transparent px-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            Budget
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse"
                                        aria-labelledby="headingFive" data-bs-parent="#filterAccordion">
                                        <div class="accordion-body pt-0">
                                            <div class="range-slider position-relative">
                                                <div class="slider-track"></div>
                                                <input type="range" id="minRange" min="1000" max="10000"
                                                    step="500" value="1000">
                                                <input type="range" id="maxRange" min="1000" max="10000"
                                                    step="500" value="10000">
                                            </div>
                                            <div class="range-values d-flex justify-content-between mb-2">
                                                <span id="minPrice">₹1000</span>
                                                <span id="maxPrice">₹10000</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tour Duration -->
                                <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                                    <h2 class="accordion-header" id="headingDuration">
                                        <button class="accordion-button collapsed bg-transparent px-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseDuration"
                                            aria-expanded="false" aria-controls="collapseDuration">
                                            Tour Duration
                                        </button>
                                    </h2>
                                    <div id="collapseDuration" class="accordion-collapse collapse"
                                        aria-labelledby="headingDuration" data-bs-parent="#filterAccordion">
                                        <div class="accordion-body pt-0">
                                            <div class="range-slider position-relative mb-3">
                                                <div
                                                    class="slider-track position-absolute top-50 start-0 w-100 translate-middle-y">
                                                </div>
                                                <input type="range" id="minDays" min="1" max="6"
                                                    step="1" value="1" class="position-absolute w-100"
                                                    style="pointer-events: none;">
                                                <input type="range" id="maxDays" min="1" max="7"
                                                    step="1" value="7" class="position-absolute w-100">
                                            </div>
                                            <div class="range-values d-flex justify-content-between">
                                                <span id="minLabel">1D/2N</span>
                                                <span id="maxLabel">6D/7N+</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Safari -->
                                <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                                    <h2 class="accordion-header" id="headingSafari">
                                        <button class="accordion-button collapsed bg-transparent px-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSafari"
                                            aria-expanded="false" aria-controls="collapseSafari">
                                            Total Safaris
                                        </button>
                                    </h2>
                                     <div id="collapseSafari" class="accordion-collapse collapse"
                                    aria-labelledby="headingSafari" data-bs-parent="#filterAccordion">
                                    <div class="accordion-body pt-0">
                                        <div class="range-slider position-relative mb-3">
                                            <div class="slider-track position-absolute top-50 start-0 w-100 translate-middle-y"></div>
                                            <input type="range" id="minSafari" min="1" max="5" step="1" wire:model.live="minSafari" class="position-absolute w-100">
                                            <input type="range" id="maxSafari" min="1" max="6" step="1" wire:model.live="maxSafari" class="position-absolute w-100">
                                        </div>
                                        <div class="range-values d-flex justify-content-between">
                                            <span id="minSafariLabel">{{ $minSafari }} Safari</span>
                                            <span id="maxSafariLabel">{{ $maxSafari == 8 ? '5+ Safaris' : $maxSafari . ' Safaris' }}</span>
                                        </div>
                                    </div>
                                </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="col-12 col-md-8 col-lg-9 main-content-scroll">
                    <div class="filter-applied-container">
                        <div class="d-sm-flex align-items-center justify-content-between mb-2 flex-wrap">
                            <div class="what's-found mb-md-0 mb-3">
                                <p class="mb-0">We found <b>3</b> Active Shared Safari</p>
                            </div>
                            <div class="d-md-inline-block d-flex align-items-center justify-content-between mb-3">
                                <div class="sort-by mb-sm-0">
                                    <select class="form-select custom-dropdown">
                                        <option selected>Popular</option>
                                        <option value="latest">Latest</option>
                                        <option value="trending">Trending</option>
                                        <option value="top">Top Rated</option>
                                    </select>
                                </div>
                                
                                <!-- Filter Toggle Button (Visible on Mobile) -->
                                <div class="d-md-none">
                                    <button class="btn" id="openFilter">
                                        <svg class="me-1 small" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="var(--text-dark)">
                                            <path
                                                d="M440-120v-240h80v80h320v80H520v80h-80Zm-320-80v-80h240v80H120Zm160-160v-80H120v-80h160v-80h80v240h-80Zm160-80v-80h400v80H440Zm160-160v-240h80v80h160v80H680v80h-80Zm-480-80v-80h400v80H120Z" />
                                        </svg></button>
                                </div>
                            </div>
                            
                        </div>
                        <div class="clear-all-btn">
                                <a href="#" wire:click.prevent="clearAll" class="text-decoration-none text-blue">
                                    Clear All
                                </a>
                            </div>
                    </div>
                     <section id="join-shared-safari" class="mb-md--5 mb--3 pb--1">
                        <div class="card-container row align-items-center gx-3">
                            @foreach ($packages as $shareSafari)
                                <div class="col-xl-4 col-sm-6 join-safari-card-box mt-3 rounded-3"
                                    wire:key="{{ $shareSafari->id }}">
                                    <div class="card rounded-3">
                                        <!-- Card Image -->
                                        <img class="card-img-top rounded-top-3"
                                            src="{{ asset($shareSafari->display_image) }}" alt="Card image">
                                        <!-- Card Body -->
                                        <div class="card-body p-0 rounded=bottom-3">
                                            <div class="card-body-inner border-bottom">
                                                <div class="card-title border-bottom pb-1">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h4 class="mb-0 card-text">
                                                            {{ ucwords($shareSafari->title) }}
                                                        </h4>
                                                        <div class="count-days px-2 rounded-1">
                                                            <span class="text-white">3N/4D</span>
                                                        </div>
                                                    </div>
                                                    <div class="cityplace-text">
                                                        <span> {{ ucwords($shareSafari->park->title) }},
                                                            {{ ucwords($shareSafari->park->state->name) }}</span>
                                                    </div>
                                                </div>
                                                <div class="card-text">
                                                    <!-- Highlights partition -->
                                                    <div
                                                        class="highlights  highlights-list d-flex flex-wrap gap-1 align-items-center">
                                                        <div class="mb-2">
                                                            <div
                                                                class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/permit.svg') }}"
                                                                    alt="Safari Permit">
                                                                <p class="mb-0">Safari Permits</p>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <div
                                                                class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/accommodation.svg') }}"
                                                                    alt="Accommodation">
                                                                <p class="mb-0">Accommodation</p>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <div
                                                                class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/meals.svg') }}"
                                                                    alt="Meals">
                                                                <p class="mb-0">Meals</p>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <div
                                                                class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/guide.svg') }}"
                                                                    alt="Guide">
                                                                <p class="mb-0">Guide</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Known for partition -->
                                                    <div class="knowfor-list mb-2">
                                                        <h6 class="mb-0">Known For:</h6>
                                                        <div
                                                            class="highlights d-flex align-items-center flex-wrap column-gap-2">
                                                            <div
                                                                class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/dot.svg') }}"
                                                                    alt="Safari Permit">
                                                                <p class="mb-0">Safari Permits</p>
                                                            </div>
                                                            <div
                                                                class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/dot.svg') }}"
                                                                    alt="Accommodation">
                                                                <p class="mb-0">Accommodation</p>
                                                            </div>

                                                            <div
                                                                class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/dot.svg') }}"
                                                                    alt="Meals">
                                                                <p class="mb-0">Meals</p>
                                                            </div>

                                                            <div
                                                                class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/dot.svg') }}"
                                                                    alt="Guide">
                                                                <p class="mb-0">Guide</p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex align-items-center justify-content-between card-body-inner py-2 price-container flex-wrap">
                                                <div class="starting-price">
                                                    <p class="mb-0">Starting Price:</p>
                                                    <span
                                                        class="mb-0 text-muted">₹ {{ $shareSafari->park->safari_cost }}</span>
                                                </div>
                                                <a href="{{ route('safari-package-detail',$shareSafari->slug) }}"
                                                    class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1">Join
                                                    Safari</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($packages->count() >= $perPage)
                                <div class="col-12 text-center mt-4 pt-2">
                                    <button wire:click="loadsafarisMore"
                                        class="btn btn-primary blue-btn-hover btn-sm border-0 px-3">
                                        Load More
                                    </button>
                                </div>
                            @endif
                        </div>
                    </section>
                    @if ($carousel)      
                        <!-- Top Rated Park  -->
                        <section id="top-rated-park" class="mt-4 pt-2">
                            <div class="heading-text text-center mb-xl-4 mb-3">
                                <div class="">
                                    <h2 class="mb-0 text-accent">Top Rated Parks</h2>
                                    <img src="{{ asset('front-assets/images/blue-border-vector.png') }}"
                                        alt="Vector-Border" class="vector-border-bottom">
                                </div>
                            </div>
                        <div class="owl-carousel owl-theme" id="top-rated-park-owl"
                                    x-data x-init="$nextTick(() => initOwlCarousel())"
                                    x-effect="$nextTick(() => initOwlCarousel())">
    >

                                @foreach ($park_datas as $park_data)

                                    <div class="item">
                                        <div class="owl-slide text-center mx-auto">
                                            <div
                                                class="card park-card border-0 shadow-sm position-relative overflow-hidden">
                                                <img src="{{ asset($park_data->display_image) }}"
                                                    class="img-fluid" alt="Park Image">

                                                <!-- Name Bar -->
                                                <div
                                                    class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-center py-2 park-name transition">
                                                    <h3 class="top-park-title mb-0">{{ $park_data->title }}</h3>
                                                </div>

                                                <!-- Description Panel -->
                                                <div
                                                    class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-start px-2 py-3 park-info transition ps-3">
                                                    <div>
                                                        <h5 class="fw-semibold top-park-title">{{ $park_data->title }}
                                                        </h5>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between gap-1">
                                                        <div>
                                                            <p class="mb-0 small">{{ $park_data->short_description }}</p>
                                                        </div>
                                                        <a href="javascript:void(0)"
                                                            class="readmorearrow text-decoration-none">
                                                            <i
                                                                class="fa-solid fa-arrow-right text-white p-1 border blue-border-hover rounded-circle border-white border-3"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </section>
                    @endif
                </div>
            </div>
    </main>
    </div>


