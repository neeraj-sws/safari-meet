<div>

    <div class="text-end mb-3">
        <button class="btn {{ $showFormSection ? 'btn-secondary' : 'btn-primary' }}" type="button"
            wire:click="{{ $showFormSection ? 'hideForm' : 'showForm' }}">
            <i class="bi {{ $showFormSection ? 'bi-x-circle' : 'bi-plus-circle' }} me-1"></i>
            {{ $showFormSection ? 'Hide Form' : 'Add Rate Headings' }}
        </button>
    </div>

    @if ($showFormSection)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white fw-semibold">Add Rate Headings</div>
            <div class="card-body">
                <form wire:submit.prevent="store">
                    @if (count($safari_types) && count($FormList))
                        @foreach ($safari_types as $type)
                            <div class="border p-3 rounded mb-4">
                                <h6 class="fw-semibold mb-3">Safari Type: {{ $type->safari_type->name }}</h6>

                                @foreach ($FormList as $index => $heading)
                                    <div class="mb-3">
                                        <label class="form-label">{{ $heading['heading_label'] }}</label>
                                        <input type="text" step="1"
                                            class="form-control @error('PriceMatrix.' . $type->id . '.' . $heading['id']) is-invalid @enderror"
                                            oninput="filterAndFormatInputs(this, {allowNumbers: true,allowedSpecialChars: ''})"
                                            wire:model.defer="PriceMatrix.{{ $type->id }}.{{ $heading['id'] }}"
                                            placeholder="Enter price for {{ $heading['heading_label'] }}">

                                        @error('PriceMatrix.' . $type->id . '.' . $heading['id'])
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach

                            </div>
                        @endforeach
                    @endif

                    <div class="text-end mt-3">
                        <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="store">Save</span>
                            <span wire:loading wire:target="store">
                                <span class="spinner-border spinner-border-sm"></span> Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Safari Type</th>
                        <th>Heading</th>
                        <th>Price</th>
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ratings as $rating)
                        <tr>
                            <td>{{ $rating->safariType->safari_type->name ?? 'N/A' }}</td>
                            <td>{{ $rating->heading->heading_label ?? 'N/A' }}</td>
                            <td>{{ number_format($rating->price, 0) }}</td>
                            <td>
                                <button wire:click="confirmDelete({{ $rating->id }})"
                                    class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No Rates found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($ratings->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $ratings->firstItem() }} to {{ $ratings->lastItem() }} of
                    {{ $ratings->total() }} entries
                </div>
                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-primary" wire:click="previousPage"
                        @disabled($ratings->onFirstPage())>Previous</button>
                    @for ($page = 1; $page <= $ratings->lastPage(); $page++)
                        <button
                            class="btn btn-sm {{ $ratings->currentPage() == $page ? 'btn-primary' : 'btn-outline-primary' }}"
                            wire:click="gotoPage({{ $page }})">
                            {{ $page }}
                        </button>
                    @endfor
                    <button class="btn btn-sm btn-outline-primary" wire:click="nextPage"
                        @disabled(!$ratings->hasMorePages())>Next</button>
                </div>
            </div>
        @endif
    </div>



</div>
