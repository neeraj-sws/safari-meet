<!-- Details Tab -->
<div class="row g-3">
    <!-- Visit Purpose -->
    <div class="col-6">
        <label for="visit_purpose_id" class="form-label text-blue">Select Visit Purpose <span class="text-danger">*</span></label>
        <select id="visit_purpose_id" wire:model="visit_purpose_id"
            class="form-select @error('visit_purpose_id') is-invalid @enderror">
            <option value="">Select a purpose</option>
            @foreach ($visitPurposes as $id => $label)
                <option value="{{ $id }}" @selected($visit_purpose_id == $id)>{{ $label }}</option>
            @endforeach
        </select>
        @error('visit_purpose_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Stay Category -->
    <div class="col-6">
        <label for="stay_category_id" class="form-label text-blue">Select a Category</label>
        <select id="stay_category_id" wire:model="stay_category_id"
            class="form-select @error('stay_category_id') is-invalid @enderror">
            <option value="">Select a category</option>
            @foreach ($stayCategories as $id => $label)
                <option value="{{ $id }}" @selected($stay_category_id == $id)>{{ $label }}</option>
            @endforeach
        </select>
        @error('stay_category_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Price Range -->
    <div class="col-12">
        <label class="form-label fw-semibold text-dark-emphasis">
            Price Per Person (INR) <span class="text-danger">*</span>
        </label>
        <div class="d-flex align-items-center gap-2">
            <input type="number" placeholder="Min" min="0"
                class="form-control @error('price_min') is-invalid @enderror"
                oninput="filterAndFormatInputs(this,{allowNumbers:true});"
                wire:model.live="price_min">
            <span>-</span>
            <input type="number" placeholder="Max" min="0"
                class="form-control @error('price_max') is-invalid @enderror"
                oninput="filterAndFormatInputs(this,{allowNumbers:true});"
                wire:model.live="price_max">
        </div>
        @error('price_min')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        @error('price_max')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        @if ($showError)
            <div><small class="text-danger">Max price must be greater than min price or less than 8%</small></div>
        @endif
    </div>

    <!-- Total Seats -->
    <div class="col-6">
        <label for="total_seats" class="form-label text-blue">Total Seats <span class="text-danger">*</span></label>
        <input type="number" id="total_seats" min="1"
            class="form-control rounded-3 @error('total_seats') is-invalid @enderror"
            wire:model.live="total_seats">
        @error('total_seats')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Share Seats -->
    <div class="col-6">
        <label for="share_seats" class="form-label text-blue">Share Seats <span class="text-danger">*</span></label>
        <select id="share_seats" wire:model="share_seats"
            class="form-select select2 @error('share_seats') is-invalid @enderror">
            <option value="">Select Share Seats</option>
            @for ($i = 1; $i < $options; $i++)
                <option value="{{ $i }}" @selected($share_seats == $i)>{{ $i }}</option>
            @endfor
        </select>
        @error('share_seats')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Actions -->
    <div class="d-flex justify-content-end gap-2">
        @php
            $routeName = $type == 'edit' ? 'edit.saharedshafari' : 'createsaharedshafari';
        @endphp
        <a href="{{ route($routeName, ['slug' => $sharedSafari->slug, 'type' => 'basic-info']) }}"
            class="btn btn-sm border-bg blue-border-hover rounded-1 px-4 text-blue">
            Back
        </a>
        <button type="submit" class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1 px-4">
            Next
        </button>
    </div>
</div>
