<div>
    <div class="container">
        <div class="my-3">
            <div class="text-end mb-3">
                @if (!$showForm)
                    <button class="btn btn-primary" type="button" wire:click="toggleForm" wire:loading.attr="disabled"
                        wire:target="toggleForm">
                        <span wire:loading.remove wire:target="toggleForm">
                            Add Important Cities
                        </span>
                        <span wire:loading wire:target="toggleForm">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Please wait...
                        </span>
                    </button>
                @else
                    <button class="btn btn-danger" type="button" wire:click="toggleForm" wire:loading.attr="disabled"
                        wire:target="toggleForm">
                        <span wire:loading.remove wire:target="toggleForm">
                            Hide
                        </span>
                        <span wire:loading wire:target="toggleForm">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Hiding...
                        </span>
                    </button>
                @endif
            </div>

            @if ($showForm)
                <div class="card mb-3">
                    <form wire:submit.prevent="storeCities">
                        <div class="card-body">
                            <div class="row">
                                @foreach ($heading as $key => $reachabilities)
                                    <div class="col-6 mb-2">
                                        <label class="form-label">Heading {{ ucwords(str_replace('-', ' ', $key)) }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"
                                            wire:model="heading.{{ $key }}"
                                            placeholder="Enter Heading {{ ucwords(str_replace('-', ' ', $key)) }}">
                                        @error("heading.$key")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            <div class="row justify-content-evenly">
                                <div class="col-6 text-center">
                                    <label for="state">State:</label>
                                    <select wire:model.live="state" id="state" class="form-select select2">
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-6 text-center">
                                    <label for="city">Cities:</label>
                                    <select wire:model.live="city" id="city" class="form-select select2" multiple>
                                        <option value="">Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                @foreach ($citisList as $key => $reachability)
                                    <label class="form-label">{{ $reachability['name'] }}</label>

                                    @foreach ($reachability['reachability'] as $inputKey => $input)
                                        <div class="col-6 mb-2">
                                            <label class="form-label">
                                                {{ $reachability['reachability_label'][$inputKey] }} <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control"
                                                wire:model="citisList.{{ $key }}.reachability.{{ $inputKey }}"
                                                oninput="filterAndFormatInputs(this, {allowAlpha: true,allowNumbers:true, allowedSpecialChars: '-()./–,:\'?\''})"
                                                placeholder="Enter Total {{ $reachability['reachability_label'][$inputKey] }} Area">
                                            @error("citisList.$key.reachability.$inputKey")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>

                            <div class="text-end">
                                <button class="btn btn-primary" type="submit" wire:loading.attr="disabled"
                                    wire:target="storeCities">
                                    <span wire:loading.remove wire:target="storeCities">
                                        Save
                                    </span>
                                    <span wire:loading wire:target="storeCities">
                                        <span class="spinner-border spinner-border-sm me-1"></span>
                                        Saving...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div> Important Cities List</div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>City Name</th>
                            <th>Distance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($IMPCitisList as $list)
                            <tr>
                                <td>{{ $list?->cityData?->name }}</td>
                                <td>{{ $list->distance }}</td>
                                <td>
                                    <button wire:click="confirmDelete({{ $list->id }})"
                                        class="btn btn-sm btn-danger" id="delete-button-{{ $list->id }}"
                                        wire:target="confirmDelete({{ $list->id }})" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="confirmDelete({{ $list->id }})">
                                            Delete
                                        </span>
                                        <span wire:loading wire:target="confirmDelete({{ $list->id }})">
                                            <span class="spinner-border spinner-border-sm me-1"></span>
                                            Deleting...
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No data found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Showing {{ $IMPCitisList->firstItem() }} to {{ $IMPCitisList->lastItem() }} of
                        {{ $IMPCitisList->total() }} entries
                    </div>

                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary" wire:click="previousPage"
                            wire:loading.attr="disabled" wire:target="previousPage" @disabled($IMPCitisList->onFirstPage())>
                            <span wire:loading.remove wire:target="previousPage">Previous</span>
                            <span wire:loading wire:target="previousPage">
                                <span class="spinner-border spinner-border-sm me-1"></span>Loading...
                            </span>
                        </button>

                        @for ($page = 1; $page <= $IMPCitisList->lastPage(); $page++)
                            <button
                                class="btn btn-sm {{ $IMPCitisList->currentPage() == $page ? 'btn-primary' : 'btn-outline-primary' }}"
                                wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled"
                                wire:target="gotoPage({{ $page }})">
                                <span wire:loading.remove
                                    wire:target="gotoPage({{ $page }})">{{ $page }}</span>
                                <span wire:loading wire:target="gotoPage({{ $page }})">
                                    <span class="spinner-border spinner-border-sm me-1"></span>
                                </span>
                            </button>
                        @endfor

                        <button class="btn btn-sm btn-outline-primary" wire:click="nextPage"
                            wire:loading.attr="disabled" wire:target="nextPage" @disabled(!$IMPCitisList->hasMorePages())>
                            <span wire:loading.remove wire:target="nextPage">Next</span>
                            <span wire:loading wire:target="nextPage">
                                <span class="spinner-border spinner-border-sm me-1"></span>Loading...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
