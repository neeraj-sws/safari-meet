<div class="container">
    @include('livewire.components.breadcrumb', [
        'menu' => $pageTitle,
        'submenus' => [$pageTitle],
    ])
    <div class="card">

        <div class="card-body">
            <div>
                <input type="text" class="form-control ms-auto mb-3" placeholder="Search"
                    wire:model.live.debounce.300ms="search" style="max-width:200px;">
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faqCategories as $index => $faqCategory)
                            <tr wire:key="{{ $faqCategory->id }}">
                                <td>{{ $faqCategories->total() - ($faqCategories->firstItem() + $index) + 1 }}</td>
                                <td>{{ $faqCategory->name }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            wire:change="toggleStatus({{ $faqCategory->id }})"
                                            @checked($faqCategory->status)>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning"
                                        wire:click="edit({{ $faqCategory->id }})">Edit</button>
                                    @if (!in_array($faqCategory->id, [1, 2]))
                                        <button class="btn btn-sm btn-danger"
                                            wire:click="confirmDelete({{ $faqCategory->id }})">Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $faqCategories->links() }}

            <!-- Modal -->
            <div class="modal @if ($showModal) show @endif" tabindex="-1"
                style="opacity:1; background-color:#0606068c; display:@if ($showModal) block @endif">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ $modalTitle }}</h4>
                                <button type="button" class="btn-close" wire:click="$set('showModal', false)"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-12" x-data="{ name: @entangle('name') }">
                                        <label for="name" class="form-label">Category Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            x-model="name"
                                            x-on:input="name = name.replace(/\b\w/g, l => l.toUpperCase())"
                                            placeholder="Enter Category Name Here...">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    {{ $isEditing ? 'Update' : 'Save' }}
                                    <i class="spinner-border spinner-border-sm" wire:loading></i>
                                </button>
                                <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)"
                                    data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
