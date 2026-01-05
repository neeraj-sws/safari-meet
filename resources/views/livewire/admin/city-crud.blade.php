<div class="container">
    @include('livewire.components.breadcrumb', [
        'menu' => $pageTitle,
        'submenus' => [$pageTitle],
    ])
    <div class="row g-4">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'submit' }}">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-group" x-data="{ city_name: @entangle('city_name') }">
                                        <label for="city_name" class="form-label">City Name <span
                                                class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" id="city_name" x-model="city_name"
                                            oninput="filterAndFormatInputs(this,{ allowAlpha: true,capitalizeWords: true })"
                                            x-on:input="city_name = city_name.replace(/\b\w/g, l => l.toUpperCase())"
                                            placeholder="Enter city Name">
                                        @error('city_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="state" class="form-label">State <span
                                                class="text-danger">*</span> </label>
                                        <select class="form-control select2" id="state" wire:model="state"
                                            placeholder="Select State">
                                            <option value="">Select State</option>
                                            @foreach ($states as $stateId => $stateValue)
                                                <option value="{{ $stateId }}" @selected($stateId == $state)>
                                                    {{ $stateValue }}</option>
                                            @endforeach
                                        </select>
                                        @error('state')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-primary px-5" wire:loading.attr="disabled">
                                {{ $isEditing ? 'Update' : 'Save' }}
                                <i class="spinner-border spinner-border-sm" wire:loading.delay
                                    wire:target="{{ $isEditing ? 'update' : 'store' }}"></i>
                            </button>

                            <button type="button" class="btn btn-secondary" wire:click="resetFields"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div>
                        <input type="text" class="form-control ms-auto mb-3" placeholder="Search"
                            wire:model.live.debounce.300ms="search" style="max-width:200px;">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>State</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cities as $index => $city)
                                    <tr>
                                        <td>{{ $cities->total() - ($cities->firstItem() + $index) + 1 }}</td>
                                        <td>{{ $city->name }}</td>
                                        <td>{{ $city->state?->name ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning"
                                                wire:click="edit({{ $city->id }})">Edit</button>
                                            <button class="btn btn-sm btn-danger"
                                                wire:click="confirmDelete({{ $city->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $cities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
