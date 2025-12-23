<div>
    @php
        use App\Helpers\SettingHelper;
    @endphp
    <main>
        <!-- Hero Section -->
        <section id="home-hero"
            class="search-hero listing-page-hero d-flex align-items-center justify-content-center text-center text-white mb-4">
            <div class="container-fluid container-padding">
                <div class="bannertext text-center">
                    <h1 class="text-white">Wishlist</h1>
                </div>
            </div>
        </section>

        <div class="container-lg container-inner-padding">
            <div class="secion-faq mb-4 package-accordion" id="section-faq">
                <div class="accordion all-accordion p-3 rounded-3 dark-grey-bg row" id="faqAccordion">
                    <div class="card mb-3 rounded-3">
                        <div class="card-body">
                            <!-- About -->
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <h3 class="mb-0">Shared Safari Wishlist</h3>
                                </div>
                                @if (count($sharedSafariWishlist) > 0)
                                    @foreach ($sharedSafariWishlist as $sharedSafari)
                                        <div class="col-xl-4 col-sm-6 join-safari-card-box mt-3 rounded-3"
                                            wire:key="{{ $sharedSafari->id }}">
                                            <div class="card rounded-3">
                                                <!-- Card Image -->
                                                <a
                                                    href="{{ route('shared-safari.detail', $sharedSafari->sharedSafari->slug) }}">
                                                    @if (!empty($sharedSafari->sharedSafari->display_image))
                                                        <img class="card-img-top rounded-top-3"
                                                            style="width:100%; height:220px; object-fit:cover;"
                                                            src="{{ asset($sharedSafari->sharedSafari->display_image) }}"
                                                            alt="Card image">
                                                    @else
                                                        <img class="card-img-top rounded-top-3"
                                                            style="width:100%; height:220px; object-fit:cover;"
                                                            src="{{ asset('assets/images/GPT-1.png') }}"
                                                            alt="Card image">
                                                    @endif
                                                </a>
                                                <!-- Card Body -->
                                                <div class="card-body p-0">
                                                    <div class="card-body-inner border-bottom">
                                                        <div class="card-title border-bottom pb-1">
                                                            <div
                                                                class="d-flex align-items-center justify-content-around">
                                                                <h4 class="mb-0 card-text">
                                                                    {{ ucwords($sharedSafari->sharedSafari->title) }}
                                                                </h4>
                                                            </div>
                                                            <div class="cityplace-text">
                                                                <span>
                                                                    {{ ucwords($sharedSafari->sharedSafari->park->name) }},
                                                                    {{ ucwords($sharedSafari->sharedSafari->park->state->name) }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="card-text">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="text-center">
                                                                    <p class="mb-0">Safari</p>
                                                                    <p class="mb-0">
                                                                        {{ $sharedSafari->sharedSafari->no_of_safari }}
                                                                    </p>
                                                                </div>
                                                                <div class="text-center">
                                                                    <p class="mb-0">Seats</p>
                                                                    <p class="mb-0 fw-bold">
                                                                        {{ $sharedSafari->sharedSafari->share_seats }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body-inner py-2 price-container flex-wrap">
                                                        <div class="starting-price mb-2 text-center">
                                                            <p class="mb-0">Price:
                                                                <span class="mb-0 text-muted">₹
                                                                    {{ $sharedSafari->sharedSafari->min_price_pp }}
                                                                    - ₹
                                                                    {{ $sharedSafari->sharedSafari->max_price_pp }}</span>
                                                            </p>
                                                        </div>
                                                        <div class="text-center">
                                                            <a href="{{ route('shared-safari.detail', $sharedSafari->sharedSafari->slug) }}"
                                                                id="join_safari_{{ $sharedSafari->sharedSafari->id }}"
                                                                class="btn btn-sm border border-blue blue-border-hover blue-text-hover border-2 rounded-1 text-center">
                                                                View Details
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    @if ($sharedSafariWishlist->count() >= $perPage)
                                        <div class="col-12 text-center mt-4 pt-2">
                                            <button wire:click="loadMore"
                                                class="btn btn-primary blue-btn-hover btn-sm border-0 px-3">
                                                Load More
                                            </button>
                                        </div>
                                    @endif
                                @else
                                    <div class="col-12">
                                        <h3 class="m-2 text-center">No Shared Safari Wishlist</h3>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- The rest of your HTML for joined safaris remains the same -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <!-- About -->
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="mb-0">Package Safari Wishlist
                                    </h3>
                                </div>
                                @if (count($packageWishlist) > 0)
                                    @foreach ($packageWishlist as $package)
                                        <div class="col-xl-4 col-sm-6 join-safari-card-box mt-3 rounded-3"
                                            wire:key="{{ $package->package->id }}">
                                            <div class="card" rounded-3>
                                                <!-- Card Image -->
                                                <img class="card-img-top rounded-top-3"
                                                    src="{{ asset($package->package->display_image) }}" alt="Card image">
                                                <!-- Card Body -->
                                                <div class="card-body p-0">
                                                    <div class="card-body-inner border-bottom">
                                                        <div class="card-title border-bottom pb-1">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between">
                                                                <h4 class="mb-0 card-text text-truncate">
                                                                    {{ ucwords($package->package->title) }}
                                                                </h4>
                                                                <div class="count-days px-2 rounded-1">
                                                                    <span class="text-white">
                                                                        {{ $package->package?->end_tour }}N/{{ $package->package?->start_tour }}D
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="cityplace-text text-truncate">
                                                                <span> {{ ucwords($package->package->park->name) }},
                                                                    {{ ucwords($package->package->park->state->name) }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="card-text">
                                                            <!-- Highlights partition -->
                                                            <div>
                                                                <ul
                                                                    class="highlights highlights-grid knowfor-list ps-0 d-flex flex-wrap align-items-center">
                                                                    @php
                                                                        $inclusionList = App\Helpers\UserHelper::inclusionList(
                                                                            $package->package->tour_highlights,
                                                                        );
                                                                    @endphp
                                                                    @if (count($inclusionList) > 0)
                                                                        @foreach ($inclusionList as $list)
                                                                            <li
                                                                                class="card-list-text d-flex align-items-center gap-1 mb-md-0 mb-0">
                                                                                @php
                                                                                    $iconWithSize = str_replace(
                                                                                        '<i',
                                                                                        '<i style="font-size: 10px;"',
                                                                                        $list->icon,
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
                                                            <div class="knowfor-list mt-1 mb-1">
                                                                <h6 class="mb-0">Known For:</h6>
                                                            </div>
                                                            <ul
                                                                class="highlights highlights-grid knowfor-list ps-0 d-flex flex-wrap align-items-center">
                                                                @php
                                                                    $wildlife = $package->package?->park?->wildlife ?? [];
                                                                @endphp
                                                                @if (count($wildlife) > 0)
                                                                    @foreach ($wildlife as $list)
                                                                        <li
                                                                            class="card-list-text d-flex align-items-center gap-1 mb-md-0 mb-0">
                                                                            <i class="fa fa-circle"
                                                                                style="font-size: 6px;"
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
                                                        class="d-flex align-items-center justify-content-between card-body-inner py-2 price-container flex-wrap">
                                                        <div class="starting-price">
                                                            <p class="mb-0">Starting Price:</p>
                                                            <span
                                                                class="mb-0 text-muted">₹ {{ SettingHelper::formatPrice($package->package->min_price_pp) }}</span>
                                                        </div>
                                                        <a href="{{ route('safari-package.detail', $package->package->slug) }}"
                                                            id="join_safari_{{ $package->package->id }}"
                                                            class="btn btn-sm border border-blue blue-border-hover blue-text-hover border-2 rounded-1">
                                                            View Details
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    @if ($packageWishlist->count() >= $joinPerPage)
                                        <div class="col-12 text-center mt-4 pt-2">
                                            <button wire:click="joinedLoadMore"
                                                class="btn btn-primary blue-btn-hover btn-sm border-0 px-3">
                                                Load More
                                            </button>
                                        </div>
                                    @endif
                                @else
                                    <div class="col-12 ">
                                        <h3 class="m-2 text-center"> No Package Safari Wishlist </h3>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
