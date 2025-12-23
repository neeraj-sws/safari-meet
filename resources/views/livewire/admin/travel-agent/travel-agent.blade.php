<div class="container" id="amanity">

        @include('livewire.components.breadcrumb', [
            'menu' => 'Travel Agents',
            'submenus' => [
                'Travel Agents',
            ],
        ])
    <div class="row g-4">
        <!-- Form Card -->
        <div class="col-md-5">
            <div class="card">

                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                        <div class="mb-3" x-data="{ name: @entangle('name') }">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                oninput="filterAndFormatInputs(this, {allowAlpha: true})"
                                x-on:input="name = name.replace(/\b\w/g, l => l.toUpperCase())" x-model="name"
                                placeholder="Enter Name Here...">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                wire:model="email" placeholder="Enter Email Here...">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                wire:model="phone_number" placeholder="Enter Phone Number Here...">
                            @error('phone_number')
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Status</th>
                                    <th style="width: 80px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $index => $item)
                                    <tr wire:key="{{ $item->id }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{ $item->email }}
                                        </td>
                                        <td>
                                            {{ $item->phone_number }}
                                        </td>

                                        <td>
                                            @if ($item->status == 0)
                                                <span class="badge bg-warning text-dark">Pending</span>
                                                <a class="btn btn-sm btn-outline-success"
                                                    wire:click="publishedStatus({{ $item->id }},1)">Active</a>
                                                <a class="btn btn-sm btn-outline-danger"
                                                    wire:click="publishedStatus({{ $item->id }},2)">Inactive</a>
                                            @elseif($item->status == 1)
                                                <span class="badge bg-success text-dark">Active</span>
                                                <a class="btn btn-sm btn-outline-danger "
                                                    wire:click="publishedStatus({{ $item->id }},2)">Inactive</a>
                                            @elseif($item->status == 2)
                                                <span class="badge bg-danger text-dark">Inactive</span>
                                                <a class="btn btn-sm btn-outline-success "
                                                    wire:click="publishedStatus({{ $item->id }},1)">Active</a>
                                            @endif

                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" wire:click="edit({{ $item->id }})"
                                                title="Edit">
                                                <i class="bx bx-edit text-dark fs-5"></i>
                                            </a>
                                            <a href="{{ route('admin.travel-agent.details', $item->id) }}"
                                                title="Details">
                                                <i class="bx bx-detail fs-5 text-dark"></i>
                                            </a>
                                            <a href="javascript:void(0)"
                                                wire:click="confirmDelete({{ $item->id }})" title="Delete">
                                                <i class="bx bx-trash text-danger fs-5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <x-pagination :paginator="$items" />
                </div>
                @if ($ShowRemark)
                    <div class="modal fade show" id="exampleModal" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog" style="display: block;"
                        data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form wire:submit.prevent="submitRemark">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Provide Remark</h5>
                                    </div>
                                    <div class="modal-body">
                                        <textarea wire:model.defer="remark" class="form-control @error('remark') is-invalid @enderror" rows="5"></textarea>
                                        @error('remark')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="submitRemark">Submit Remark</span>
                                            <span wire:loading wire:target="submitRemark">
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Submitting...
                                            </span>
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
