<div class="container" id="amanity">

    @include('livewire.components.breadcrumb', [
        'menu' => $pageTitle,
        'submenus' => [$pageTitle],
    ])

    <div class="row g-4">
        <!-- Form Card -->
        <div class="col-md-4">
            <div class="card">

                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                        <div class="mb-3" x-data="{ state_name: @entangle('state_name') }">
                            <label for="title" class="form-label">State Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('state_name') is-invalid @enderror"
                                x-model="state_name"
                                oninput="filterAndFormatInputs(this,{ allowAlpha: true,capitalizeWords: true })"
                                x-on:input="state_name = state_name.replace(/\b\w/g, l => l.toUpperCase())"
                                placeholder="Enter State Name Here...">
                            @error('state_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('name') is-invalid @enderror" id="country"
                                wire:model="country" placeholder="Select Country">
                                <option value="">Select Country</option>
                                @foreach ($countries as $countryId => $countryValue)
                                    <option value="{{ $countryId }}" @selected($countryId == $country)>{{ $countryValue }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-sm btn-primary px-5" wire:loading.attr="disabled">
                                {{ $isEditing ? 'Update' : 'Save' }}
                                <i class="spinner-border spinner-border-sm" wire:loading.delay
                                    wire:target="{{ $isEditing ? 'update' : 'store' }}"></i>
                            </button>
                            <button type="button" wire:click="resetForm"
                                class="btn btn-sm btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <!-- Country Dropdown Filter -->
                    <div class="d-flex align-items-center">
                        <select class="form-select" style="min-width: 180px;"
                            wire:model.live.debounce.300ms="filter_country">
                            <option value="">All Countries</option>
                            @foreach ($countries as $countryId => $countryValue)
                                <option value="{{ $countryId }}">{{ $countryValue }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search Box -->
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5" placeholder="Search..."
                            wire:model.live.debounce.300ms="search">
                        <span class="position-absolute top-50 translate-middle-y start-0 ps-3 text-muted">
                            <i class="bx bx-search"></i>
                        </span>
                    </div>
                </div>




                <div class="card-body">
                    <div class="table-responsive ecs-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th style="width: 80px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $index => $item)
                                    <tr wire:key="{{ $item->id }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="d-flex align-items-center gap-2">
                                                    {{ $item->name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>{{ $item->country?->name ?? '-' }}</td>

                                        <td class="text-center">
                                            <a href="javascript:void(0)" wire:click="edit({{ $item->id }})"
                                                title="Edit">
                                                <i class="bx bx-edit text-dark fs-5"></i>
                                            </a>
                                            <a href="javascript:void(0)"
                                                wire:click="confirmDelete({{ $item->id }})" title="Delete">
                                                <i class="bx bx-trash text-danger fs-5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No amenities found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
