<div class="container">
    @php
        use App\Helpers\SettingHelper;
    @endphp
    @include('livewire.components.breadcrumb', [
        'menu' => $pageTitle,
        'submenus' => [$pageTitle],
        'addButton' => true,
        'addUrl' => route('admin.sharedsafari.addsafari'),
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
            <div class="nav nav-pills nav-pills-success text-white navpillbagdes justify-content-start">
                <div class="nav-item deliverOrder me-2 mb-2 mobilewidth  border border-dark bg-success ">
                    <a href="#" onclick="updateTab('admin')" wire:click.prevent="$set('activeState', 1)"
                        class="text-white nav-link statusFilter">
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <div class="tab-title">Admin
                                <span class="badge bg-dark">{{ $adminCount }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="nav-item cancelOrder me-2 mb-2 mobilewidth bg-info border border-dark">
                    <a href="#" onclick="updateTab('user')" wire:click.prevent="$set('activeState', 2)"
                        class="text-white nav-link statusFilter">
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <div class="tab-title">User
                                <span class="badge bg-dark">{{ $userCount }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="nav-item cancelOrder me-2 mb-2 mobilewidth bg-primary border border-dark ">
                    <a href="#" onclick="updateTab('agent')" wire:click.prevent="$set('activeState', 3)"
                        class="text-white nav-link statusFilter">
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <div class="tab-title">Agent
                                <span class="badge bg-dark">{{ $agentCount }}</span>
                            </div>
                        </div>
                    </a>
                </div>

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
                            <th>Payment Proof</th>
                            <th>Is Published</th>
                            <th>Status</th>
                            <th>Popular</th>
                            <th>Trending</th>
                            <th>Top-Rated</th>
                            @if ($activeState == 1)
                                <th>Interested Users</th>
                            @endif
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
                                <td>₹{{ SettingHelper::formatPrice($shareSafari->min_price_pp) }} -
                                    ₹{{ SettingHelper::formatPrice($shareSafari->max_price_pp) }}</td>
                                <td>{{ $shareSafari->total_seats }}
                                    (Shared - {{ $shareSafari->share_seats }})
                                </td>
                                <td>
                                    @if ($shareSafari->payment)
                                        <a class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse"
                                            href="#paymentDetails{{ $shareSafari->id }}" role="button"
                                            aria-expanded="false" aria-controls="paymentDetails{{ $shareSafari->id }}">
                                            View Payment
                                        </a>

                                        <div class="collapse mt-2" id="paymentDetails{{ $shareSafari->id }}">
                                            <div class="border p-2 rounded bg-light">

                                                <div><strong>Amount:</strong> ₹{{ $shareSafari->payment->amount }}
                                                </div>

                                                @if ($shareSafari->payment->utr)
                                                    <div class="text-muted">
                                                        <strong>UTR / Transaction ID:</strong> {{ $shareSafari->payment->utr }}
                                                    </div>
                                                @endif

                                                @if ($shareSafari->payment->screenshot)
                                                    <div class="mt-1">
                                                        <a href="{{ $shareSafari->payment->screenshot }}"
                                                            target="_blank" class="text-decoration-underline">
                                                            View Screenshot
                                                        </a>
                                                    </div>
                                                @endif

                                                <div class="text-muted small mt-1">
                                                    {{ $shareSafari->payment->created_at->format('d M Y, h:i A') }}
                                                </div>

                                            </div>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary">Unpaid</span>
                                    @endif
                                </td>


                                <td>
                                    @if ($shareSafari->is_approved == 0)
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        <a class="btn btn-sm btn-outline-success"
                                            wire:click="confirmPublishStatus({{ $shareSafari->id }},1)">Active</a>
                                        <a class="btn btn-sm btn-outline-danger"
                                            wire:click="confirmPublishStatus({{ $shareSafari->id }},2)">Inactive</a>
                                    @elseif($shareSafari->is_approved == 1)
                                        <span class="badge bg-success text-dark">Active</span>
                                        <a class="btn btn-sm btn-outline-danger "
                                            wire:click="confirmPublishStatus({{ $shareSafari->id }},2)">Inactive</a>
                                    @elseif($shareSafari->is_approved == 2)
                                        <span class="badge bg-danger text-dark">Inactive</span>
                                        <a class="btn btn-sm btn-outline-success "
                                            wire:click="confirmPublishStatus({{ $shareSafari->id }},1)">Active</a>
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
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="Popular{{ $shareSafari->id }}"
                                            type="checkbox" role="switch"
                                            wire:change="toggleStatusPopular({{ $shareSafari->id }})"
                                            @checked($shareSafari->popular)>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="Trending{{ $shareSafari->id }}"
                                            type="checkbox" role="switch"
                                            wire:change="toggleStatusTrending({{ $shareSafari->id }})"
                                            @checked($shareSafari->trending)>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="TopRated{{ $shareSafari->id }}"
                                            type="checkbox" role="switch"
                                            wire:change="toggleStatusTopRated({{ $shareSafari->id }})"
                                            @checked($shareSafari->top_rated)>
                                    </div>
                                </td>
                                @if ($activeState == 1)
                                    <td class="text-center">
                                        <a href="{{ route('admin.sharedsafari.interested', $shareSafari->uuid) }}"
                                            title="Show Intersted">
                                            <i class="bx bx-group text-primary fs-3"></i>
                                        </a>
                                    </td>
                                @endif
                                <td class="text-center">
                                    <a href="{{ route('admin.sharedsafari.editsafari', $shareSafari->uuid) }}"
                                        class="text-center"><i class="bx bx-edit text-dark fs-5"></i></a>
                                    <a href="{{ route('admin.sharedsafari.details', $shareSafari->uuid) }}"
                                        wire:navigate="" class="text-center"> <i
                                            class="bx bx-detail fs-5 text-dark"></i></a>
                                    <a href="javascript:void(0)" title="Delete"
                                        wire:click="confirmDelete({{ $shareSafari->id }})"> <i
                                            class="bx bx-trash text-danger fs-5"></i></a>
                                    @if ($shareSafari->organized_type == 'admin')
                                        <a href="{{ route('admin.sharedsafari.persnal-chat', $shareSafari->uuid) }}"
                                            title="Chat">
                                            <i class="bx bx-chat text-primary fs-5"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <x-pagination :paginator="$shareSafaries" />
        </div>
    </div>
</div>
