<div class="container">
    @include('livewire.travel-agent.common.breadcrumb', [
    'menu' => $pageTitle,
    'submenus' => [$pageTitle],
    'addButton' => true,
    'addUrl' => route('createsaharedshafari'),
    'addText' => 'Add',
    'pageTitle' => $pageTitle,
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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Park</th>
                            <th>Date</th>
                            <th>Price (Min-Max)</th>
                            <th>Seats</th>
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
                            <td>{{ $shareSafari->day }} → {{ $shareSafari->night }}</td>
                            <td>₹{{ $shareSafari->min_price_pp }} - ₹{{ $shareSafari->max_price_pp }}</td>
                            <td>{{ $shareSafari->total_seats }}
                                (Shared - {{ $shareSafari->share_seats }})
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="{{ $index }}" type="checkbox" role="switch"
                                        wire:change="toggleStatus({{ $shareSafari->id }})"
                                        @checked($shareSafari->status)>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('edit.saharedshafari',['slug' => $shareSafari->slug, 'type' => 'basic-info']) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('agent.shared-safari.details', $shareSafari->uuid) }}"
                                    class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($shareSafaries->hasPages())
            <div class="card-footer d-flex justify-content-between align-shareSafaries-center">
                <div>
                    Showing {{ $shareSafaries->firstItem() }} to
                    {{ $shareSafaries->lastItem() }} of
                    {{ $shareSafaries->total() }} entries
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0 flex-wrap justify-content-center justify-content-md-end">
                        <li class="page-item {{ $shareSafaries->onFirstPage() ? 'disabled' : '' }}">
                            <button class="page-link" wire:click="previousPage" {{ $shareSafaries->onFirstPage() ? 'disabled' : '' }}>Previous</button>
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

                        @for ($page = $start; $page <= $end; $page++)
                            <li class="page-item {{ $shareSafaries->currentPage() == $page ? 'active' : '' }}">
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
                                <button class="page-link" wire:click="gotoPage({{ $shareSafaries->lastPage() }})">
                                    {{ $shareSafaries->lastPage() }}
                                </button>
                            </li>
                        @endif

                        <li class="page-item {{ !$shareSafaries->hasMorePages() ? 'disabled' : '' }}">
                            <button class="page-link" wire:click="nextPage" {{ !$shareSafaries->hasMorePages() ? 'disabled' : '' }}>Next</button>
                        </li>
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
