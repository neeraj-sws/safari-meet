<div class="container" id="amanity">

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

    </div>

    <div class="row g-4">
        <!-- Form Card -->
        <div class="col-md-5">
            <div class="card">

                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                        <div class="mb-3" x-data="{ title: @entangle('title') }">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                oninput="filterAndFormatInputs(this,{ allowAlpha: true,allowNumbers:true, capitalizeWords: true })"
                                x-model="title" x-on:input="title = title.replace(/\b\w/g, l => l.toUpperCase())"
                                placeholder="Enter Title Here...">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Icon</label>
                            <livewire:admin.common.icon-picker :icon="$icon" :field="'icon'" :pageid="'amanity'"
                                :key="'icon'" />
                            @error('icon')
                                <small class="text-danger">{{ $message }}</small>
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
                    <!--<div class="position-relative">-->
                    <!--    <input type="text" class="form-control ps-5" placeholder="Search..."-->
                    <!--        wire:model.live.debounce.300ms="search"> <span-->
                    <!--        class="position-absolute top-50 product-show translate-middle-y">-->
                    <!--        <i class="bx bx-search"></i></span>-->
                    <!--</div>-->

                    <div class="card-body">
                        <div class="table-responsive ecs-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Amenity</th>
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
                                                        {!! $item->icon !!}
                                                        {{ $item->title }}
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
                        @if ($items->hasPages())
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <div>
                                    Showing {{ $items->firstItem() }} to
                                    {{ $items->lastItem() }} of
                                    {{ $items->total() }} entries
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary" wire:click="previousPage"
                                        @disabled($items->onFirstPage())>Previous</button>
                                    @for ($page = 1; $page <= $items->lastPage(); $page++)
                                        <button
                                            class="btn btn-sm {{ $items->currentPage() == $page ? 'btn-primary' : 'btn-outline-primary' }}"
                                            wire:click="gotoPage({{ $page }})">
                                            {{ $page }}
                                        </button>
                                    @endfor
                                    <button class="btn btn-sm btn-outline-primary" wire:click="nextPage"
                                        @disabled(!$items->hasMorePages())>Next</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
