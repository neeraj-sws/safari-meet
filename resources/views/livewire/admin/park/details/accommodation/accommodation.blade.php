<div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div x-data="{ showForm: false }">
                    <div class="text-end mb-3">
                        <!-- Add button -->
                        <button class="btn btn-primary" type="button" x-show="!showForm" x-on:click="showForm = true"
                            wire:target="storeAccommodations" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="storeAccommodations">Add Accommodation</span>
                            <span wire:loading wire:target="storeAccommodations">
                                <span class="spinner-border spinner-border-sm me-1"></span> Loading...
                            </span>
                        </button>

                        <!-- Hide button -->
                        <button class="btn btn-danger" type="button" x-show="showForm"
                            x-on:click="showForm = false">Hide Accommodation</button>
                    </div>

                    <!-- Form -->
                    <div x-show="showForm" x-transition class="card mb-3">
                        <form wire:submit.prevent="storeAccommodations">
                            <div class="card-body">
                                <div class="row justify-content-evenly">
                                    <div class="col-6 text-center">
                                        <label for="selectedAccommodations">Accommodation Options:</label>
                                        <select wire:model.live="selectedAccommodations" id="selectedAccommodations"
                                            class="form-select select2" multiple>
                                            @foreach ($accommodationOptions as $accommodation)
                                                <option value="{{ $accommodation->id }}">{{ $accommodation->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('selectedAccommodations')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    @foreach ($accommodationNames as $name)
                                        <div class="col-4 mb-3">
                                            <input type="text" class="form-control" value="{{ $name }}"
                                                readonly>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" wire:target="storeAccommodations"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="storeAccommodations">Save</span>
                                        <span wire:loading wire:target="storeAccommodations">
                                            <span class="spinner-border spinner-border-sm me-1"></span> Saving...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- List -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>Accommodation List</div>
                        <div>
                            <input type="text" class="form-control" wire:model.live="search" placeholder="Search">
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($accommodationLists as $accommodation)
                                    <tr>
                                        <td>{{ $accommodation->accommodationList->title }}</td>
                                        <td>
                                            <button wire:click="confirmDelete({{ $accommodation->id }})"
                                                class="btn btn-sm btn-danger"
                                                wire:target="confirmDelete({{ $accommodation->id }})"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove
                                                    wire:target="confirmDelete({{ $accommodation->id }})">Delete</span>
                                                <span wire:loading
                                                    wire:target="confirmDelete({{ $accommodation->id }})">
                                                    <span class="spinner-border spinner-border-sm me-1"></span>
                                                    Deleting...
                                                </span>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">No data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <x-pagination :paginator="$accommodationLists" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
