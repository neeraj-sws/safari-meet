<div class="container" id="amanity">

        @include('livewire.components.breadcrumb', [
            'menu' => 'Users',
            'submenus' => [
                'Users',
            ],
        ])


    <div class="row g-4">
        <!-- Table Card -->
        <div class="col-md-12">
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
                                <tr class="text-center">
                                     <th style="width: 50px;">#</th>
                                    <th style="width: 200px;">Name</th>
                                    <th style="width: 250px;">Email</th>
                                    <th style="width: 180px;">Status</th>
                                    <th style="width: 120px;">Verify</th>
                                    <th style="width: 90px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
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
                                        <td>
                                            @if($item->is_profile_complete)
                                                <span class="badge bg-success text-dark">Verify</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Un-verify</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.user.details', $item->id) }}"
                                                title="Details">
                                                <i class="bx bx-detail fs-5 text-dark"></i>
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
