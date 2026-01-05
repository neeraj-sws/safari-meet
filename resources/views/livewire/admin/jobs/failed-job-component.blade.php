<div class="container">

    @include('livewire.components.breadcrumb', [
        'menu' => $pageTitle,
        'submenus' => [$pageTitle],
    ])
    {{-- FAQ Management Table --}}
    <div class="card">
        <div class="card-body">


            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th class="border p-2">#</th>
                            <th class="border p-2">Connection</th>
                            <th class="border p-2">Queue</th>
                            <th class="border p-2">Failed At</th>
                            <th class="border p-2">Reason</th>
                            <th class="border p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($failedJobs as $index => $job)
                            <tr wire:key="job-{{ $job->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td class="border p-2">{{ $job->connection }}</td>
                                <td class="border p-2">{{ $job->queue }}</td>
                                <td class="border p-2">{{ $job->failed_at }}</td>
                                <td class="border p-2">{{ \Illuminate\Support\Str::limit($job->exception, 50) }}</td>
                                <td class="border p-2">
                                    <button class="btn btn-sm btn-outline-primary"
                                        wire:click="toggleJob({{ $job->id }})">
                                        {{ $selectedJob && $selectedJob->id === $job->id ? 'Close' : 'View' }}
                                    </button>
                                </td>
                            </tr>

                            {{-- Expanded row --}}
                            @if ($selectedJob && $selectedJob->id === $job->id)
                                <tr>
                                    <td colspan="7" class="bg-light">
                                        <div class="p-3">
                                            <h5 class="fw-bold">Job Details #{{ $selectedJob->id }}</h5>

                                            <p><strong>Connection:</strong> {{ $selectedJob->connection }}</p>
                                            <p><strong>Queue:</strong> {{ $selectedJob->queue }}</p>
                                            <p><strong>Failed At:</strong> {{ $selectedJob->failed_at }}</p>

                                            <h6 class="mt-3 fw-semibold">Exception:</h6>
                                            <div class="bg-danger-subtle p-2 text-danger small rounded"
                                                style="max-height: 150px; overflow-y: auto; white-space: pre-wrap; word-break: break-word;">
                                                {{ $selectedJob->exception }}
                                            </div>

                                            <h6 class="mt-3 fw-semibold">Payload:</h6>
                                            <div class="bg-light p-2 small rounded"
                                                style="max-height: 200px; overflow-y: auto; white-space: pre-wrap; word-break: break-word;">
                                                {{ json_encode(json_decode($selectedJob->payload), JSON_PRETTY_PRINT) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <div class="mt-3">
                    @if ($failedJobs->hasPages())
                        <div class="card-footer d-flex justify-content-between align-item-center">
                            <div>
                                Showing {{ $failedJobs->firstItem() }} to
                                {{ $failedJobs->lastItem() }} of
                                {{ $failedJobs->total() }} entries
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary" wire:click="previousPage"
                                    @disabled($failedJobs->onFirstPage())>Previous</button>
                                @for ($page = 1; $page <= $failedJobs->lastPage(); $page++)
                                    <button
                                        class="btn btn-sm {{ $failedJobs->currentPage() == $page ? 'btn-primary' : 'btn-outline-primary' }}"
                                        wire:click="gotoPage({{ $page }})">
                                        {{ $page }}
                                    </button>
                                @endfor
                                <button class="btn btn-sm btn-outline-primary" wire:click="nextPage"
                                    @disabled(!$failedJobs->hasMorePages())>Next</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if ($selectedJob)
                <div class="mt-6 p-4 border rounded bg-gray-50">
                    <h2 class="text-lg font-semibold mb-2">
                        Job Details #{{ $selectedJob->id }}
                    </h2>

                    <p><strong>Connection:</strong> {{ $selectedJob->connection }}</p>
                    <p><strong>Queue:</strong> {{ $selectedJob->queue }}</p>
                    <p><strong>Failed At:</strong> {{ $selectedJob->failed_at }}</p>

                    <h3 class="mt-3 font-semibold">Exception:</h3>
                    <pre class="bg-red-50 p-2 text-red-700 overflow-x-auto whitespace-pre-wrap">
                                    {{ $selectedJob->exception }}
                             </pre>

                    <h3 class="mt-3 font-semibold">Payload:</h3>
                    <pre class="bg-gray-100 p-2 text-sm overflow-x-auto whitespace-pre-wrap">
                                    {{ json_encode(json_decode($selectedJob->payload), JSON_PRETTY_PRINT) }}
                            </pre>
                </div>
            @endif

        </div>
    </div>
</div>
