<div class="container">
    @include('livewire.components.breadcrumb', [
        'menu' => $pageTitle,
        'submenus' => [$pageTitle],
        'addButton' => true,
        'addUrl' => route('admin.park.add-park'),
        'addText' => 'Add',
        'pageTitle' => 'Park',
    ])
    <div class="card">
        <div class="card-body">
            <div class="row g-1 g-md-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">
                <div class="col">
                    <div class="form-group">
                        <select id="filter_country" class="form-select select2" wire:model="filter_country"
                            placeholder="Select Country">
                            <option value="">Select Country</option>
                            @foreach ($countries as $countryId => $countryValue)
                                <option value="{{ $countryId }}">{{ $countryValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <select id="filter_state" class="form-select select2" wire:model="filter_state"
                            placeholder="Select State">
                            <option value="">Select State</option>
                            @foreach ($filter_states as $stateId => $stateValue)
                                <option value="{{ $stateId }}">{{ $stateValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <select id="filter_city" class="form-select select2" wire:model="filter_city"
                            placeholder="Select City">
                            <option value="">Select City</option>
                            @foreach ($filter_cities as $cityId => $cityValue)
                                <option value="{{ $cityId }}">{{ $cityValue }}</option>
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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Country</th>
                            <th>Status</th>
                            <th>Popular</th>
                            <th>Trending</th>
                            <th>Top Rated</th>
                            <th>Top Safaris</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($parks as $index => $park)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $park->name }}</td>
                                <td>{{ $park->city->name ?? '-' }}</td>
                                <td>{{ $park->state->name ?? '-' }}</td>
                                <td>{{ $park->country->name ?? '-' }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="toggleStatus{{ $park->id }}"
                                            type="checkbox" role="switch"
                                            wire:change="toggleStatus({{ $park->id }})"
                                            @checked($park->status)>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="Popular{{ $park->id }}" type="checkbox"
                                            role="switch" wire:change="toggleStatusPopular({{ $park->id }})"
                                            @checked($park->popular)>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="Trending{{ $park->id }}"
                                            type="checkbox" role="switch"
                                            wire:change="toggleStatusTrending({{ $park->id }})"
                                            @checked($park->trending)>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="TopRated{{ $park->id }}"
                                            type="checkbox" role="switch"
                                            wire:change="toggleStatusToRated({{ $park->id }})"
                                            @checked($park->top_rated)>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="TopRated{{ $park->id }}"
                                            type="checkbox" role="switch"
                                            wire:change="toggleStatusToSafari({{ $park->id }})"
                                            @checked($park->top_safari)>
                                    </div>
                                </td>
                                <td>
                                    <a class="text-center" href="{{ route('admin.park.edit-park', $park->id) }}"
                                        title="Edit">
                                        <i class="bx bx-edit text-dark fs-5"></i>
                                    </a>
                                    <a href="{{ route('admin.park.parkdetails', $park->uuid) }}" wire:navigate
                                        title="Details" class="text-center"> <i class="bx bx-detail fs-5 text-dark"></i>
                                    </a>
                                    <a title="Delete" wire:click="confirmDelete({{ $park->id }})"> <i
                                            class="bx bx-trash text-danger fs-5"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($parks->hasPages())
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div>
                            Showing {{ $parks->firstItem() }} to
                            {{ $parks->lastItem() }} of
                            {{ $parks->total() }} entries
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary" wire:click="previousPage"
                                @disabled($parks->onFirstPage())>Previous</button>
                            @for ($page = 1; $page <= $parks->lastPage(); $page++)
                                <button
                                    class="btn btn-sm {{ $parks->currentPage() == $page ? 'btn-primary' : 'btn-outline-primary' }}"
                                    wire:click="gotoPage({{ $page }})">
                                    {{ $page }}
                                </button>
                            @endfor
                            <button class="btn btn-sm btn-outline-primary" wire:click="nextPage"
                                @disabled(!$parks->hasMorePages())>Next</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
