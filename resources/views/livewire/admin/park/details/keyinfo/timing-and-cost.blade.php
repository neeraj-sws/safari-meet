<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3">
                    <div class="row ">
                        <div class="col-md-6 p-4 ">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="morning_time" class="form-label">Morning Time<sup
                                                class="text-danger">*</sup></label>
                                        <input type="text"
                                            class="form-control @error('morning_time') is-invalid @enderror"
                                            oninput="filterAndFormatInput(this, true, `,:|-`, false)"
                                            wire:model="morning_time" placeholder="Enter Morning Time">
                                        @error('morning_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="afternoon_time" class="form-label">Afternoon Time<sup
                                                class="text-danger">*</sup></label>
                                        <input type="text"
                                            class="form-control @error('afternoon_time') is-invalid @enderror"
                                            oninput="filterAndFormatInput(this, true, `,:|-`, false)"
                                            wire:model="afternoon_time" placeholder="Enter Afternoon Time">
                                        @error('afternoon_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="core_zone_price" class="form-label">Core Zones Price<sup
                                                class="text-danger">*</sup></label>
                                        <input type="text"
                                            class="form-control @error('core_zone_price') is-invalid @enderror"
                                            oninput="filterAndFormatInput(this, true, `,-$₹`, true)"
                                            wire:model="core_zone_price" placeholder="Enter Mukki, Khatia, Sarhi">
                                        @error('core_zone_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="buffer_zone_price" class="form-label">Buffer Zones Price<sup
                                                class="text-danger">*</sup></label>
                                        <input type="text"
                                            class="form-control @error('buffer_zone_price') is-invalid @enderror"
                                            oninput="filterAndFormatInput(this, true, `,-$₹`, true)"
                                            wire:model="buffer_zone_price"
                                            placeholder="Enter Kanha, Mukki, Kisli, Sarhi">
                                        @error('buffer_zone_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border border-1 p-4 rounded">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Upload Timings & Cost Image <span class="text-danger">*</span>
                                    </label>

                                    <input type="file" wire:model="timing_cost_image"
                                        accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                        class="form-control @error('travel_info_image') is-invalid @enderror">
                                    <small>Expected Image 300x180 px.</small> <br>
                                    @error('timing_cost_image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <label class="form-label">
                                    {{ $isEditing ? 'Current' : 'Preview' }}
                                </label>

                                <div class="border bg-light text-center p-2 position-relative"
                                    style="height: 143px; overflow: hidden;">

                                    @if ($timing_cost_image)
                                        <div wire:loading.delay wire:target="timing_cost_image"
                                            class="d-flex align-items-center justify-content-center h-100 position-absolute w-100 bg-white z-3"
                                            style="top: 0; left: 0;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Uploading...</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div wire:loading.remove wire:target="timing_cost_image"
                                        class="h-100 position-relative">
                                        @if ($timing_cost_image)
                                            <img src="{{ $timing_cost_image->temporaryUrl() }}"
                                                class="img-fluid h-100 object-fit-contain">
                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle z-3"
                                                style="padding:0.2rem 0.4rem" wire:click="removeTimingImage">
                                                ×
                                            </button>
                                        @elseif ($isEditing && !empty($timingCostPreviousImage))
                                            <img src="{{ asset($timingCostPreviousImage) }}"
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
                        <div class="col-12 text-end">
                            <button type="submit" wire:target="store" wire:loading.attr="disabled"
                                class="btn btn-primary" id="submitOverview">
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
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
