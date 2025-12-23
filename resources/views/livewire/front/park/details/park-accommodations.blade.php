<div>
    @if (count($park_accommodations) > 0)
        <div class="tab-pane fade active show" id="accommodation" role="tabpanel" aria-labelledby="accommodation-tab">
            <div class="heading-text text-center mb-xl-4 mb-3">
                <div class="">
                    <h2 class="mb-0 text-accent">Accommodation Options</h2>
                    <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                        class="vector-border-bottom">
                </div>
            </div>
            <div class="row mb-3 gx-3">
                @foreach ($park_accommodations as $accommodations)
                    <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 mb-3">
                        <div class="promo-card p-3 rounded-4 bg-white overflow-hidden d-flex align-items-center">
                            <!-- Top Row: Rating + Icon -->
                            <div class="w-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div
                                        class="rating-pill-dark d-flex align-items-center gap-1 rounded-pill text-white">
                                        <i class="fa-solid fa-star"></i>
                                        {{ $accommodations->accommodationList->rating ?? '4.5' }} Star
                                    </div>
                                </div>


                                <h6 class="fw-bold mb-1">{{ $accommodations->accommodationList->title ?? 'Null' }}</h6>
                                <div class="accommodation-subtitle">
                                    <p class="text-muted mb-0">{{ $accommodations->accommodationList->rating }}-Star
                                        Resort </p>
                                    <p class="text-muted mb-3">
                                        <i class="fa-solid fa-location-dot me-1"></i>
                                        {{ $accommodations->accommodationList->cuntry->name }}-{{ $accommodations->accommodationList->state->name }}-{{ $accommodations->accommodationList->city->name }}
                                    </p>
                                </div>
                            </div>
                            <!-- Image -->
                            @if ($accommodations->accommodationList->first() && $accommodations->accommodationList->first()->image->first())
                                <img src="{{ asset($accommodations->accommodationList->first()->image->first()->image) }}"
                                    alt="{{ $accommodations->title ?? 'Kingfisher Resort' }}"
                                    class="promo-img rounded-4 img-fluid">
                            @else
                                <img src="{{ asset('front-assets/images/park-detail/accommodation-1.webp') }}"
                                    alt="{{ $accommodations->title ?? 'Kingfisher Resort' }}"
                                    class="promo-img rounded-4 img-fluid">
                            @endif
                        </div>
                    </div>
                @endforeach
                @if ($park_accommodations->count() < $totalCount)
                    <div class="text-center mt-4">
                        <button wire:click="loadMore" class="btn btn-primary">
                            Load More
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="text-center">
            <img src="{{ asset('front-assets/images/cat-with-magnifying-glass-illustration-svg-png-download-11511372.png') }}"
                class="freepikimg" style="width:350px;">
            <h6>Data Not Found</h6>
        </div>
    @endif
</div>
