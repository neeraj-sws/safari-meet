<div class="container">

    @include('livewire.components.breadcrumb', [
        'menu' => $pageTitle,
        'submenus' => [$pageTitle],
    ])

    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h5 class="mb-0">{{ $pageTitle }}</h5>
                <input type="text" wire:model.live.debounce.500ms="search" class="form-control w-25"
                    placeholder="Search by user, action or message...">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Actor</th>
                            <th>Action</th>
                            <th>Category</th>
                            <th>Message</th>
                            <th>Happened At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $index => $log)
                            <tr wire:key="log-{{ $log->id }}">
                                <td>{{ $logs->firstItem() + $index }}</td>
                                <td>
                                    <div>{{ $log->actor_name }}</div>
                                    <small class="text-muted">{{ strtoupper($log->guard ?? 'GUEST') }}</small>
                                </td>

                                <td>{{ $log->action }}</td>
                                <td>{{ $log->category }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($log->message, 50) }}</td>
                                <td>{{ optional($log->happened_at)->format('d M Y h:i A') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                        wire:click="toggleLog({{ $log->id }})">
                                        {{ $selectedLog && $selectedLog->id === $log->id ? 'Close' : 'View' }}
                                    </button>
                                </td>
                            </tr>

                            @if ($selectedLog && $selectedLog->id === $log->id)
                                <tr>
                                    <td colspan="7" class="bg-light">
                                        <div class="p-3">
                                            <h5 class="fw-bold">Log Details #{{ $selectedLog->id }}</h5>

                                            <p><strong>Actor Type:</strong> {{ $selectedLog->actor_type }}</p>
                                            <p><strong>Actor ID:</strong> {{ $selectedLog->actor_id }}</p>
                                            <p><strong>Action:</strong> {{ $selectedLog->action }}</p>
                                            <p><strong>Category:</strong> {{ $selectedLog->category }}</p>
                                            <p><strong>Message:</strong> {{ $selectedLog->message }}</p>
                                            <p><strong>Guard:</strong> {{ $selectedLog->guard }}</p>
                                            <p><strong>Method:</strong> {{ $selectedLog->method }}</p>
                                            <p><strong>URL:</strong> {{ $selectedLog->url }}</p>
                                            <p><strong>IP Address:</strong> {{ $selectedLog->ip_address }}</p>
                                            <p><strong>User Agent:</strong> {{ $selectedLog->user_agent }}</p>
                                            <p><strong>Happened At:</strong>
                                                {{ optional($selectedLog->happened_at)->format('d M Y h:i A') }}</p>

                                            @if (!empty($selectedLog->parameters))
                                                <h6 class="mt-3 fw-semibold">Parameters:</h6>
                                                <div class="bg-light p-2 small rounded"
                                                    style="max-height: 200px; overflow-y: auto; white-space: pre-wrap; word-break: break-word;">
                                                    <pre>{{ json_encode($selectedLog->parameters, JSON_PRETTY_PRINT) }}</pre>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No activity logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <div class="mt-3">
                    @if ($logs->hasPages())
                        <div class="card-footer d-flex justify-content-between align-item-center">
                            <div>
                                Showing {{ $logs->firstItem() }} to
                                {{ $logs->lastItem() }} of
                                {{ $logs->total() }} entries
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary" wire:click="previousPage"
                                    @disabled($logs->onFirstPage())>Previous</button>
                                @for ($page = 1; $page <= $logs->lastPage(); $page++)
                                    <button
                                        class="btn btn-sm {{ $logs->currentPage() == $page ? 'btn-primary' : 'btn-outline-primary' }}"
                                        wire:click="gotoPage({{ $page }})">
                                        {{ $page }}
                                    </button>
                                @endfor
                                <button class="btn btn-sm btn-outline-primary" wire:click="nextPage"
                                    @disabled(!$logs->hasMorePages())>Next</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
