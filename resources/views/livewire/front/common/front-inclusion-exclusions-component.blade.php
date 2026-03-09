<div>
    <div class="row">
        <div class="col-lg-12">

            <div class="text-end mb-3">
                <button type="button" wire:click="$toggle('showForm')"
                    class="btn btn-{{ $showForm ? 'secondary' : 'primary' }} btn-sm blue-btn-hover border-0 rounded-1 px-4">
                    {{ $showForm ? 'Hide Form' : '+ Add ' . ($type == 1 ? 'Inclusion' : 'Exclusion') }}
                </button>
            </div>

            @if ($showForm)
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Add {{ $type == 1 ? 'Inclusion' : 'Exclusion' }}</h5>
                    </div>

                    <div class="card-body">

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                {{ $type == 1 ? 'Inclusion' : 'Exclusion' }} Feature
                                <sup class="text-danger">*</sup>
                            </label>
                            <select wire:model.live="featureId" id="featureId" class="form-select select2 form-select-lg rounded-3 shadow-sm">
                                <option value="">-- Select Feature --</option>
                                @foreach ($featureOptions as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('featureId')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        @forelse ($items as $index => $item)
                            <div class="row align-items-center mb-3 border-bottom pb-3">
                                @if (Auth::guard('web')->check())
                                    <div class="col-md-2 text-center">
                                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                                    </div>
                                @else
                                    <div class="col-md-2 text-center">
                                        <livewire:admin.common.icon-picker :icon="$items[$index]['icon']" :field="'items.' . $index . '.icon'"
                                            :key="'row-icon-' . $index" :pageid="'details'" />
                                        @error("items.$index.icon")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endif


                                <div class="col-md-8">
                                    <input type="text" class="form-control"
                                        oninput="filterAndFormatInputs(this, {allowNumbers: true, capitalizeWords:true,allowAlpha: true, allowedSpecialChars: '-()./:\'\''})"
                                        wire:model="items.{{ $index }}.title" placeholder="Enter title">
                                    @error("items.$index.title")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        wire:click="removeRow({{ $index }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">
                                No {{ $type == 1 ? 'inclusions' : 'exclusions' }} selected yet.
                            </p>
                        @endforelse

                        <div class="mt-3">
                            <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="addRow">
                                + Add Row
                            </button>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary" wire:click="store">
                            <i class="fas fa-save"></i> Save All
                        </button>
                        <button type="button" class="btn btn-secondary" wire:click="$set('showForm', false)">
                            Cancel
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-body">
                    @forelse ($data as $item)
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                            <div class="d-flex align-items-center">
                                <span class="me-2">{!! $item['icon'] ?? '' !!}</span>
                                <span>{{ $item['title'] ?? 'N/A' }}</span>
                            </div>
                            <button type="button"
                                wire:click="deleteItem({{ $item['safari_inclusion_exclusions_id'] }})"
                                class="btn btn-outline-danger btn-sm">
                                Delete
                            </button>

                        </div>
                    @empty
                        <p class="text-muted">No {{ $type == 1 ? 'inclusions' : 'exclusions' }} added yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
