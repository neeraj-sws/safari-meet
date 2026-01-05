<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3">
                    <div class="row ">
                        <div class="">
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="Established" class="form-label">Park Established <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control datepicker @error('day') is-invalid @enderror"
                                        data-nostart="null" wire:model="established">
                                </div>
                                @error('established')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <!-- Total Park Area -->
                                <div class="col-6 mb-2">
                                    <label class="form-label">Total Park Area <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('area') is-invalid @enderror"
                                        oninput="filterAndFormatInput(this, true, `,:'/-`, false)" wire:model="area"
                                        placeholder="Enter Total Park Area">
                                    @error('area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Famous For -->
                                <div class="col-md-6 mb-2">
                                    <label for="famous_for" class="form-label">Famous For <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control  @error('famous_for') is-invalid @enderror"
                                        oninput="filterAndFormatInput(this, true, `,`, true)" wire:model="famous_for"
                                        placeholder="Barasingha, Bengal Tigers ">
                                    @error('famous_for')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Best Time To Visit -->
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Best Time To Visit <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2 @error('best_time_visit') is-invalid @enderror"
                                        wire:model="best_time_visit" multiple id="best_time_visit"
                                        placeholder="Select Weather">
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
                            </div>
                            <div class="row">
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
                            </div>
                        </div>
                        <div class="row align-items-center ">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Upload Park Overview Image <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" wire:model="park_overview_image"
                                        accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                        class="form-control @error('park_overview_image') is-invalid @enderror">
                                    <small>Expected Image 300x180 px.</small> <br>
                                    @error('park_overview_image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    {{ $isEditing ? 'Current' : 'Preview' }}
                                </label>
                                <div class="border bg-light text-center p-2 position-relative"
                                    style="height: 143px; overflow: hidden;">

                                    @if ($park_overview_image)
                                        <div wire:loading.delay wire:target="park_overview_image"
                                            class="d-flex align-items-center justify-content-center h-100 position-absolute w-100 bg-white z-3"
                                            style="top: 0; left: 0;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Uploading...</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div wire:loading.remove wire:target="park_overview_image"
                                        class="h-100 position-relative">
                                        @if ($park_overview_image)
                                            <img src="{{ $park_overview_image->temporaryUrl() }}"
                                                class="img-fluid h-100 object-fit-contain">
                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle z-3"
                                                style="padding:0.2rem 0.4rem" wire:click="removeOverViewImage">
                                                ×
                                            </button>
                                        @elseif ($isEditing && !empty($overviewpreviousImage))
                                            <img src="{{ asset($overviewpreviousImage) }}"
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
                </div>
                <div class="col-12 text-end mt-4">
                    <button type="submit" wire:target="store" wire:loading.attr="disabled" class="btn btn-primary"
                        id="submitOverview">
                        <span wire:loading.remove wire:target="store">
                            Submit
                        </span>
                        <span wire:loading wire:target="store">
                            <span class="spinner-border spinner-border-sm me-1" role="status"
                                aria-hidden="true"></span>
                            Submitting...
                        </span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
