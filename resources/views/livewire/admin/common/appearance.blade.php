<div>

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
                        @foreach ($activity as $index => $item)
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" class="form-control"
                                    wire:model.defer="activity.{{ $index }}.title">
                                @error("activity.$index.title")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Short Description</label>
                                <input type="text" class="form-control"
                                    wire:model.defer="activity.{{ $index }}.short_distription">
                                @error("activity.$index.short_distription")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="button" class="btn btn-danger btn-sm mb-3"
                                wire:click="removeActivity({{ $index }})">Remove</button>
                            <hr> </hr>
                        @endforeach

                        <button type="button" class="btn btn-secondary btn-sm" wire:click="addActivity">+ Add
                            Appearance</button>
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
    <div class="row mt-4">
        <div class="col-md-12 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <strong>Add Appearance</strong>
                    <div>
                        <!-- Add Button -->
                        <button type="button" wire:click="addModel"
                            class="btn btn-sm btn-light text-dark me-1">
                            + Add Activity
                        </button>
                    </div>
                </div>

                  <div class="card-body">
                    @if ($appearanceData->count())
                        <ul class="list-group list-group-flush">
                            @foreach ($appearanceData as $detail)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $detail->title }}</strong><br></br>
                                        <small>{{ $detail->short_distription }}</small>
                                    </div>
                                    <button type="button"
                                        wire:click="deleteActivityFromAdaptation({{ $detail->id }})"
                                        class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No activities added yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
