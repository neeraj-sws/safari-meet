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
                        <div class="mb-3">
                            <label for="title" class="form-label">Coupon Code <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('coupon_code') is-invalid @enderror"
                                wire:model="coupon_code" placeholder="Enter Coupon Code Here...">
                            @error('coupon_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Discounted Amount<span class="text-danger">
                                    *</span></label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                wire:model="amount" placeholder="Enter Discounted Amount Here...">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="md-3">
                            <label for="start_date" class="form-label text-blue">Start Date <span
                                    class="text-danger">*</span></label>

                            <input type="text"
                                class="form-control datepicker @error('start_date') is-invalid @enderror"
                                oninput="filterAndFormatInputs(this,{allowNumbers:true,allowedSpecialChars:('-')}); "
                                data-role="start" data-group="booking1" wire:model="start_date">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="night" class="form-label text-blue">End Date <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control datepicker @error('start_date') is-invalid @enderror"
                                oninput="filterAndFormatInputs(this,{allowNumbers:true,allowedSpecialChars:('-')}); "
                                data-role="end" data-group="booking1" wire:model="end_date">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
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
                                    <th>Coupon Code</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
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
                                                    {{ $item->coupon_code }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>{{ $item->start_date }}</td>
                                        <td> {{ $item->end_date }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="{{ $item->id }}"
                                                    type="checkbox" role="switch"
                                                    wire:change="toggleStatus({{ $item->id }})"
                                                    @checked($item->status)>
                                            </div>
                                        </td>

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
                                        <td colspan="3" class="text-center">No coupons found.</td>
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
