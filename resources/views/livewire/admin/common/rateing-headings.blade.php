<div>

    <div class="text-end mb-3">
        <button class="btn {{ $showFormSection ? 'btn-secondary' : 'btn-primary' }}" type="button"
            wire:click="{{ $showFormSection ? 'hideForm' : 'showForm' }}">
            <i class="fas {{ $showFormSection ? 'fa-times-circle' : 'fa-plus-circle' }} me-1"></i>
            {{ $showFormSection ? 'Hide Form' : 'Add Rate Headings' }}
        </button>
    </div>

    @if ($showFormSection)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white fw-semibold">Add Headings</div>
            <div class="card-body">
                <form wire:submit.prevent="store">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Rate Heading Entries</h6>
                        <button type="button" class="btn btn-outline-primary btn-sm" wire:click="AddBlankFormList">
                            <i class="fas fa-plus me-1"></i> Add Field
                        </button>
                    </div>


                    @foreach ($FormList as $index => $list)
                        <div class="border rounded p-3 mb-3 bg-light">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="removeFormList({{ $index }})">
                                    <i class="fas fa-trash me-1"></i> Remove
                                </button>
                            </div>
                            <div class="mt-2">
                                <label class="form-label">Short Heading <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control @error("FormList.$index.short_heading") is-invalid @enderror"
                                    wire:model.defer="FormList.{{ $index }}.short_heading"
                                    oninput="filterAndFormatInputs(this, {allowNumbers: true, capitalizeWords:true,allowAlpha: true, allowedSpecialChars: '-()./:\'\''})"
                                    placeholder="Enter short heading...">
                                @error("FormList.$index.short_heading")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach


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
                        <th>Heading</th>
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reatingHeadings as $heading)
                        <tr>
                            <td>{{ $heading->heading_label }}</td>
                            <td>
                                <button wire:click="confirmDelete({{ $heading->id }})"
                                    class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($reatingHeadings->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $reatingHeadings->firstItem() }} to {{ $reatingHeadings->lastItem() }} of
                    {{ $reatingHeadings->total() }} entries
                </div>
                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-primary" wire:click="previousPage"
                        @disabled($reatingHeadings->onFirstPage())>Previous</button>
                    @for ($page = 1; $page <= $reatingHeadings->lastPage(); $page++)
                        <button
                            class="btn btn-sm {{ $reatingHeadings->currentPage() == $page ? 'btn-primary' : 'btn-outline-primary' }}"
                            wire:click="gotoPage({{ $page }})">
                            {{ $page }}
                        </button>
                    @endfor
                    <button class="btn btn-sm btn-outline-primary" wire:click="nextPage"
                        @disabled(!$reatingHeadings->hasMorePages())>Next</button>
                </div>
            </div>
        @endif
    </div>
</div>
