<main wire:init="firstTimeLoading">
    <!-- Hero Section -->
    <section id="home-hero"
        style="background-image: url('{{ asset('front-assets/images/banner-image/home-hero-banner.png') }}');"
        class="listing-page-hero d-flex align-items-center justify-content-center text-center text-white mb-4">
        <div class="container-fluid container-padding">
            <div class="bannertext text-center">
                <h1 class="text-white">Wildlife at a Glance</h1>
            </div>
        </div>
    </section>
    <div class="container-lg container-inner-padding mb-4">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-12">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search species by name..."
                        wire:model.live.debounce.500ms="search">

                    @if($search)
                    <button class="btn btn-outline-secondary" wire:click="clearSearch" type="button">
                        ✕ Clear
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Global Skeleton Loader -->
    <div wire:loading.flex  wire:target="firstTimeLoading, search, loadMore, clearSearch">
        <div class="container-lg container-inner-padding">
            @include('components.skeletons.listing-skeleton', ['count' => 12, 'type' => 'species'])
        </div>
    </div>

    <!-- Real Content -->
    <div wire:loading.remove   wire:target="firstTimeLoading, search, loadMore, clearSearch">
        @if (count($species) > 0)

        <section id="search-section">
            <div class="container-lg container-inner-padding">
                <div class="row">
                    @foreach ($species as $specie)
                    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                        <a href="{{ route('species.detail', $specie->slug) }}" class="text-decoration-none fw-bold">
                            <div class="wildlife-img">
                                <img src="{{ asset($specie->display_image) }}" loading="lazy" alt="{{ $specie->name }}"
                                    class="img-fluid" onerror="this.src='/front-assets/images/default-animal.jpg'">
                                <div class="wildlife-text text-center px-4">
                                    <h6>{{ ucwords($specie->name) }} </h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @if ($species->count() >= $perPage)
                <div class="col-12 text-center mt-4 pt-2">
                    <button wire:click="loadMore" wire:loading.remove
                        class="btn btn-primary blue-btn-hover btn-sm border-0 px-3">
                        Load More
                    </button>
                    <div wire:loading>
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
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
    <!-- End wire:loading.remove -->


    <!-- Top Rated Park  -->
    <section id="top-rated-park" class="mt-3">
        <div class="container-lg container-inner-padding">
            <livewire:front.common.top-rated-parks-carousel :key="'top-rated-parks-species'" />
        </div>
    </section>
</main>
