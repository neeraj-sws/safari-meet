<div>
    <div x-data="{ showForm: false }">
        <div class="text-end mb-3">
            <!-- Add Button -->
            <button class="btn btn-primary" type="button" x-show="!showForm"
                x-on:click=" showForm = true; $wire.call('resetForm') " wire:target="resetForm"
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="resetForm">Add Time</span>
                <span wire:loading wire:target="resetForm">
                    <span class="spinner-border spinner-border-sm me-1"></span> Loading...
                </span>
            </button>

            <!-- Hide Button -->
            <button class="btn btn-danger" type="button" x-show="showForm" x-on:click="showForm = false">Hide
                Time</button>
        </div>

        <!-- Add Form -->
        <div x-show="showForm" x-transition class="card mb-3">
            <form wire:submit.prevent="storeSlots">
                <div class="card-body">
                    <div class="row justify-content-evenly">
                        <div class="col-6 text-center">
                            <label>Safari Times:</label>
                            <select wire:model.live="weather_type" class="form-select">
                                <option value="">Select Time</option>
                                @foreach ($weatherTypes as $weatherType)
                                    <option value="{{ $weatherType->id }}">{{ $weatherType->title }}</option>
                                @endforeach
                            </select>
                            @error('weather_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        @foreach ($monthSlots as $index => $slot)
                            <div class="col-md-6 mb-3">
                                <label>{{ $slot['month'] }} Morning</label>
                                <input type="text" class="form-control"
                                    wire:model.defer="monthSlots.{{ $index }}.morning"
                                    placeholder="Enter {{ $slot['month'] }} Morning Time">
                                @error("monthSlots.$index.morning")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>{{ $slot['month'] }} Evening</label>
                                <input type="text" class="form-control"
                                    wire:model.defer="monthSlots.{{ $index }}.evening"
                                    placeholder="Enter {{ $slot['month'] }} Evening Time">
                                @error("monthSlots.$index.evening")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary" type="submit" wire:target="storeSlots"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="storeSlots">Save</span>
                            <span wire:loading wire:target="storeSlots">
                                <span class="spinner-border spinner-border-sm me-1"></span> Saving...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Time List</div>
            <div>
                <label>Type:</label>
                <select wire:model.live="type" class="form-select w-auto d-inline-block">
                    <option value="">All</option>
                    <option value="Morning">Morning</option>
                    <option value="Evening">Evening</option>
                </select>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Type</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slotLists as $slot)
                        <tr>
                            <td>{{ $slot->month }}</td>
                            <td>{{ $slot->slot_type }}</td>
                            <td>{{ $slot->start_time }}</td>
                            <td>
                                <button wire:click="confirmDelete({{ $slot->id }})" class="btn btn-sm btn-danger"
                                    wire:target="confirmDelete({{ $slot->id }})" wire:loading.attr="disabled">
                                    <span wire:loading.remove
                                        wire:target="confirmDelete({{ $slot->id }})">Delete</span>
                                    <span wire:loading wire:target="confirmDelete({{ $slot->id }})">
                                        <span class="spinner-border spinner-border-sm me-1"></span> Deleting...
                                    </span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <x-pagination :paginator="$slotLists" />
        </div>
    </div>
</div>
