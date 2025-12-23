<div class="container">

    @include('livewire.travel-agent.common.breadcrumb', [
    'menu' => 'Notifications',
    'submenus' => ['All Notifications'],
    ])

    <div class="row g-4">
        <div class="col-md-12">
            <div class="card">

                <!-- SEARCH -->
                <div class="card-header d-flex justify-content-end">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5" placeholder="Search message..."
                            wire:model.live.debounce.300ms="search">
                        <span class="position-absolute top-50 product-show translate-middle-y">
                            <i class="bx bx-search"></i>
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive ecs-table">
                        <table class="table align-middle">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Sender → Receiver</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                @forelse ($items as $index => $item)
                                @php
                                $sender = $item->sender->name ?? 'N/A';
                                $receiver = $item->receiver->name ?? 'N/A';
                                @endphp

                                <tr wire:key="{{ $item->id }}" wire:click="markAsRead({{ $item->id }})"
                                    style="cursor: pointer;" class="{{ $item->is_read ? '' : 'table-warning' }}">

                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <strong>{{ $sender }}</strong>
                                        <i class="bx bx-right-arrow-alt"></i>
                                        <strong>{{ $receiver }}</strong>
                                    </td>

                                    <td>{{ $item->message }}</td>

                                    <td>
                                        @if ($item->is_read)
                                        <span class="badge bg-success">Read</span>
                                        @else
                                        <span class="badge bg-danger">Unread</span>
                                        @endif
                                    </td>

                                    <td>{{ $item->created_at->diffForHumans() }}</td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Notifications found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINATION -->
                    @if ($items->hasPages())
                    <div class="card-footer d-flex justify-content-between align-items-center">

                        <div>
                            Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of
                            {{ $items->total() }} entries
                        </div>

                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0 flex-wrap justify-content-center justify-content-md-end">
                                <li class="page-item {{ $items->onFirstPage() ? 'disabled' : '' }}">
                                    <button class="page-link" wire:click="previousPage" {{ $items->onFirstPage() ? 'disabled' : '' }}>Previous</button>
                                </li>

                                @php
                                    $start = max(1, $items->currentPage() - 2);
                                    $end = min($items->lastPage(), $items->currentPage() + 2);
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
                                    <li class="page-item {{ $items->currentPage() == $page ? 'active' : '' }}">
                                        <button class="page-link" wire:click="gotoPage({{ $page }})">
                                            {{ $page }}
                                        </button>
                                    </li>
                                @endfor

                                @if ($end < $items->lastPage())
                                    @if ($end < $items->lastPage() - 1)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                    <li class="page-item">
                                        <button class="page-link" wire:click="gotoPage({{ $items->lastPage() }})">
                                            {{ $items->lastPage() }}
                                        </button>
                                    </li>
                                @endif

                                <li class="page-item {{ !$items->hasMorePages() ? 'disabled' : '' }}">
                                    <button class="page-link" wire:click="nextPage" {{ !$items->hasMorePages() ? 'disabled' : '' }}>Next</button>
                                </li>
                            </ul>
                        </nav>

                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
