<div>
    <div x-data="{ showForm: false }">
        <div class="text-end mb-3">
            <!-- Add Button -->
            <button class="btn btn-primary" type="button" x-show="!showForm"
                x-on:click=" showForm = true; $wire.call('resetForm') " wire:target="resetForm"
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="resetForm">Add</span>
                <span wire:loading wire:target="resetForm">
                    <span class="spinner-border spinner-border-sm me-1"></span>
                    Loading...
                </span>
            </button>

            <!-- Hide Button -->
            <button class="btn btn-danger" type="button" x-show="showForm" x-on:click="showForm = false">Hide</button>
        </div>

        <!-- Add Zones Form -->
        <div x-show="showForm" x-transition class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>Add Zones</div>
                <div>
                    <!-- Add More Button -->
                    <button class="btn btn-secondary" wire:click="addRow" type="button" wire:target="addRow"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="addRow">Add More</span>
                        <span wire:loading wire:target="addRow">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Adding...
                        </span>
                    </button>
                </div>
            </div>

            <div class="card-body">
                @foreach ($zones as $index => $zone)
                    <div class="row mb-3">
                        <div class="col">
                            <input wire:model="zones.{{ $index }}.zone_name" class="form-control text-capitalize"
                                oninput="filterAndFormatInputs(this, {allowAlpha: true,allowNumbers:true, allowedSpecialChars: '-–()./&,:\'?\''})"
                                placeholder="Zone Name">
                            @error("zones.$index.zone_name")
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col">
                            <input wire:model="zones.{{ $index }}.entry_gate"
                                class="form-control text-capitalize"
                                oninput="filterAndFormatInputs(this, {allowAlpha: true,allowNumbers:true, allowedSpecialChars: '-–()./&,:\'?\''})"
                                placeholder="Entry Gate">
                            @error("zones.$index.entry_gate")
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col">
                            <select wire:model="zones.{{ $index }}.zoneType" class="form-select">
                                <option value="">Select Zone</option>
                                <option value="1">Core Zone</option>
                                <option value="2">Buffer Zone</option>
                            </select>
                            @error("zones.$index.zoneType")
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-auto">
                            <!-- Delete Row Button -->
                            <button class="btn btn-danger" wire:click="removeRow({{ $index }})" type="button"
                                wire:target="removeRow({{ $index }})" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="removeRow({{ $index }})">Delete</span>
                                <span wire:loading wire:target="removeRow({{ $index }})">
                                    <span class="spinner-border spinner-border-sm me-1"></span>
                                    Deleting...
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach

                <div class="text-end my-3">
                    <!-- Save Button -->
                    <button class="btn btn-primary" wire:click="saveZones" type="button" wire:target="saveZones"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="saveZones">Save</span>
                        <span wire:loading wire:target="saveZones">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Zones List -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>Zones List</div>
                <div>
                    <label>Zone Type:</label>
                    <select wire:model.live="zoneType" class="form-select w-auto d-inline-block">
                        <option value="">All</option>
                        <option value="1">Core Zone</option>
                        <option value="2">Buffer Zone</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Zone Name</th>
                        <th>Entry Gate</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zoneList as $zone)
                        <tr>
                            <td>{{ $zone->zone_name }}</td>
                            <td>{{ $zone->entry_gate }}</td>
                            <td>
                                @if ($zone->type == 1)
                                    Core Zone
                                @elseif($zone->type == 2)
                                    Buffer Zone
                                @endif
                            </td>
                            <td>
                                <!-- Delete Zone Button -->
                                <button wire:click="confirmDelete({{ $zone->id }})" class="btn btn-sm btn-danger"
                                    wire:target="confirmDelete({{ $zone->id }})" wire:loading.attr="disabled">
                                    <span wire:loading.remove
                                        wire:target="confirmDelete({{ $zone->id }})">Delete</span>
                                    <span wire:loading wire:target="confirmDelete({{ $zone->id }})">
                                        <span class="spinner-border spinner-border-sm me-1"></span>
                                        Deleting...
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

            <x-pagination :paginator="$zoneList" />
        </div>
    </div>
</div>
