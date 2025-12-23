<div>
    <div class="text-end mb-3">
        @if (!$showBestTimeForm)
            <button class="btn btn-primary" type="button" wire:click="showBestTime">Add Best Time to
                Visit</button>
        @else
            <button class="btn btn-danger" type="button" wire:click="hideBestTime">Hide Best Time to
                Visit</button>
        @endif
    </div>

    @if ($showBestTimeForm)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>Add Best Time to Visit</div>
                <div>
                </div>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="storeBestTime">
                    @foreach ($BestTimeFormList as $index => $bestTime)
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-12">
                                <div class="border border-1 p-4 rounded">
                                    <div class="mb-3">
                                        <label class="form-label">Heading</label>
                                        <input type="text" wire:model="BestTimeFormList.{{ $index }}.heading"
                                            oninput="filterAndFormatInputs(this,{allowAlpha:true,capitalizeWords:true,allowedSpecialChars:`,:''&|()/-`})"
                                            class="form-control" placeholder="Enter heading">
                                        @error("BestTimeFormList.$index.heading")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div>
                                        @php $editorId = 'BestTimetoVisit-'.$index. $this->getId(); @endphp
                                        <livewire:admin.common.ckeditor-component model="Description" :value="$bestTime['description']"
                                            editor-id="{{ $editorId }}"
                                            wire:model.defer="BestTimeFormList.{{ $index }}.description" />

                                        @error("BestTimeFormList.$index.description")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="text-end my-3">
                        <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="storeBestTime">Save</span>
                            <span wire:loading wire:target="storeBestTime">
                                <span class="spinner-border spinner-border-sm"></span> Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Heading</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bestTimeToVisitList as $bestTimeVisit)
                        <tr>
                            <td>{{ $bestTimeVisit?->heading }}</td>
                            <td>{!! $bestTimeVisit?->description !!}</td>
                            <td>
                                <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $bestTimeVisit->id }})"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove
                                        wire:target="confirmDelete({{ $bestTimeVisit->id }})">Delete</span>
                                    <span wire:loading wire:target="confirmDelete({{ $bestTimeVisit->id }})">
                                        <span class="spinner-border spinner-border-sm"></span>
                                        Deleting...
                                    </span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing {{ $bestTimeToVisitList->firstItem() }} to {{ $bestTimeToVisitList->lastItem() }} of
                    {{ $bestTimeToVisitList->total() }}
                    entries
                </div>

                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-primary" wire:click="previousPage"
                        @disabled($bestTimeToVisitList->onFirstPage())>
                        Previous
                    </button>
                    @for ($page = 1; $page <= $bestTimeToVisitList->lastPage(); $page++)
                        <button
                            class="btn btn-sm {{ $bestTimeToVisitList->currentPage() == $page ? 'btn-primary' : 'btn-outline-primary' }}"
                            wire:click="gotoPage({{ $page }})">
                            {{ $page }}
                        </button>
                    @endfor
                    <button class="btn btn-sm btn-outline-primary" wire:click="nextPage" @disabled(!$bestTimeToVisitList->hasMorePages())>
                        Next
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
