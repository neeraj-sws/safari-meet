<div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-check form-switch form-check-info mb-3">
                            <label class="form-check-label">Show In Front</label>
                            <input class="form-check-input"
                                wire:change="toggleStatus({{ $characterDetails['park_details_tabs_id'] }})"
                                @checked($characterDetails['status']) type="checkbox" role="switch">
                        </div>

                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                <a href="javascript:;"
                                    class="list-group-item py-1 {{ $activeTabe == 'species' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('species')">
                                    <span>Species</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-9">
                <div x-data="{ showForm: false }">
                    <div class="text-end mb-3">
                        <button class="btn btn-primary" type="button" x-show="!showForm" x-on:click="showForm = true">
                            Add Wildlife
                        </button>
                        <button class="btn btn-danger" type="button" x-show="showForm"
                            x-on:click="showForm = false">Hide Wildlife</button>
                    </div>

                    <div x-show="showForm" x-transition class="card mb-3">
                        <form wire:submit.prevent="storeSpecies">
                            <div class="card-body">
                                <div class="row justify-content-evenly">
                                    <div class="col-6 text-center">
                                        <label for="wildlifeSpecies">Select Species:</label>
                                        <select wire:model.live="wildlifeSpecies" id="wildlifeSpecies"
                                            class="form-select select2" multiple>
                                            @foreach ($speciesData as $species)
                                                <option value="{{ $species->id }}">{{ $species->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('wildlifeSpecies')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    @foreach ($wildelifeNames as $name)
                                        <div class="col-4 mb-3">
                                            <input type="text" class="form-control" value="{{ $name }}"
                                                readonly>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" wire:target="storeSpecies"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="storeSpecies">Save</span>
                                        <span wire:loading wire:target="storeSpecies">
                                            <span class="spinner-border spinner-border-sm me-1"></span> Saving...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>Wildlife List</div>
                        <div>
                            <input type="text" class="form-control" wire:model.live="search" placeholder="Search">
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($speciesLists as $list)
                                    <tr>
                                        <td>{{ $list->speciesList->name }}</td>
                                        <td>
                                            <button wire:click="confirmDelete({{ $list->id }})"
                                                class="btn btn-sm btn-danger"
                                                id="delete-button-{{ $list->id }}"
                                                wire:target="confirmDelete({{ $list->id }})"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove
                                                    wire:target="confirmDelete({{ $list->id }})">Delete</span>
                                                <span wire:loading wire:target="confirmDelete({{ $list->id }})">
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

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                Showing {{ $speciesLists->firstItem() }} to {{ $speciesLists->lastItem() }} of
                                {{ $speciesLists->total() }} entries
                            </div>

                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary" wire:click="previousPage"
                                    wire:target="previousPage" wire:loading.attr="disabled"
                                    @disabled($speciesLists->onFirstPage())>
                                    <span wire:loading.remove wire:target="previousPage">Previous</span>
                                    <span wire:loading wire:target="previousPage">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </span>
                                </button>

                                @for ($page = 1; $page <= $speciesLists->lastPage(); $page++)
                                    <button
                                        class="btn btn-sm {{ $speciesLists->currentPage() == $page ? 'btn-primary' : 'btn-outline-primary' }}"
                                        wire:click="gotoPage({{ $page }})"
                                        wire:target="gotoPage({{ $page }})" wire:loading.attr="disabled">
                                        <span wire:loading.remove
                                            wire:target="gotoPage({{ $page }})">{{ $page }}</span>
                                        <span wire:loading wire:target="gotoPage({{ $page }})">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </span>
                                    </button>
                                @endfor

                                <button class="btn btn-sm btn-outline-primary" wire:click="nextPage"
                                    wire:target="nextPage" wire:loading.attr="disabled" @disabled(!$speciesLists->hasMorePages())>
                                    <span wire:loading.remove wire:target="nextPage">Next</span>
                                    <span wire:loading wire:target="nextPage">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </span>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
