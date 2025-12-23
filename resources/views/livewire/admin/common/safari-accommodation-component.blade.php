<div>
    <div class="row">
        <div class="col-lg-12">

            <div class="text-end mb-3">
                <button type="button" wire:click="$toggle('showForm')"
                    class="btn btn-{{ $showForm ? 'secondary' : 'primary' }} btn-sm">
                    {{ $showForm ? 'Hide Form' : '+ Add accommodations' }}
                </button>
            </div>

            @if ($showForm)
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Add accommodations</h5>
                    </div>

                    <div class="card-body">

                        <div class="mb-4">
                            <label class="form-label fw-bold"> Accommodations <sup class="text-danger">*</sup>
                            </label>
                            <select wire:model.live="accommodation"
                                class="form-select form-select-lg rounded-3 shadow-sm select2" id="accommodation">
                                <option value="">-- Select Feature --</option>
                                @foreach ($featureOptions as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('accommodation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showForm', false)">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="store">
                            <i class="bi bi-save"></i> Save
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-body">
                    <div class="section-accommodation p-3 rounded-3 dark-grey-bg mb-4" id="section-accommodation">
                        <div class="bg-white px-4 py-3 rounded-3">
                            @if ($data && $data->accommodation)
                                <div class="row">
                                    {{-- Left side images (desktop) --}}
                                    <div class="col-xl-6 mb-xl-0 mb-3 d-sm-block d-none">
                                        <div class="row row-gap-3 gx-3">
                                            @foreach ($data->accommodation->image->take(4) as $img)
                                                <div class="col-6">
                                                    <div class="accommodation-right">
                                                        <img src="{{ asset($img->image) }}" alt="Accommodation Image"
                                                            class="img-fluid w-100 rounded-3">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-xl-6 mb-xl-0 mb-3 ps-xl-1 d-sm-block d-none">
                                        @if ($data->accommodation->image->skip(4)->first())
                                            <div class="accommodation-left mb-3">
                                                <img src="{{ asset($data->accommodation->image->skip(2)->first()->image) }}"
                                                    class="img-fluid w-100 rounded-3" alt="Accommodation">
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Owl Carousel for mobile only --}}
                                    <div class="col-12 d-sm-none owl-carousel owl-theme mb-3">
                                        @foreach ($data->accommodation->image as $img)
                                            <div class="item">
                                                <img src="{{ asset($img->image) }}" alt="Accommodation"
                                                    class="img-fluid rounded-3 accommodation-mobile-img">
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Accommodation Details --}}
                                    <div class="col-12">
                                        <div class="lodge-name">
                                            <h3 class="mb-1 text-accent">{{ $data->accommodation->title }}</h3>
                                            @php
                                                $rating = $data->accommodation->rating ?? 0;
                                                $fullStars = floor($rating);
                                                $halfStar = $rating - $fullStars >= 0.5 ? 1 : 0;
                                                $emptyStars = 5 - ($fullStars + $halfStar);
                                            @endphp

                                            <div class="star-rating d-flex align-items-center gap-1 mb-1">

                                                @for ($i = 0; $i < $fullStars; $i++)
                                                    <img src="{{ asset('front-assets/images/icons/star-fill.png') }}"
                                                        alt="Full Star">
                                                @endfor
                                                @if ($halfStar)
                                                    <img src="{{ asset('front-assets/images/icons/half-fill.png') }}"
                                                        alt="Half Star">
                                                @endif
                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                    <img src="{{ asset('front-assets/images/icons/star-fill.png') }}"
                                                        alt="Empty Star" style="opacity: 0.3;">
                                                @endfor
                                            </div>
                                            <div class="category">
                                                <span class="text-dark">Category:</span>
                                                <p class="text-dark d-inline-block">
                                                    {{ $data->accommodation->category->name ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="amenities-container">
                                            <h3 class="text-blue">Amenities</h3>
                                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                                @foreach ($data->accommodation->amenity as $amenity)
                                                    <div class="amenities me-3">
                                                        {!! $amenity?->amenity->icon !!}
                                                        <span class="text-dark">
                                                            {{ $amenity?->amenity->title ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-12">
                                    <p class="text-muted">No Data added yet.</p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
