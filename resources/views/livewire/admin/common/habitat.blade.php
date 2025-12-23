<div>
    <!-- Modal -->
    <div class="modal @if ($showActivityModal) show @endif"
        style="display:@if ($showActivityModal) block @else none @endif; background: rgba(0,0,0,0.5);"
        tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="storeActivity">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalTitle }}</h5>
                        <button type="button" class="btn-close" wire:click="$set('showActivityModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Heading <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('heading') is-invalid @enderror"
                                wire:model.defer="heading">
                            @error('heading')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @foreach ($activities as $index => $item)
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" class="form-control"
                                    wire:model.defer="activities.{{ $index }}.title">
                                @error("activities.$index.title")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Short Description</label>
                                <input type="text" class="form-control"
                                    wire:model.defer="activities.{{ $index }}.short_description">
                                @error("activities.$index.short_description")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="button" class="btn btn-danger btn-sm mb-3"
                                wire:click="removeActivity({{ $index }})">Remove</button>
                            <hr>
                        @endforeach

                        <button type="button" class="btn btn-secondary btn-sm" wire:click="addActivity">+ Add
                            Activity</button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('showActivityModal', false)">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Display Habitat -->
    <div class="row mt-4">
        <div class="col-md-12 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <strong>Habitat</strong>
                    <button type="button" wire:click="addModel" class="btn btn-sm btn-light text-dark me-1">
                        {{ $habitat ? 'Add Details' : '+ Add Habitat' }}
                    </button>
                </div>

                <div class="card-body">
                    @if ($habitat)
                        <h5 class="mb-3">{{ $habitat->name }}</h5>
                        @if ($habitat->details->count())
                            <ul class="list-group list-group-flush">
                                @foreach ($habitat->details as $detail)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $detail->title }}</strong><br>
                                            <small>{{ $detail->short_description }}</small>
                                        </div>
                                        <button type="button"
                                            wire:click="deleteActivityFromHabitat({{ $detail->id }})"
                                            class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No activity details found.</p>
                        @endif
                    @else
                        <p class="text-muted">No habitat found. Click “+ Add Habitat” to begin.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
