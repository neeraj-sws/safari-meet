<div>
    <section id="home-hero"
            class="search-hero listing-page-hero d-flex align-items-center justify-content-center text-center text-white mb-4">
            <div class="container-fluid container-padding">
                <div class="bannertext text-center">
                    <h1 class="text-white">Search Results</h1>
                    <div class="input-group stylish-search w-100 mx-auto mt-4" style="max-width: 500px;">
                       <input type="text" class="form-control border-end-0 shadow-none rounded-start-3"
                            wire:model.live="search"
                            placeholder="Park.." aria-label="Search">
                        <button class="btn btn-accent text-white fw-semibold border-0 px-sm-4 px-3 rounded-end-3" type="button">
                            <span class="d-sm-block d-none">Search</span>
                            <span class="d-sm-none d-block">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                        </button>
                    </div>

                </div>
            </div>
        </section>

        <section id="search-section">
            <div class="container-lg container-inner-padding">
                <div class="row g-3 position-relative mb-sm-5 mb-4">
                    <div class="col-12 text-center my-3">
                        <h3 class="text-blue mb-0">{{$totalCount}} Results found for 'National Parks'</h3>
                    </div>
                     @foreach ($parkLists as $parkValue)
                     <div class="col-xl-3 col-md-4 col-sm-6">
                         <div class="card search-card rounded-3">
                             <div class="card-img-top p-2 rounded-3">
                                 <img src="{{ asset($parkValue->display_image)}}" alt=""
                                     class="img-fluid rounded-3">
                             </div>
                             <div class="card-body p-2 pt-0">
                                 <div class="card-title">
                                     <small class="small-text lh-1">{{ $parkValue->formatted_established }}</small>
                                     <p class="mb-0 mt-2">{{$parkValue->name}}
                                     </p>
                                 </div>

                                 <div class="card-text mb-1">
                                     <p class="mb-3"> {{$parkValue?->short_description}} </p>
                                     <a href="{{route('park.detail', $parkValue->slug)}}"
                                         class="text-decoration-none btn btn-sm blue-btn-hover btn-primary border-0 d-block rounded-1">
                                         View More
                                     </a>
                                 </div>
                             </div>
                         </div>
                     </div>
                     @endforeach
                </div>
            </div>
        </section>

</div>
@push('scripts')
<script>
   document.addEventListener('livewire:init', () => {
    initOwl();
    console.log('init');
});

Livewire.hook('message.processed', (message, component) => {
    initOwl();
    console.log('Carousel Re-Init After Livewire DOM Update');
});

function initOwl() {
    let $owl = $('#top-rated-park-owl.owl-carousel');
    if ($owl.hasClass('owl-loaded')) {
        $owl.trigger('destroy.owl.carousel').removeClass('owl-loaded');
        $owl.find('.owl-stage-outer').children().unwrap();
    }

    $owl.owlCarousel({
        loop: true,
        rewind: true,
        autoplay: false,
        margin: 10,
        nav: false,
        dots: true,
        smartSpeed: 600,
        responsive: {
            0: { items: 1 },
            576: { items: 2 },
            992: { items: 3 },
            1200: { items: 3.2 }
        }
    });
}

</script>
@endpush
