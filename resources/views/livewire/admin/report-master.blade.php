<div class="container">
    @include('livewire.components.breadcrumb', [
        'menu' => 'Reports',
        'submenus' => ['Reports'],
    ])

    <div class="card">
        <div class="card-body">

            {{-- Search --}}
            <div class="card-header d-flex justify-content-end">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5"
                        placeholder="Search by report type, safari, package, or reason..."
                        wire:model.live.debounce.300ms="search">
                    <span class="position-absolute top-50 translate-middle-y start-0 ps-3">
                        <i class="bx bx-search"></i>
                    </span>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive mt-3">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Report Type</th>
                            <th>Safari / Package</th>
                            <th>Reason</th>
                            <th>Discussion Comment</th>
                            <th>Details</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $index => $report)
                            <tr wire:key="report-{{ $report->report_id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ ucfirst($report->report_type) }}</td>
                                <td>
                                    @if ($report->sharedSafari)
                                        {{ $report->sharedSafari->title }}
                                    @elseif($report->package)
                                        {{ $report->package->title }}
                                    @elseif($report->mediaPost)
                                        <div>
                                            <strong>Post:</strong> {{ Str::limit($report->mediaPost->caption, 40) }}
                                        </div>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>{{ $report->reportReason?->title ?? '—' }}</td>
                                <td>{{ $report->discussion?->content ?? ($report->comment ?? '—') }}</td>
                                <td>{{ $report->details ?? '—' }}</td>
                                <td>{{ $report->created_at?->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <x-pagination :paginator="$reports" />
                                </button>
            </div>

        </div>
    </div>
</div>
