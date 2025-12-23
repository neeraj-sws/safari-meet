<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="row ">
                    <div class="col-md-6">
                        <div class="border border-1 p-4 rounded">
                            <div class="mb-3">
                                <label class="form-label">
                                    Upload Safari and Travel Info Image <span class="text-danger">*</span>
                                </label>

                                <input type="file" wire:model="travel_info_image"
                                    accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                    class="form-control @error('travel_info_image') is-invalid @enderror">
                                    <small>Expected Image 300x180 px.</small> <br>
                                @error('travel_info_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <label class="form-label">
                                {{ $isEditing ? 'Current' : 'Preview' }}
                            </label>

                            <div class="border bg-light text-center p-2 position-relative"
                                style="height: 143px; overflow: hidden;">

                                @if ($travel_info_image)
                                    <div wire:loading.delay wire:target="travel_info_image"
                                        class="d-flex align-items-center justify-content-center h-100 position-absolute w-100 bg-white z-3"
                                        style="top: 0; left: 0;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Uploading...</span>
                                        </div>
                                    </div>
                                @endif

                                <div wire:loading.remove wire:target="travel_info_image"
                                    class="h-100 position-relative">
                                    @if ($travel_info_image)
                                        <img src="{{ $travel_info_image->temporaryUrl() }}"
                                            class="img-fluid h-100 object-fit-contain">
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle z-3"
                                            style="padding:0.2rem 0.4rem" wire:click="removeTravelImage">
                                            ×
                                        </button>
                                    @elseif ($isEditing && !empty($travelInfopreviousImage))
                                        <img src="{{ asset($travelInfopreviousImage) }}"
                                            class="img-fluid h-100 object-fit-contain">
                                    @else
                                        <span class="text-muted d-flex align-items-center justify-content-center h-100">
                                            No Image Selected
                                        </span>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-lg-12">
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
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="core_zone" class="form-label">Core Zones<sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" class="form-control @error('core_zone') is-invalid @enderror"
                                     oninput="filterAndFormatInput(this, false, `,`, true)"
                                        wire:model="core_zone" placeholder="Enter Mukki, Khatia, Sarhi">
                                    @error('core_zone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="entry_gates" class="form-label">Entry Gates<sup
                                            class="text-danger">*</sup></label>
                                    <input type="text"
                                        class="form-control @error('entry_gates') is-invalid @enderror"
                                        oninput="filterAndFormatInput(this, false, `,`, true)"
                                        wire:model="entry_gates" placeholder="Enter Entry Gates">
                                    @error('entry_gates')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="nearest_railway" class="form-label">Nearest Railway<sup
                                            class="text-danger">*</sup></label>
                                    <input type="text"
                                        class="form-control @error('nearest_railway') is-invalid @enderror"
                                        oninput="filterAndFormatInput(this, false, `,`, true)"
                                        wire:model="nearest_railway" placeholder="Enter Nearest Railway">
                                    @error('nearest_railway')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                </div>
            </form>
        </div>
    </div>
</div>
