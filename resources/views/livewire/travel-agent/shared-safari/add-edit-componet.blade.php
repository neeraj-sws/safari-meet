<div class="container">

    <div class="page-breadcrumb flex-wrap d-flex align-items-center mb-3">
        <div>
            <h6 class="breadcrumb-title pe-2 fs-24  border-0 text-black fw-600">{{ $pageTitle }} </h6>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                </ol>
            </nav>

        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('agent.shared-safari.safari') }}" class="btn btn-primary ms-auto" wire:navigate>
                    <i class="lni lni-arrow-left"></i></a>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="store">
        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                        <div class="col-6" x-data="{ title: @entangle('title') }"` >
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text"  x-model="title" x-on:input="title = title.replace(/\b\w/g, l => l.toUpperCase())"
                        oninput="filterAndFormatInputs(this, {allowAlpha: true, allowedSpecialChars: '-()./,:\'?\''})"
                            class="form-control @error('title') is-invalid @enderror " placeholder="Enter title">
                        @error('title')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">

                        <label for="safari_park" class="form-label text-blue">Select a Safari Park
                            <span class="text-danger">*</span></label>
                        <select id="safari_park" class="form-select select2 @error('safari_park') is-invalid @enderror"
                            wire:model="safari_park">
                            <option value="">Select Park</option>
                            @foreach ($safariParks as $id => $name)
                                <option value="{{ $id }}" @selected($safari_park == $id)>
                                    {{ ucwords($name) }}</option>
                            @endforeach
                        </select>
                        @error('safari_park')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                        <div class="col-md-6  ">
                        <label for="day" class="form-label text-blue">Start Date <span
                                class="text-danger">*</span></label>
                        @php $start =  \App\Helpers\SettingHelper::get('safari_date_after', '0') @endphp
                        <input type="text" class="form-control datepicker @error('day') is-invalid @enderror"
                            data-role="start" data-start="{{ $start }}" data-group="booking1" wire:model="day">

                        @error('day')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  ">
                        <label for="night" class="form-label text-blue">End Date <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control datepicker @error('night') is-invalid @enderror"
                            data-role="end" data-group="booking1" wire:model="night">

                        @error('night')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  ">
                        <label class="form-label">Safari Type <span class="text-danger">*</span></label>
                        <select wire:model="safari_type" id="safari_type" name="safari_type" multiple
                            class="form-select  @error('safari_type') is-invalid @enderror select2"
                            placeholder="Select Park">
                            <option value="">-- Select Park --</option>
                            @foreach ($safariTypes as $id => $type)
                                <option value="{{ $type['id'] }}" @selected(in_array($type['id'], $safari_type))>
                                    {{ $type['name'] }}</option>
                            @endforeach
                        </select>
                        @error('safari_type')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6  ">
                        <label for="safari_count" class="form-label text-blue">Number of Safaris
                            <span class="text-danger">*</span></label>
                        <input type="text" id="safari_count" min="1"
                            class="form-control rounded-3 @error('safari_count') is-invalid @enderror"
                            oninput="filterAndFormatInputs(this,{allowNumbers:true})"
                            wire:model="safari_count">
                        @error('safari_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Purpose of Visit <span class="text-danger">*</span></label>
                        <select wire:model="visit_purpose_id"
                            class="form-select  @error('stay_category_id') is-invalid @enderror select2"
                            id="visit_purpose_id" placeholder="Select Visit Purpose">
                            <option value="">Select a purpose</option>
                            @foreach ($visitPurposes as $id => $label)
                                <option value="{{ $id }}" @selected($visit_purpose_id == $id)>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('visit_purpose_id')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Stay Category <span class="text-danger">*</span></label>
                        <select wire:model="stay_category_id"
                            class="form-select  @error('stay_category_id') is-invalid @enderror select2"
                            id="stay_category_id" placeholder="Select Staty Category">
                            <option value="">Select a category</option>
                            @foreach ($stayCategories as $id => $label)
                                <option value="{{ $id }}" @selected($stay_category_id == $id)>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('stay_category_id')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="min_price_pp" class="form-label">Price Per Person(INR) <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="min_price_pp" id="min_price_pp" wire:model="min_price_pp"
                           oninput="filterAndFormatInputs(this,{allowNumbers:true}); minPricePPChange(this);"
                                class="form-control   @error('min_price_pp') is-invalid @enderror " placeholder="MIN">
                            <span class="input-group-text">-</span>
                            <input type="number" name="max_price_pp" id="max_price_pp"
                                wire:model.live="max_price_pp" min="1" step="1"
                                class="form-control  @error('max_price_pp') is-invalid @enderror  " placeholder="MAX">
                        </div>
                        @error('min_price_pp')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        @error('max_price_pp')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        @if ($showError)
                            <div><small class="text-danger">Max price must be greater than min
                                    price or less then 8%</small></div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Total Seats <span class="text-danger">*</span></label>
                        <input type="text" name="total_seats" id="total_seats" wire:model.live="total_seats"
                            oninput="totalSeatsChange(this); filterAndFormatInputs(this,{allowNumbers:true}); " min="1" step="1"
                            class="form-control  @error('total_seats') is-invalid @enderror  "
                            placeholder="Total Seats">
                        @error('total_seats')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Share Seats <span class="text-danger">*</span></label>
                        <select name="share_seats" id="share_seats"
                            class="form-select select2  @error('share_seats') is-invalid @enderror "
                            wire:model="share_seats" placeholder="Select Share Seats">
                            <option value="">Select</option>
                            @for ($i = 1; $i < $total_seats; $i++)
                                <option value="{{ $i }}" @selected($i == $share_seats)>{{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('share_seats')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Upload Display Image <span class="text-danger">*</span>
                        </label>

                        <input type="file" wire:model.live="display_image" accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                            class="form-control @error('display_image') is-invalid @enderror">

                        @error('display_image')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            {{ $isEditing ? 'Current' : 'Preview' }}
                        </label>

                        <div class="border bg-light text-center p-2 position-relative" style="height: 200px;">

                            @if ($display_image)
                                <img src="{{ $display_image->temporaryUrl() }}"
                                    class="img-fluid h-100 object-fit-contain">
                                <button type="button"
                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle"
                                    style="padding:0.2rem 0.4rem" wire:click="removeDisplayImage">
                                    ×
                                </button>
                            @elseif ($isEditing && !empty($previousImage))
                                <img src="{{ asset($previousImage) }}" class="img-fluid h-100 object-fit-contain">
                            @else
                                <span class="text-muted d-flex align-items-center justify-content-center h-100">
                                    No Image Selected
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="modal-footer text-end">
                    <button type="submit" class="btn btn-success">
                        {{ $isEditing ? 'Update' : 'Save' }}
                        <i class="spinner-border spinner-border-sm" wire:loading></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')
    <script>
        window.safariNumber = function(e) {
            $('#safariNumber').text($(e).val());
        }
        window.minPricePPChange = function(e) {
            const minPricePPprice = String($(e).val());
            const maxEl = document.getElementById('max_price_pp');
            if (maxEl) {
                maxEl.setAttribute('min', minPricePPprice);
                maxEl.value = minPricePPprice;
                maxEl.dispatchEvent(new Event('input', { bubbles: true }));
            } else {
                $('#max_price_pp').attr('min', minPricePPprice).val(minPricePPprice).trigger('input');
            }
        }
        window.totalSeatsChange = function(e) {
            const totalSeatsCount = $(e).val();
            let arrshareSeatsOption = '<option value="">Select</option>';
            for (let i = 1; i < totalSeatsCount; i++) {
                arrshareSeatsOption += `<option value="${i}">${i}</option>`;
            }
            $('#share_seats').html(arrshareSeatsOption);
        }
    </script>
@endpush
