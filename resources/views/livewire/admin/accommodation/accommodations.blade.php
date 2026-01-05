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
                        <div class="mb-3" x-data="{ title: @entangle('title') }">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                oninput="filterAndFormatInputs(this,{ allowAlpha: true,capitalizeWords: true })"
                                x-model="title" x-on:input="title = title.replace(/\b\w/g, l => l.toUpperCase())"
                                placeholder="Enter Title Here...">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="category_id" class="form-label">Stay Category <span
                                        class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 @error('category_id')is-invalid @enderror  "
                                    id="category_id" wire:model="category_id" placeholder="Select Category">
                                    <option value="">Select Category</option>
                                    @foreach ($StayCategories as $Id => $StayCategory)
                                        <option value="{{ $Id }}" @selected($category_id == $Id)>
                                            {{ $StayCategory }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('country_id') is-invalid @enderror"
                                wire:model.live="country_id" id="country_id" placeholder="Select Country">
                                <option value="">Select Country</option>
                                @foreach ($countries as $countryId => $countryValue)
                                    <option value="{{ $countryId }}" @selected($countryId == $country_id)>
                                        {{ $countryValue }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="state" class="form-label">State <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 @error('state') is-invalid @enderror "
                                    id="state" wire:model="state" placeholder="Select State">
                                    <option value="">Select State</option>
                                    @foreach ($states as $stateId => $stateValue)
                                        <option value="{{ $stateId }}" @selected($stateId == $state)>
                                            {{ $stateValue }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="city" class="form-label">city <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 @error('city') is-invalid @enderror" id="city"
                                    wire:model="city" placeholder="Select city">
                                    <option value="">Select city</option>
                                    @foreach ($cities as $cityId => $cityName)
                                        <option value="{{ $cityId }}" @selected($cityId == $city)>
                                            {{ $cityName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="amenity" class="form-label">Amenity <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 @error('amenity') is-invalid @enderror "
                                    id="amenity" wire:model="amenity" placeholder="Select Amenity" multiple>
                                    <option value="">Select Amenity</option>
                                    @foreach ($amenities as $amenityId => $amenityList)
                                        <option value="{{ $amenityId }}" @selected(in_array($amenityId, $amenity))>
                                            {{ $amenityList }}</option>
                                    @endforeach
                                </select>
                                @error('amenity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="rating" class="form-label">Rating <span
                                        class="text-danger">*</span></label>
                                <select class="form-control select2 @error('rating') is-invalid @enderror"
                                    id="rating" wire:model="rating" placeholder="Select Rating">
                                    <option value="">Select Rating</option>
                                    @for ($i = 1; $i <= 5; $i += 0.5)
                                        <option value="{{ $i }}" @selected($rating == $i)>
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                                @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Images <span class="text-danger">*</span></label>
                            <input type="file" wire:model="images" multiple id="images"
                                accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                class="form-control @error('images.*') is-invalid @enderror">
                            <div wire:loading wire:target="images" class="text-primary mt-2">
                                <i class="spinner-border spinner-border-sm"></i> Uploading...
                            </div>

                            <small><span>Only 5 Images can be uploaded</span></small>
                            @error('images.*')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Uploaded Images</label>
                            <div class="border bg-light text-center p-2 position-relative"
                                style="min-height: 143px; overflow-y: auto; max-height: 300px;">

                                <div wire:loading.remove wire:target="images" class="d-flex flex-wrap gap-2">
                                    @forelse ($uploadedImages as $index => $img)
                                        <div class="position-relative" style="width: 100px; height: 100px;">
                                            <img src="{{ asset($img) }}"
                                                class="img-fluid object-fit-contain w-100 h-100 rounded">
                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle z-3"
                                                style="padding: 0.2rem 0.4rem;"
                                                wire:click="removeUploadedImage({{ $index }})">×</button>
                                        </div>
                                    @empty
                                        <span
                                            class="text-muted d-flex align-items-center justify-content-center h-100">
                                            No Images Uploaded
                                        </span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-between">
                            <button type="button" wire:click="resetForm"
                                class="btn btn-sm btn-secondary">Cancel</button>

                            <button type="submit" class="btn btn-sm btn-primary px-5" wire:loading.attr="disabled"
                                wire:loading.class="disabled"
                                wire:target="images, {{ $isEditing ? 'update' : 'store' }}">
                                {{ $isEditing ? 'Update' : 'Save' }}

                                <i class="spinner-border spinner-border-sm" wire:loading.delay
                                    wire:target="{{ $isEditing ? 'update' : 'store' }}"></i>
                            </button>
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
                                    <th>Title</th>
                                    <th>Stay Category</th>
                                    <th>State</th>
                                    <th>City</th>
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
                                                    {{ $item->title }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $item->category->name }}
                                        </td>
                                        <td>
                                            {{ $item->state->name }}
                                        </td>
                                        <td>
                                            {{ $item->city->name }}
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
                                        <td colspan="6" class="text-center">No amenities found.</td>
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
