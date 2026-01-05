<!-- Basic Info Tab -->
<div class="row g-3">
    @if ($isUpdate)
        <div class="col-md-12">
            <label class="form-label">Status</label>
            <select wire:model="status" wire:model.live="status" class="form-select">
                <option value="">-- Select status --</option>
                <option value="active" @selected($status == 'active')>Active</option>
                <option value="inactive" @selected($status == 'inactive')>Inactive</option>
                <option value="seat_full" @selected($status == 'seat_full')>Seat Full</option>
            </select>
        </div>
    @endif

    <!-- Safari Title -->
    <div class="col-6">
        <label for="title" class="form-label text-blue">Safari Title <span class="text-danger">*</span></label>
        <input type="text" id="title"
            class="form-control rounded-3 @error('title') is-invalid @enderror"
            oninput="filterAndFormatInputs(this,{capitalizeWords:true,allowAlpha:true,allowNumbers:true});"
            wire:model="title">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Safari Park -->
    <div class="col-6">
        <label for="safari_park" class="form-label text-blue">Select a Safari Park <span class="text-danger">*</span></label>
        <select id="safari_park" class="form-select select2 @error('safari_park') is-invalid @enderror"
            wire:model="safari_park">
            <option value="">Select Park</option>
            @foreach ($parks as $id => $name)
                <option value="{{ $id }}" @selected($safari_park == $id)>{{ ucwords($name) }}</option>
            @endforeach
        </select>
        @error('safari_park')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Safari Type -->
    <div class="col-md-6">
        <label class="form-label">Safari Type <span class="text-danger">*</span></label>
        <select wire:model="safari_type" id="safari_type" multiple class="form-select select2">
            <option value="">-- Select Type --</option>
            @foreach ($safariTypes as $type)
                <option value="{{ $type['id'] }}" @selected(in_array($type['id'], $safari_type))>
                    {{ $type['name'] }}
                </option>
            @endforeach
        </select>
        @error('safari_type')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Number of Safaris -->
    <div class="col-md-6">
        <label for="safari_count" class="form-label text-blue">Number of Safaris <span class="text-danger">*</span></label>
        <input type="number" id="safari_count" min="1"
            class="form-control rounded-3 @error('safari_count') is-invalid @enderror"
            oninput="filterAndFormatInputs(this,{allowNumbers:true});"
            wire:model="safari_count">
        @error('safari_count')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Start Date -->
    <div class="col-md-6">
        <label for="day" class="form-label text-blue">Start Date <span class="text-danger">*</span></label>
        @php $start = \App\Helpers\SettingHelper::get('safari_date_after', '0') @endphp
        <input type="text" class="form-control datepicker @error('day') is-invalid @enderror"
            oninput="filterAndFormatInputs(this,{allowNumbers:true,allowedSpecialChars:('-')});"
            data-role="start" data-start="{{ $start }}" data-group="booking1"
            wire:model="day">
        @error('day')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- End Date -->
    <div class="col-md-6">
        <label for="night" class="form-label text-blue">End Date <span class="text-danger">*</span></label>
        <input type="text" class="form-control datepicker @error('night') is-invalid @enderror"
            oninput="filterAndFormatInputs(this,{allowNumbers:true,allowedSpecialChars:('-')});"
            data-role="end" data-group="booking1"
            wire:model="night">
        @error('night')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Actions -->
    <div class="d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1 px-4">
            Next
        </button>
    </div>
</div>
