<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="bs-stepper-pan">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-12 mt-3 ">
                                <div class="border border-1 p-4 rounded">
                                    <h3>Zoological Identity</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative">
                                                <label for="category" class="form-label">Category
                                                    <span class="text-danger">*</span></label>
                                                <select
                                                    class="form-control select2 @error('overview_category') is-invalid @enderror "
                                                    wire:model="overview_category" id="overview_category"
                                                    placeholder="Select Category">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $categoyId => $category)
                                                        <option value="{{ $categoyId }}"
                                                            @selected($categoyId == $overview_category)>
                                                            {{ $category }} </option>
                                                    @endforeach
                                                </select>
                                                @error('overview_category')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative">
                                                <label for="category" class="form-label">Family <span
                                                        class="text-danger">*</span></label>
                                                <select
                                                    class="form-control select2 @error('overview_family') is-invalid @enderror "
                                                    id="overview_family" wire:model="overview_family"
                                                    placeholder="Select Category">
                                                    <option value="">Select Family</option>
                                                    @foreach ($species_family as $familyId => $family)
                                                        <option value="{{ $familyId }}"
                                                            @selected($familyId == $overview_family)>
                                                            {{ $family }} </option>
                                                    @endforeach
                                                </select>
                                                @error('overview_family')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <div class="position-relative">
                                                <label for="category" class="form-label">Genus Species
                                                    <span class="text-danger">*</span></label>
                                                <select
                                                    class="form-control select2 @error('overview_genus') is-invalid @enderror "
                                                    id="overview_genus" wire:model="overview_genus"
                                                    placeholder="Select Genus">
                                                    <option value="">Select Genus</option>
                                                    @foreach ($species_genus as $genusId => $genus)
                                                        <option value="{{ $genusId }}"
                                                            @selected($genusId == $overview_genus)>
                                                            {{ $genus }} </option>
                                                    @endforeach
                                                </select>
                                                @error('overview_genus')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <div class="position-relative">
                                                <label for="life_span" class="form-label">Life Span
                                                    <span class="text-danger  ">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('life_span') is-invalid @enderror"
                                                    oninput="filterAndFormatInputs(this,{allowNumbers:true,allowAlpha:true,allowedSpecialChars:`,.()''–/-`})"
                                                    wire:model="life_span" placeholder="Enter Life Span">
                                                @error('life_span')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <div class="position-relative">
                                                <label for="category" class="form-label">Speed <span
                                                        class="text-danger  ">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('speed') is-invalid @enderror"
                                                    oninput="filterAndFormatInputs(this,{allowNumbers:true,allowAlpha:true,allowedSpecialChars:`,.()''–/-`})"
                                                    wire:model="speed" placeholder="Enter Speed">
                                                @error('speed')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <div class="position-relative">
                                                <label for="category" class="form-label">Mass <span
                                                        class="text-danger  ">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('mass') is-invalid @enderror"
                                                    oninput="filterAndFormatInputs(this,{allowNumbers:true,allowAlpha:true,allowedSpecialChars:`,.()''–/-`})"
                                                    wire:model="mass" placeholder="Enter Mass">
                                                @error('mass')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <div class="position-relative">
                                                <label for="category" class="form-label">Height <span
                                                        class="text-danger ">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('height') is-invalid @enderror"
                                                    oninput="filterAndFormatInputs(this,{allowNumbers:true,allowAlpha:true,allowedSpecialChars:`,.()''/–-`})"
                                                    wire:model="height" placeholder="Enter height ">
                                                @error('height')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <div class="position-relative">
                                                <label for="category" class="form-label">Length <span
                                                        class="text-danger ">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('length') is-invalid @enderror"
                                                    oninput="filterAndFormatInputs(this,{allowNumbers:true,allowAlpha:true,allowedSpecialChars:`,.()''–/-`})"
                                                    wire:model="length" placeholder="Enter length ">
                                                @error('length')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end mt-4">
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
                </div>
            </form>
        </div>
    </div>
</div>
