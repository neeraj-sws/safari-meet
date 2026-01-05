    <main>
        <!-- Hero Section -->
        <section id="home-hero"
            class="search-hero listing-page-hero d-flex align-items-center justify-content-center text-center text-white mb-4">
            <div class="container-fluid container-padding">
                <div class="bannertext text-center">
                    <h1 class="text-white">Wildlife at a Glance</h1>
                </div>
            </div>
        </section>

        <section id="search-section">
            <div class="container-lg container-inner-padding">
                <div class="row">
                  @foreach ($species as $specie)    
                    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                        <a href="{{ route('species-detail',$specie->slug)}}" class="text-decoration-none fw-bold">
                            <div class="wildlife-img">
                                <img src="{{ asset($specie->display_image) }}" alt="Wildlife 1" class="img-fluid">
                                <div class="wildlife-text text-center px-4">
                                    <h6>{{ ucwords($specie->name) }} </h6>
                                </div>
                            </div>
                        </a>
                    </div>
                  @endforeach
                </div>
            </div>
        </section>

        <!-- Top Rated Park  -->
        <section id="top-rated-park" class="mt-3">
            <div class="container-lg container-inner-padding">
                <div class="heading-text text-center mb-xl-4 mb-3">
                    <div class="">
                        <h2 class="mb-0 text-accent">Top Rated Parks</h2>
                        <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border" class="vector-border-bottom">
                    </div>
                </div>


                <div class="owl-carousel owl-theme" id="top-rated-park-owl">
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
            </div>
        </section>
    </main>
