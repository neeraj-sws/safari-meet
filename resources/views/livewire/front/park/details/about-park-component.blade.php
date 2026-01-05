<div>
    @if (count($aboutPark) > 0)
    <div>
        <div class="heading-text text-center mb-xl-4 mb-3">
            <div class="">
                <h2 class="mb-0 text-accent">About {{ $parkdetails->name }}</h2>
                <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                    class="vector-border-bottom">
            </div>
        </div>
        @foreach ($aboutPark as $about)
        @php
        $isEven = $loop->iteration % 2 === 0;
        @endphp
        <div class="about-section  {{ $isEven ? 'left' : 'right' }}">
            <div class="img-box">
                <img src="{{ asset($about->image) }}" alt="Detail-1" class="img-fluid" loading="lazy">
            </div>

            <div class="text-box">
                <h3 class="text-blue">
                    {{ $about->title }}
                </h3>
                <div class="">
                    {!! $about->short_description !!}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center">
        <img src="{{ asset('front-assets/images/cat-with-magnifying-glass-illustration-svg-png-download-11511372.png') }}"
            class="freepikimg" style="width:350px;">
        <h6>Data Not Found</h6>
    </div>
    @endif
</div>
