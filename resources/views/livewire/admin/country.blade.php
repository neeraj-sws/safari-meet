<div class="container" id="amanity">

    @include('livewire.components.breadcrumb', [
        'menu' => $pageTitle,
        'submenus' => [$pageTitle],
    ])
    <div class="row g-4">
        <!-- Form Card -->
        <div class="col-md-5">
            <div class="card">

                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                        <div class="mb-3 form-group" x-data="{ country_name: @entangle('country_name') }">
                            <label for="title" class="form-label">Country Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('country_name') is-invalid @enderror"
                                x-model="country_name"
                                oninput="filterAndFormatInputs(this,{ allowAlpha: true,capitalizeWords: true })"
                                x-on:input="country_name = country_name.replace(/\b\w/g, l => l.toUpperCase())"
                                placeholder="Enter Country Name Here...">
                            @error('country_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3" x-data>
                            <label for="country_code" class="form-label">
                                Country Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('country_code') is-invalid @enderror"
                                wire:model="country_code" placeholder="Enter Country Code"
                                oninput="filterAndFormatInputs(this,{ allowAlpha: true,capitalizeWords: true })"
                                x-on:input="$event.target.value = $event.target.value.toUpperCase()">
                            @error('country_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone_code" class="form-label">Phone Code <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone_code') is-invalid @enderror"
                                oninput="filterAndFormatInputs(this,{allowNumbers:true })" wire:model="phone_code"
                                placeholder="Enter Country Phone Code">
                            @error('phone_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 form-group">
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
        <div class="col-md-7">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5" placeholder="Search..."
                            wire:model.live.debounce.300ms="search"> <span
                            class="position-absolute top-50 product-show translate-middle-y">
                            <i class="bx bx-search"></i></span>
                    </div>
                </div>




                <div class="card-body">
                    <div class="table-responsive ecs-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">#</th>
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
                                                    {{ $item->sortname ?? '-' }} -
                                                    {{ '(+' . $item->phonecode . ')' ?? '-' }} - {{ $item->name }}
                                                </span>
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
