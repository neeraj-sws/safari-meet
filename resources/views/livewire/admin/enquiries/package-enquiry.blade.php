<div class="container">
    @include('livewire.components.breadcrumb', [
        'menu' => 'Safari Enquiries',
        'submenus' => ['Enquiries'],
    ])

    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <!-- Filter: OS -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Filter by OS</label>
                    <input type="text" class="form-control" placeholder="e.g. Windows, Android"
                        wire:model.live.debounce.300ms="filter_os">
                </div>

                <!-- Filter: Browser -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Filter by Browser</label>
                    <input type="text" class="form-control" placeholder="e.g. Chrome, Safari"
                        wire:model.live.debounce.300ms="filter_browser">
                </div>

                <!-- Search -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Search</label>
                    <input type="text" class="form-control" placeholder="Search by name, email, IP, etc."
                        wire:model.live.debounce.300ms="search">
                </div>

                <!-- Reset Button -->
                <div class="col-md-2">
                    <button type="button" class="btn btn-secondary w-100" wire:click="resetFilter">Clear</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="">
                        <tr>
                            <th>#</th>
                            <th>Package Name</th>
                            <th>Package Owner</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>Mobile</th>
                            <th>Travelers</th>
                            <th>Start Date</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enquiries as $index => $enquiry)
                            <tr wire:key="enquiry-{{ $enquiry->id }}">
                                <td>{{ $enquiries->firstItem() + $index }}</td>
                                <td>
                                    <a href="{{ $enquiry->packagesafari?->slug ? route('safari-package.detail', $enquiry->packagesafari->slug) : '#' }}"
                                       target="_blank">
                                        {{ $enquiry->packagesafari?->title ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>{{ ucfirst($enquiry->package_owner_type ?? '') }}</td>
                                <td>{{ $enquiry->name }}</td>
                                <td>{{ $enquiry->email }}</td>
                                <td>{{ $enquiry->country }}</td>
                                <td>{{ $enquiry->mobile_number }}</td>
                                <td>{{ $enquiry->travelers }}</td>
                                <td>{{ \Carbon\Carbon::parse($enquiry->start_date)->format('d M Y') }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                        data-bs-target="#messageModal{{ $enquiry->id }}">Read 
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="messageModal{{ $enquiry->id }}" tabindex="-1"
                                        aria-labelledby="messageModalLabel{{ $enquiry->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="messageModalLabel{{ $enquiry->id }}">Message from {{ $enquiry->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="white-space: pre-wrap;">{{ $enquiry->message }}</div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>



                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center text-muted">No enquiries found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                @if ($enquiries->hasPages())
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div>
                            Showing {{ $enquiries->firstItem() }} to
                            {{ $enquiries->lastItem() }} of
                            {{ $enquiries->total() }} entries
                        </div>
                        <div>
                            {{ $enquiries->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
