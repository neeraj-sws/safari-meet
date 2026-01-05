<div class="container">
    @include('livewire.components.breadcrumb', [
        'menu' => $pageTitle,
        'submenus' => [['Park' => route('admin.park.park')], $pageTitle],
        'backUrl' => route('admin.allUser'),
    ])
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Title -->
                        <div class="col-6">
                            <label for="Park Name" class="form-label">Park Name <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control text-capitalize @error('park_name') is-invalid @enderror"
                                oninput="filterAndFormatInputs(this, {allowAlpha: true, allowedSpecialChars: '-–()./&,:\'?\''})"
                                wire:model="park_name" placeholder="Enter Park Name">
                            @error('park_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Established -->
                        <div class="col-md-6">
                            <label for="Established" class="form-label">Park Established <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control datepicker @error('established') is-invalid @enderror"
                                data-restrict-future="true"
                                oninput="filterAndFormatInputs(this, {allowNumbers:true, allowedSpecialChars: '-'})"
                                data-nostart="null" wire:model="established">


                            @error('established')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- City -->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="core_zone" class="form-label">Core Zones<sup
                                        class="text-danger">*</sup></label>
                                <input type="text"
                                    class="form-control text-capitalize @error('core_zone') is-invalid @enderror"
                                    wire:model="core_zone"
                                    oninput="filterAndFormatInputs(this, {allowAlpha: true,allowNumbers:true, allowedSpecialChars: '-–()./,:\'?\''})"
                                    placeholder="Enter Mukki, Khatia, Sarhi">
                                @error('core_zone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="buffer_zone" class="form-label">Buffer Zones<sup
                                        class="text-danger">*</sup></label>
                                <input type="text"
                                    class="form-control text-capitalize @error('buffer_zone') is-invalid @enderror"
                                    wire:model="buffer_zone"
                                    oninput="filterAndFormatInputs(this, {allowAlpha: true, allowNumbers:true,allowedSpecialChars: '-–()./,:\'?\''})"
                                    placeholder="Enter Kanha, Mukki, Kisli, Sarhi">
                                @error('buffer_zone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="core_zone_price" class="form-label">Core Zones Price</label>
                                <input type="text"
                                    class="form-control @error('core_zone_price') is-invalid @enderror"
                                    oninput="filterAndFormatInputs(this,{allowNumbers:true,allowedSpecialChars:'-–$₹,'})"
                                    wire:model="core_zone_price" placeholder="1500- 2000">
                                @error('core_zone_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="buffer_zone_price" class="form-label">Buffer Zones Price</label>
                                <input type="text"
                                    class="form-control @error('buffer_zone_price') is-invalid @enderror"
                                    oninput="filterAndFormatInputs(this,{allowNumbers:true,allowedSpecialChars:'-$–₹,'})"
                                    wire:model="buffer_zone_price" placeholder="1500- 2000">
                                @error('buffer_zone_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Short Description -->
                        <div class="col-md-12">
                            <label for="short_description" class="form-label">Short Description <span
                                    class="text-danger">*</span></label>
                            <input id="short_description"
                                class="form-control @error('short_description') is-invalid @enderror"
                                oninput="filterAndFormatInputs(this, {allowAlpha:true, allowNumbers: true, allowedSpecialChars: `-,/–'()`})"
                                wire:model.live="short_description" placeholder="Enter short description"
                                aria-describedby="shortDescriptionError">
                            @error('short_description')
                                <div id="shortDescriptionError" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Safari Types -->
                        <div class="col-lg-6 ">
                            <div class="mb-3">
                                <label for="safariType" class="form-label">Safari Types <sup
                                        class="text-danger">*</sup></label>
                                <select wire:model="safariType" id="safariType" class="form-select select2" multiple
                                    placeholder="Select Safari Type">
                                    <option value="">-- Select Park --</option>
                                    @foreach ($safari_types as $id => $name)
                                        <option value="{{ $id }}" @selected(in_array($id, $safariType))>
                                            {{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('safariType')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Best Time To Visit -->
                        <div class="col-md-6">
                            <label class="form-label">Best Time To Visit </label>
                            <select class="form-control select2 @error('best_time_visit') is-invalid @enderror"
                                wire:model="best_time_visit" multiple id="best_time_visit" placeholder="Select Weather">
                                <option value="">Select Weather</option>
                                @foreach ($BestTimeVisit as $cityId => $bestVisit)
                                    <option value="{{ $bestVisit->id }}" @selected(in_array($bestVisit->id, $best_time_visit))>
                                        {{ $bestVisit->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('best_time_visit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Wildlife Found -->
                        <div class="col-md-6">
                            <label class="form-label">Wildlife Found <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('wildlife_found') is-invalid @enderror"
                                wire:model="wildlife_found" id="wildlife_found" multiple
                                placeholder="Select Wildlife">
                                <option value="">Select Wildlife</option>
                                @foreach ($wildlives as $wildlifeId => $wildlifeValue)
                                    <option value="{{ $wildlifeId }}" @selected(in_array($wildlifeId, $wildlife_found))>
                                        {{ $wildlifeValue }}
                                    </option>
                                @endforeach
                            </select>
                            @error('wildlife_found')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Total Park Area -->
                        <div class="col-6">
                            <label class="form-label">Total Park Area <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('area') is-invalid @enderror"
                                oninput="filterAndFormatInputs(this,{allowAlpha:true,allowNumbers:true,allowedSpecialChars:`-,–/('')²`})"
                                wire:model="area" placeholder="Enter Total Park Area">
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Famous For -->
                        <div class="col-md-4">
                            <label for="famous_for" class="form-label">Famous For <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control text-capitalize  @error('famous_for') is-invalid @enderror"
                                oninput="filterAndFormatInputs(this,{allowAlpha:true,allowNumbers:true,allowedSpecialChars:`-,–/('')`})"
                                wire:model="famous_for" placeholder="Barasingha, Bengal Tigers ">
                            @error('famous_for')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="entry_gates" class="form-label">Entry Gates</label>
                                <input type="text"
                                    class="form-control text-capitalize @error('entry_gates') is-invalid @enderror"
                                    wire:model="entry_gates"
                                    oninput="filterAndFormatInputs(this,{allowAlpha:true,allowNumbers:true,allowedSpecialChars:`-,/–('')`})"
                                    placeholder="Enter Entry Gates">
                                @error('entry_gates')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Country -->
                        <div class="col-md-4">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('country_id') is-invalid @enderror"
                                wire:model.live="country_id" id="country_id" placeholder="Select Country">
                                <option value="">Select Country</option>
                                @foreach ($countries as $countryId => $countryValue)
                                    <option value="{{ $countryId }}" @selected($countryId == $country_id)>
                                        {{ $countryValue }}</option>
                                @endforeach
                            </select>
                            @error('country_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- State -->
                        <div class="col-md-4">
                            <label class="form-label">State <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('state_id') is-invalid @enderror"
                                wire:model.live="state_id" id="state_id" placeholder="Select State">
                                <option value="">Select State</option>
                                @foreach ($states as $stateId => $stateValue)
                                    <option value="{{ $stateId }}" @selected($stateId == $state_id)>
                                        {{ $stateValue }}</option>
                                @endforeach
                            </select>
                            @error('state_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="col-md-4">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('city_id') is-invalid @enderror"
                                wire:model="city_id" id="city_id" placeholder="Select City">
                                <option value="">Select City</option>
                                @foreach ($cities as $cityId => $cityValue)
                                    <option value="{{ $cityId }}" @selected($cityId == $city_id)>
                                        {{ $cityValue }}</option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="nearest_railway" class="form-label">Nearest Railway<sup
                                        class="text-danger">*</sup></label>
                                <input type="text"
                                    class="form-control text-capitalize @error('nearest_railway') is-invalid @enderror"
                                    oninput="filterAndFormatInputs(this,{allowAlpha:true,allowNumbers:true,allowedSpecialChars:`-,–/('')`})"
                                    wire:model="nearest_railway" placeholder="Enter Nearest Railway">
                                @error('nearest_railway')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="morning_time" class="form-label">Morning Time<sup
                                        class="text-danger">*</sup></label>
                                <input type="text"
                                    class="form-control @error('morning_time') is-invalid @enderror"
                                    oninput="filterAndFormatInputs(this,{allowNumbers:true,allowAlpha:true,allowedSpecialChars:`,–:'/-`})"
                                    wire:model="morning_time" placeholder="Enter Morning Time">
                                @error('morning_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="afternoon_time" class="form-label">Afternoon Time <sup
                                        class="text-danger">*</sup></label>
                                <input type="text"
                                    class="form-control @error('afternoon_time') is-invalid @enderror"
                                    oninput="filterAndFormatInputs(this,{allowNumbers:true,allowAlpha:true,allowedSpecialChars:`,–:''&/-`})"
                                    wire:model="afternoon_time" placeholder="Enter Afternoon Time">
                                @error('afternoon_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="banner_title" class="form-label">Banner Title</label>
                                <input type="text"
                                    class="form-control text-capitalize @error('banner_title') is-invalid @enderror"
                                    oninput="filterAndFormatInputs(this,{allowNumbers:true,allowAlpha:true,allowedSpecialChars:`,:|–&''()/-`})"
                                    wire:model="banner_title" placeholder="Home of Barasingha">
                                @error('banner_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Description <sup
                                        class="text-danger">*</sup></label> </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="exampleFormControlTextarea1"
                                    wire:model="description" rows="3"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label class="form-label">
                                        Upload Display Image <span class="text-danger">*</span>
                                    </label>

                                    <input type="file" wire:model="data_image"
                                        class="form-control @error('data_image') is-invalid @enderror"
                                        accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP">
                                    <small>Expected aspect ratio is 2:1 (e.g. 600x300 px).</small> <br>
                                    @error('data_image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        {{ $isEditing ? 'Current' : 'Preview' }}
                                    </label>

                                    <div class="border bg-light text-center p-2 position-relative"
                                        style="height: 200px;">

                                        @if ($data_image)
                                            <img src="{{ $data_image->temporaryUrl() }}"
                                                class="img-fluid h-100 object-fit-contain">
                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle"
                                                style="padding:0.2rem 0.4rem" wire:click="removeDisplayImage">
                                                ×
                                            </button>
                                        @elseif ($isEditing && !empty($previousImage))
                                            <img src="{{ asset($previousImage) }}"
                                                class="img-fluid h-100 object-fit-contain">
                                        @else
                                            <span
                                                class="text-muted d-flex align-items-center justify-content-center h-100">
                                                No Image Selected
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label class="form-label">
                                        Upload Banner Image <span class="text-danger">*</span>
                                    </label>

                                    <input type="file" wire:model="banner_image"
                                        class="form-control @error('banner_image') is-invalid @enderror"
                                        accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP">
                                    <small>Expected Image 1800x600 px.</small> <br>
                                    @error('banner_image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        {{ $isEditing ? 'Current' : 'Preview' }}
                                    </label>

                                    <div class="border bg-light text-center p-2 position-relative"
                                        style="height: 200px;">

                                        @if ($banner_image)
                                            <img src="{{ $banner_image->temporaryUrl() }}"
                                                class="img-fluid h-100 object-fit-contain">
                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle"
                                                style="padding:0.2rem 0.4rem" wire:click="removeBannerImage">
                                                ×
                                            </button>
                                        @elseif ($isEditing && !empty($previousBannerImage))
                                            <img src="{{ asset($previousBannerImage) }}"
                                                class="img-fluid h-100 object-fit-contain">
                                        @else
                                            <span
                                                class="text-muted d-flex align-items-center justify-content-center h-100">
                                                No Image Selected
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            {{ $isEditing ? 'Update' : 'Save' }}
                            <i class="spinner-border spinner-border-sm" wire:loading></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
