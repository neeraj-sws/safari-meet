<div class="container">
 @include('livewire.components.breadcrumb', [
            'menu' => 'Contact Us Submissions',
            'submenus' => [
                'Contact Us Submissions',
            ],
        ])

    <div class="card">
        <div class="card-body">
            <div class="card-header d-flex justify-content-end">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5" placeholder="Search (name, email, phone, etc.)"
                        wire:model.live.debounce.300ms="search">
                    <span class="position-absolute top-50 product-show translate-middle-y">
                        <i class="bx bx-search"></i>
                    </span>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>People Traveling</th>
                            <th>Travel Date</th>
                            <th>Park</th>
                            <th>Safari Type</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($forms as $index => $form)
                            <tr>
                                <td>{{ $forms->firstItem() + $index }}</td>
                                <td>{{ $form->name }}</td>
                                <td>{{ $form->email }}</td>
                                <td>{{ $form->phone }}</td>
                                <td>{{ $form->people_traveling }}</td>
                                <td>{{ $form->travel_date }}</td>
                                <td>{{ $form->park?->name ?? 'N/A' }}</td>
                                <td>{{ $form->safariType?->safari_type?->name ?? 'N/A' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info text-white"
                                        wire:click="viewMessage('{{ addslashes($form->message) }}')">
                                        View Message
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                @if ($forms->hasPages())
                    <div class="card-footer d-flex justify-content-between align-item-center">
                        <div>
                            Showing {{ $forms->firstItem() }} to {{ $forms->lastItem() }} of {{ $forms->total() }}
                            entries
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary" wire:click="previousPage"
                                @disabled($forms->onFirstPage())>Previous</button>

                            @for ($page = 1; $page <= $forms->lastPage(); $page++)
                                <button
                                    class="btn btn-sm {{ $forms->currentPage() == $page ? 'btn-primary' : 'btn-outline-primary' }}"
                                    wire:click="gotoPage({{ $page }})">
                                    {{ $page }}
                                </button>
                            @endfor

                            <button class="btn btn-sm btn-outline-primary" wire:click="nextPage"
                                @disabled(!$forms->hasMorePages())>Next</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Message</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ $selectedMessage }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
