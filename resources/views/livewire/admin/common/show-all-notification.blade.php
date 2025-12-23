<div class="container">

    @include('livewire.components.breadcrumb', [
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

                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary" wire:click="previousPage"
                                @disabled($items->onFirstPage())>
                                Previous
                            </button>

                            @for ($page = 1; $page <= $items->lastPage(); $page++)
                                <button
                                    class="btn btn-sm {{ $items->currentPage() == $page ? 'btn-primary' : 'btn-outline-primary' }}"
                                    wire:click="gotoPage({{ $page }})">
                                    {{ $page }}
                                </button>
                                @endfor

                                <button class="btn btn-sm btn-outline-primary" wire:click="nextPage"
                                    @disabled(!$items->hasMorePages())>
                                    Next
                                </button>
                        </div>

                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
