 <div>
     @php
         use App\Helpers\SettingHelper;
     @endphp

     @if ($parkSearchPage == true)
         <livewire:front.search-result :state="$destination" />
     @else
         <!-- Hero Section -->
         <section id="home-hero" class="d-flex align-items-center justify-content-center text-center text-white"
             style="background-image:url({{ $homePageBanner->display_image }})">
             <div class="container-fluid container-padding">
                 <div class="bannertext text-center">
                     <h1 class="text-white">{{ $homePageBanner->title }}</h1>
                 </div>
             </div>
         </section>


         <!-- Filter Section -->
         <section id="filter-box-section" class="mb-md-3 mb-3 pb-1">
             <div class="container-lg">
                 <div class="">
                     <form>
                         <div class="container- z--1 filter-box mx-auto">
                             <div class="d-flex align-items-center flex-wrap">
                                 <div
                                     class="filter-box-items d-flex justify-content-center align-items-center mx-auto flex-lg-nowrap flex-wrap">
                                     <!-- Select Park -->
                                     <div
                                         class="filter-item d-flex flex-column bg-white rounded-top-3 position-relative">

                                         <label class="fw-semibold mb-0" for="destination">Destination</label>
                                         <select class="form-select select2" id="destination" placeholder="All / Any"
                                             wire:model="destination" style="width: 100%;">
                                             <option value="">All / Any</option>
                                             @foreach ($stateLists as $stateValue)
                                                 <option value="{{ $stateValue->id }}">{{ $stateValue->name }}</option>
                                             @endforeach
                                         </select>

                                         <!-- OR DIVIDER -->
                                         <div
                                             class="or-divider position-absolute btn-accent rounded-circle d-flex align-items-center justify-content-center">
                                             <span class="text-white">OR</span>
                                         </div>
                                     </div>

                                     <!-- Destination -->
                                     <div
                                         class="filter-item d-flex flex-column bg-white rounded-top-3 ps-4 position-relative">
                                         <label class="fw-semibold mb-0" for="park">Select Park</label>
                                         <select class="form-select select2" id="park" wire:model="park"
                                             style="width: 100%;">
                                             <option selected>All / Any</option>
                                             @foreach ($parkLists as $parkValue)
                                                 <option value="{{ $parkValue->id }}"> {{ $parkValue->name }}</option>
                                             @endforeach
                                         </select>

                                         <!-- OR DIVIDER -->
                                         <div
                                             class="or-divider position-absolute btn-accent rounded-circle d-flex align-items-center justify-content-center">
                                             <span class="text-white">OR</span>
                                         </div>
                                     </div>

                                     <!-- Species -->
                                     <div
                                         class="filter-item d-flex flex-column bg-white rounded-top-3 ps-4 position-relative">
                                         <label class="fw-semibold mb-0" for="species">Species</label>
                                         <select class="form-select select2" id="species" wire:model="selectspecies"
                                             style="width: 100%;">
                                             <option selected>All / Any</option>
                                             @foreach ($speciesList as $speciesValue)
                                                 <option value="{{ $speciesValue->id }}">
                                                     {{ $speciesValue->speciesList->name }}
                                                 </option>
                                             @endforeach
                                         </select>
                                     </div>
                                     <!-- Search Button -->
                                     <a target="_blank"
                                         class="d-lg-flex justify-content-center align-items-center d-none btn btn-accent rounded-circle"
                                         style="width: 40px; height: 40px;" wire:click="SeachList()">
                                         <i class="fa-solid fa-magnifying-glass text-white"></i>
                                     </a>
                                     <a target="_blank" wire:click="SeachList()"
                                         class="search-button d-lg-none d-block btn btn-accent text-white mt-3 py-1 rounded-3 d-flex justify-content-center align-items-center"
                                         style="">
                                         Search
                                     </a>
                                 </div>

                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </section>
         @if (count($shareSafaris) > 0)
             <!-- Join Shared Safari Section  -->
             <section id="join-shared-safari" class="mb-md-3 mb-3 pb-1">
                 <div class="container-lg container-inner-padding">
                     <div class="heading-text d-flex align-items-center justify-content-between flex-wrap mb-xl-4 mb-3">
                         <div class="me-5 mb-sm-0 mb-2">
                             <h2 class="mb-0 text-blue">Join a Shared Safari</h2>
                             <img src="{{ asset('front-assets/images/Vector.png') }}" alt="Vector-Border" loading="lazy"
                                 class="vector-border-bottom">
                         </div>
                         <div class="viewall-link">
                             <a href="{{ route('shared-safari.list') }}" class="text-decoration-none">View All
                                 <i class="fa-solid fa-arrow-right"></i>
                             </a>
                         </div>
                     </div>
                     <div class="card-container row align-items-center justify-content-flex-start gx-3">
                         @foreach ($shareSafaris as $shareSafari)
                             <div class="col-xl-4 col-sm-6 join-safari-card-box rounded-3"
                                 wire:key="{{ $shareSafari->id }}">
                                 <div class="card rounded-3">
                                     <a href="{{ route('shared-safari.detail', $shareSafari->slug) }}">
                                         @if (!empty($shareSafari->display_image))
                                             <img class="card-img-top rounded-top-3" loading="lazy"
                                                 src="{{ asset($shareSafari->display_image) }}" alt="Card image">
                                         @else
                                             <img class="card-img-top rounded-top-3" loading="lazy"
                                                 src="{{ asset('assets/images/GPT-1.png') }}" alt="Card image">
                                         @endif
                                     </a>
                                     <div class="card-body p-0">
                                         <div class="card-body-inner border-bottom p-0">
                                             <div class="card-title border-bottom p-2">
                                                 <div class="d-flex align-items-center justify-content-between mb-1">
                                                     <h4 class="mb-0 card-text">
                                                         {{ ucwords($shareSafari->title) }}
                                                     </h4>
                                                 </div>
                                                 <div class="cityplace-text">
                                                     <span> {{ ucwords($shareSafari?->park?->name) }},
                                                         {{ ucwords($shareSafari?->park?->state?->name) }}</span>
                                                 </div>
                                             </div>
                                             <div class="card-text">
                                                 <div class="d-flex justify-content-between align-items-center p-2">
                                                     <div class="text-center">
                                                         <p class="mb-0 total-safari">Safari</p>
                                                         <p class="mb-0 total-safari-in-number">{{ $shareSafari->no_of_safari }}</p>
                                                     </div>
                                                     <div class="text-center">
                                                         <p class="mb-0 total-seat">Seats</p>
                                                         <p class="mb-0 total-seat-in-number">{{ $shareSafari->share_seats }}</p>
                                                     </div>
                                                     <div class="text-center">
                                                         <p class="mb-0 organizer">Organized by</p>
                                                         @if ($shareSafari->organized_type === 'admin')
                                                             <p class="mb-0 organizer_name">Admin</p>
                                                         @else
                                                             <p class="mb-0 organizer_name">
                                                                 {{ $organizerName = optional($shareSafari->organizer)->name ?? 'Unknown' }}
                                                             </p>
                                                         @endif
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <div
                                             class="d-flex align-items-center justify-content-between card-body-inner p-2 price-container flex-wrap">
                                             <div class="starting-price">
                                                 <p class="mb-0">Price:</p>
                                                 <span class="mb-0 text-muted">
                                                     ₹
                                                     {{ SettingHelper::formatPrice($shareSafari->min_price_pp) }}
                                                     - ₹
                                                     {{ SettingHelper::formatPrice($shareSafari->max_price_pp) }}

                                                 </span>
                                             </div>
                                             <a href="{{ route('shared-safari.detail', $shareSafari->slug) }}"
                                                 id="join_safari_{{ $shareSafari->id }}"
                                                 class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1">
                                                 View Details
                                             </a>
                                         </div>

                                     </div>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                 </div>
             </section>
             <!-- Top Safari Park  -->
         @endif

         @if (count($parks) > 0)
             <section id="top-safari-park" class="grey-bg mb-md-3 mb-4 py-xl-5 py-4" wire:ignore lazy="on-load" >
                 <div class="container-lg container-inner-padding">
                     <div class="heading-text text-center mb-xl-4 mb-3">
                         <div class="">
                             <h2 class="mb-0 text-accent">Top Safari Parks</h2>
                             <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border" loading="lazy"
                                 class="vector-border-bottom">
                         </div>
                     </div>

                     <div class="owl-carousel owl-theme" id="top-safari-park-owl">
                         @foreach ($parks as $park)
                             <div class="item">
                                 <div class="owl-slide text-center mx-auto">
                                     <a href="{{ route('park.detail', $park->slug) }}" class="text-decoration-none">
                                         <img class="card-image rounded-circle border border-5 border-primary mx-auto" loading="lazy"
                                             src="{{ asset($park->display_image) }}" alt="Carousel image">
                                     </a>
                                     <a href="{{ route('park.detail', $park->slug) }}" class="text-decoration-none">
                                         <div class="mt-3">
                                             <h3 class="">{{ ucwords($park->name) }}</h3>
                                             <p class="mb-0 text-dark"> {{ ucwords($park->name) }},
                                                 {{ ucwords($park->state->name) }} </p>
                                         </div>
                                     </a>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                 </div>
             </section>
         @endif
         @if (count($species) > 0)
             <section id="safari-species" class="mb-md-3 mb-3 pb-1">
                 <style>
                     .card-img-top {
                         aspect-ratio: 1 / 1;
                         width: 100%;
                         object-fit: cover;
                     }
                 </style>
                 <div class="container-lg container-inner-padding">

                     <div
                         class="heading-text d-flex align-items-center justify-content-between flex-wrap mb-xl-4 mb-3">
                         <div class="">
                             <h2 class="mb-0 text-blue">Top Species</h2>
                             <img src="{{ asset('front-assets/images/Vector.png') }}" alt="Vector-Border" loading="lazy"
                                 class="vector-border-bottom">
                         </div>
                         <div class="viewall-link">
                             <a href="{{ route('species.list') }}" class="text-decoration-none">View All <i
                                     class="fa-solid fa-arrow-right"></i></a>
                         </div>
                     </div>

                     <div class="row">
                         @foreach ($species as $specie)
                             <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                 <div class="card border-0 rounded-3 overflow-hidden">
                                     <a href="{{ route('species.detail', $specie->slug) }}">
                                         <img src="{{ asset($specie->display_image) }}" loading="lazy"
                                             alt="{{ ucwords($specie->name) }}" class="card-img-top">
                                         <div class="card-img-overlay d-flex align-items-end justify-content-center">
                                             <div
                                                 class="img-caption bg-dark bg-opacity-50 text-white p-2 w-100 text-center">
                                                 {{ ucwords($specie->name) }}
                                             </div>
                                         </div>
                                     </a>
                                 </div>
                             </div>
                         @endforeach
                     </div>

                 </div>
             </section>
         @endif
     @endif
 </div>
