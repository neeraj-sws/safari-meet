<div>
    @if (count($topParks) > 0)

    <div class="heading-text text-center mb-xl-4 mb-3">
        <h2 class="mb-0 text-accent">Top Rated Parks</h2>
        <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
            class="vector-border-bottom">
    </div>

    <div class="slick-slider" id="top-rated-park-owl">
        @forelse ($topParks as $park)
        <div class="item">
            <div class="owl-slide text-center mx-auto">
                <div class="card park-card border-0 shadow-sm position-relative overflow-hidden">
                    <a href="{{ route('park.detail',$park->slug) }}">
                        <img src="{{ asset($park->display_image ?? 'default-image.jpg') }}" class="img-fluid"
                            alt="{{ $park->name ?? 'Park' }}">
                    </a>

                    <div
                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-center py-2 park-name transition">
                        <h3 class="top-park-title mb-0">{{ ucwords($park?->name) ?? 'Park' }}</h3>
                    </div>

                    <div
                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-start px-2 py-3 park-info transition ps-3">
                        <h5 class="fw-semibold top-park-title">{{ ucwords($park->name) ?? 'Park' }}</h5>
                        <div class="d-flex align-items-end justify-content-between gap-1">
                            <p class="mb-0 small">{{ ucwords($park->short_description) ?? 'Details' }}</p>
                            <a href="{{ route('park.detail', $park->slug) }}"
                                class="readmorearrow text-decoration-none">
                                <i
                                    class="fa-solid fa-arrow-right text-white p-1 border blue-border-hover rounded-circle border-white border-3"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">No top-rated parks available.</p>
        @endforelse
    </div>
    @endif
</div>

@push('scripts')
{{-- <script>
    document.addEventListener("livewire:init", () => {
            window.initTopRatedCarousel = function() {
                const owl = $('#top-rated-park-owl.owl-carousel');
                if (owl.find('.item').length <= 3) {
                    owl.addClass('no-carousel');
                }
                owl.owlCarousel({
                    loop: true,
                    rewind: true,
                    autoplay: true,
                    margin: 10,
                    nav: false,
                    dots: true,
                    smartSpeed: 600,
                    responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 2
                    },
                    992: {
                        items: 3
                    },
                    1200: {
                        items: 3
                    }
                }
                });
            };

            Livewire.hook('morph.updated', () => {
                setTimeout(() => {
                    initTopRatedCarousel();
                }, 100);
            });

            initTopRatedCarousel();
        });
</script> --}}
@endpush
