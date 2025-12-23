<div>

    <div class="text-end mb-3">
        <button wire:click="toggleForm" class="btn btn-sm btn-{{ $showForm ? 'secondary' : 'primary' }}">
            {{ $showForm ? 'Cancel' : '+ Add' }}
        </button>
    </div>

    @if ($showForm)
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form wire:submit.prevent="store">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Choose From List</label>
                        <select wire:model.live="featurethingstocarry" id="featurethingstocarry"
                            class="form-select select2">
                            <option value="">-- Select --</option>
                            @foreach ($thingsToCarries as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('featurethingstocarry')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <hr>

                    @foreach ($formItems as $i => $item)
                        <div class="row g-2 mb-3">
                            <div class="col-md-5">
                                <input type="text" class="form-control" placeholder="Title"
                                    oninput="filterAndFormatInputs(this, {allowNumbers: true, capitalizeWords:true,allowAlpha: true, allowedSpecialChars: '-()./,:\'\''})"
                                    wire:model="formItems.{{ $i }}.title">
                                @error("formItems.$i.title")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Description"
                                    oninput="filterAndFormatInputs(this, {allowNumbers: true, capitalizeWords:true,allowAlpha: true, allowedSpecialChars: '-()./,:\'\''})"
                                    wire:model="formItems.{{ $i }}.description">
                                @error("formItems.$i.description")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    wire:click="removeFormItem({{ $i }})">×</button>
                            </div>
                        </div>
                    @endforeach

                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3" wire:click="addFormItem">+ Add
                        More</button>

                    <div class="text-end">
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
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            @forelse ($thingsToCarryList as $item)
                <div class="d-flex justify-content-between align-items-start border-bottom py-2">
                    <div>
                        <strong><i class="fas fa-check text-success"></i> {{ $item->title }}</strong>
                        <p class="mb-0 small text-muted">{{ $item->description }}</p>
                    </div>
                    <button wire:click="confirmDelete({{ $item->id }})"
                        class="btn btn-sm btn-outline-danger">Delete</button>
                </div>
            @empty
                <p class="text-muted">No items added yet.</p>
            @endforelse
        </div>
    </div>


</div>
