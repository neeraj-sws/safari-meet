<div class="container">
     @include('livewire.components.breadcrumb', [
            'menu' => 'Enquiries',
            'submenus' => [
                'Enquiries',
            ],
        ])

    {{-- FAQ Management Table --}}
    <div class="card">
        <div class="card-body">
            {{-- Search --}}
            <div class="card-header d-flex justify-content-end">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5" placeholder="Search (Safari name, browser, etc.)"
                        wire:model.live.debounce.300ms="search"> <span
                        class="position-absolute top-50 product-show translate-middle-y">
                        <i class="bx bx-search"></i></span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Number</th>
                            <th>Safaris</th>
                            <th>Travellers</th>
                            <th>Accommodation</th>
                            <th>source</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Url</th>
                            <th>IP Address</th>
                            <th>OS</th>
                            <th>browser</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enquiries as $index => $enquiry)
                            <tr wire:key="quote-{{ $enquiry->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $enquiry->name }}</td>
                                <td>{{ $enquiry->email }}</td>
                                <td>{{ $enquiry->number }}</td>
                                <td>{{ $enquiry->safaris }}</td>
                                <td>{{ $enquiry->travellers }}</td>
                                <td>{{ $enquiry->accommodation?->title }}</td>
                                <td>{{ $enquiry->source }}</td>
                                <td>{{ $enquiry->start_date }}</td>
                                <td>{{ $enquiry->end_date }}</td>
                                <td> <a href="{{ $enquiry->url }}" target="_blank">{{ $enquiry->url }} </a></td>
                                <td>{{ $enquiry->ip_address }}</td>
                                <td>{{ $enquiry->os }}</td>
                                <td>{{ $enquiry->browser }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                @if ($enquiries->hasPages())
                    <div class="card-footer d-flex justify-content-between align-item-center">
                        <div>
                            Showing {{ $enquiries->firstItem() }} to
                            {{ $enquiries->lastItem() }} of
                            {{ $enquiries->total() }} entries
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary" wire:click="previousPage"
                                @disabled($enquiries->onFirstPage())>Previous</button>
                            @for ($page = 1; $page <= $enquiries->lastPage(); $page++)
                                <button
                                    class="btn btn-sm {{ $enquiries->currentPage() == $page ? 'btn-primary' : 'btn-outline-primary' }}"
                                    wire:click="gotoPage({{ $page }})">
                                    {{ $page }}
                                </button>
                            @endfor
                            <button class="btn btn-sm btn-outline-primary" wire:click="nextPage"
                                @disabled(!$enquiries->hasMorePages())>Next</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
