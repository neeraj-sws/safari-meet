<div class="container">
    @include('livewire.travel-agent.common.breadcrumb', [
    'menu' => $pageTitle,
    'submenus' => ['Package'],
    'addButton' => 'openModal',
    'addText' => 'Add',
    'pageTitle' => 'Package',
    ])

    <div class="card">
        <div class="card-body">
            <div class="row g-1 g-md-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">
                <div class="col">
                    <div class="form-group">
                        <select id="filter_park" class="form-select select2" wire:model="filter_park"
                            placeholder="Select Park">
                            <option value="">Select Park</option>
                            @foreach ($safariParks as $parkId => $parkValue)
                            <option value="{{ $parkId }}">{{ $parkValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <select id="filter_visitPurposes" class="form-select select2" wire:model="filter_visitPurposes"
                            placeholder="Select Visit Purpose">
                            <option value="">Select Visit Purpose</option>
                            @foreach ($visitPurposes as $visitPurposesId => $visitPurposesValue)
                            <option value="{{ $visitPurposesId }}">{{ $visitPurposesValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <select id="filter_stayCategories" class="form-select select2"
                            wire:model="filter_stayCategories" placeholder="Select Stay Category">
                            <option value="">Select Stay Category</option>
                            @foreach ($stayCategories as $stayCategoriesId => $stayCategoriesValue)
                            <option value="{{ $stayCategoriesId }}">{{ $stayCategoriesValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col">
                    <button type="button" class="btn btn-info text-white rounded-0 me-2"
                        wire:click="applyFilter">Apply</button>
                    <button type="button" class="btn btn-info text-white rounded-0"
                        wire:click="resetFilter">Clear</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div>
                <input type="text" class="form-control ms-auto mb-3" placeholder="Search"
                    wire:model.live.debounce.300ms="search" style="max-width:200px;">
            </div>
            <div class="table-responsive">
                <table class="table table-bordered text-center ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Park</th>
                            <th>Price</th>
                            <th>Pyment</th>
                            <th>Is Published</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shareSafaries as $index => $shareSafari)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $shareSafari->title }}</td>
                            <td>{{ $shareSafari->park->name ?? '-' }}</td>
                            <td>₹{{ $shareSafari->min_price_pp }} - ₹{{ $shareSafari->max_price_pp }} </td>
                            <td>
                                @if ($shareSafari->is_paid == 0)
                                <a class="btn btn-sm btn-outline-success"
                                    wire:click="redirecttopayment('{{ $shareSafari->uuid }}')">
                                    Pay Now
                                </a>
                                @else
                                <a class="btn btn-sm btn-outline-success">Paid</a>
                                @endif
                            </td>

                            <td>
                                @if ($shareSafari->is_published == 1)
                                <span class="badge bg-success">Published</span>
                                @elseif ($shareSafari->is_published == 2)
                                <span class="badge bg-danger ">Declined</span>
                                @elseif ($shareSafari->is_published == 0)
                                <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="{{ $shareSafari->id }}" type="checkbox"
                                        role="switch" wire:change="toggleStatus({{ $shareSafari->id }})"
                                        @checked($shareSafari->status)>
                                </div>
                            </td>
                            <td>
                                <a class="text-center" wire:click="edit({{ $shareSafari->id }})">
                                    <i class="bx bx-edit text-dark fs-5"></i>
                                </a>
                                <a href="{{ route('agent.package.details', $shareSafari->uuid) }}" wire:navigate
                                    class="text-center">
                                    <i class="bx bx-detail fs-5 text-dark"></i>
                                </a>
                                {{-- <a title="Delete" wire:click="confirmDelete({{ $shareSafari->id }})">
                                    <i class="bx bx-trash text-danger fs-5"></i>
                                </a> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($shareSafaries->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $shareSafaries->firstItem() }} to {{ $shareSafaries->lastItem() }} of
                    {{ $shareSafaries->total() }} entries
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0 flex-wrap justify-content-center justify-content-md-end">
                        <li class="page-item {{ $shareSafaries->onFirstPage() ? 'disabled' : '' }}">
                            <button class="page-link" wire:click="previousPage" {{ $shareSafaries->onFirstPage() ?
                                'disabled' : '' }}>Previous</button>
                        </li>

                        @php
                        $start = max(1, $shareSafaries->currentPage() - 2);
                        $end = min($shareSafaries->lastPage(), $shareSafaries->currentPage() + 2);
                        @endphp

                        @if ($start > 1)
                        <li class="page-item">
                            <button class="page-link" wire:click="gotoPage(1)">1</button>
                        </li>
                        @if ($start > 2)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        @endif
                        @endif

                        @for ($page = $start; $page <= $end; $page++) <li
                            class="page-item {{ $shareSafaries->currentPage() == $page ? 'active' : '' }}">
                            <button class="page-link" wire:click="gotoPage({{ $page }})">
                                {{ $page }}
                            </button>
                            </li>
                            @endfor

                            @if ($end < $shareSafaries->lastPage())
                                @if ($end < $shareSafaries->lastPage() - 1)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                    @endif
                                    <li class="page-item">
                                        <button class="page-link"
                                            wire:click="gotoPage({{ $shareSafaries->lastPage() }})">
                                            {{ $shareSafaries->lastPage() }}
                                        </button>
                                    </li>
                                    @endif

                                    <li class="page-item {{ !$shareSafaries->hasMorePages() ? 'disabled' : '' }}">
                                        <button class="page-link" wire:click="nextPage" {{
                                            !$shareSafaries->hasMorePages() ? 'disabled' : '' }}>Next</button>
                                    </li>
                    </ul>
                </nav>
            </div>
            @endif

            <!-- Modal -->
            <div class="modal @if ($showModal) show @endif" tabindex="-1"
                style="opacity:1; background-color:#0606068c; display:@if ($showModal) block @endif">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form wire:submit.prevent="{{ $isEditing ? 'updateData' : 'store' }}">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ $modalTitle }}</h4>
                                <button type="button" class="btn-close" wire:click="$set('showModal', false)"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-6" x-data="{ title: @entangle('title') }">
                                        <label class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" x-model="title"
                                            oninput="filterAndFormatInputs(this, {allowAlpha: true, allowedSpecialChars: '-()./,:\'?\''})"
                                            x-on:input="title = title.replace(/\b\w/g, l => l.toUpperCase())"
                                            class="form-control" placeholder="Enter title">
                                        @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Safari Park <span class="text-danger">*</span></label>
                                        <select wire:model="safariPark" id="safariPark" name="safariPark"
                                            class="form-select select2" placeholder="Select Park">
                                            <option value="">-- Select Park --</option>
                                            @foreach ($safariParks as $id => $name)
                                            <option value="{{ $id }}" @selected($safariPark==$id)>
                                                {{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('safariPark')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Safari Type <span class="text-danger">*</span></label>
                                        <select wire:model="safari_type" id="safari_type" name="safari_type" multiple
                                            class="form-select select2" placeholder="Select Park">
                                            <option value="">-- Select Park --</option>
                                            @foreach ($safariTypes as $id => $type)
                                            <option value="{{ $type['id'] }}" @selected(in_array($type['id'],
                                                $safari_type))>
                                                {{ $type['name'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('safari_type')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tour highlights <span
                                                class="text-danger">*</span></label>
                                        <select wire:model="tour_highlights" id="tour_highlights" name="tour_highlights"
                                            multiple class="form-select select2" placeholder="Select Tour highlights">
                                            <option value="">-- Select Tour highlights --</option>
                                            @foreach ($inclusion_listes as $id => $list)
                                            <option value="{{ $id }}" @selected(in_array($id, $tour_highlights))>
                                                {{ $list }}</option>
                                            @endforeach
                                        </select>
                                        @error('tour_highlights')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Purpose of Visit <span
                                                class="text-danger">*</span></label>
                                        <select wire:model="visit_purpose_id" class="form-select select2"
                                            id="visit_purpose_id" placeholder="Select Visit Purpose">
                                            <option value="">Select a purpose</option>
                                            @foreach ($visitPurposes as $id => $label)
                                            <option value="{{ $id }}" @selected($visit_purpose_id==$id)>
                                                {{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('visit_purpose_id')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Stay Category <span
                                                class="text-danger">*</span></label>
                                        <select wire:model="stay_category_id" class="form-select select2"
                                            id="stay_category_id" placeholder="Select Staty Category">
                                            <option value="">Select a category</option>
                                            @foreach ($stayCategories as $id => $label)
                                            <option value="{{ $id }}" @selected($stay_category_id==$id)>
                                                {{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('stay_category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <label for="min_price_pp" class="form-label">Min Price Per Person(INR) <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="min_price_pp" id="min_price_pp"
                                                oninput="filterAndFormatInputs(this,{allowNumbers:true,allowedSpecialChars:'$₹'})"
                                                wire:model.live="min_price_pp" min="1" step="1" class="form-control"
                                                placeholder="500 ">
                                        </div>
                                        @error('min_price_pp')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="max_price_pp" class="form-label">Max Price Per Person(INR) <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="max_price_pp" id="max_price_pp" readonly
                                                wire:model="max_price_pp" min="1" step="1" class="form-control"
                                                placeholder="600">
                                        </div>
                                        @error('max_price_pp')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label"> Stay Night<span class="text-danger">*</span></label>
                                        <input type="text" wire:model.live="end_date" class="form-control"
                                            oninput="filterAndFormatInputs(this,{allowNumbers:true})"
                                            placeholder="Enter Stay Night">
                                        @error('end_date')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label">Stay Day <span class="text-danger">*</span></label>
                                        <input type="text" wire:model="start_date" class="form-control" readonly
                                            placeholder="Enter Stay Day ">
                                        @error('start_date')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <label for="no_of_safari" class="form-label">Number of Safaries <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="no_of_safari" id="no_of_safari"
                                                wire:model="no_of_safari" class="form-control"
                                                oninput="filterAndFormatInputs(this,{allowNumbers:true})"
                                                placeholder="Add number of safari like 2">
                                        </div>
                                        @error('no_of_safari')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Upload Display Image <span class="text-danger">*</span>
                                        </label>

                                        <input type="file" wire:model.live="display_image"
                                            accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                            class="form-control @error('display_image') is-invalid @enderror">

                                        <small>Expected aspect ratio is 2:1 (e.g. 600x300 px).</small> <br>
                                        @error('display_image')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">
                                            {{ $isEditing ? 'Current' : 'Preview' }}
                                        </label>

                                        <div class="border bg-light text-center p-2 position-relative"
                                            style="height: 200px;">

                                            @if ($display_image)
                                            <img src="{{ $display_image->temporaryUrl() }}"
                                                class="img-fluid h-100 object-fit-contain">
                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle"
                                                style="padding:0.2rem 0.4rem" wire:click="removeDisplayImage">
                                                ×
                                            </button>
                                            @elseif ($isEditing && !empty($previousImage))
                                            <img src="{{ asset($previousImage) }}"
                                                class="img-fluid h-100 object-fit-contain">
                                            @else
                                            <span
                                                class="text-muted d-flex align-items-center justify-content-center h-100">
                                                No Image Selected
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="modal-footer d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">
                                    {{ $isEditing ? 'Update' : 'Save' }}
                                    <i class="spinner-border spinner-border-sm" wire:loading></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
