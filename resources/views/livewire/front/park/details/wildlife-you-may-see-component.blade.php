<div>
    @if ($parkSpecies->count() > 0)
        <div class="heading-text text-center mb-xl-4 mb-3">
            <h2 class="mb-0 text-accent">Wildlife You May See !!!</h2>
            <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                class="vector-border-bottom">
        </div>

        <div class="row">
            @foreach ($parkSpecies as $species)
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="{{ route('species.detail', $species->speciesList->slug) }}"
                        class="text-decoration-none fw-bold">
                        <div class="wildlife-img">
                            <img src="{{ asset($species->speciesList->display_image) }}"
                                alt="{{ $species->speciesList->name }}" class="img-fluid">
                            <div class="wildlife-text text-center px-4">
                                <h6>{{ $species->speciesList->name }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        @if ($parkSpecies->count() < $totalCount)
            <div class="text-center mt-4">
                <button wire:click="loadMore" class="btn btn-primary">
                    Load More
                </button>
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
