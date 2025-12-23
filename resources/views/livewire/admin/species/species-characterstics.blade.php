<div class="container">
    @include('livewire.components.breadcrumb', [
        'menu' => 'Species Characterstics',
        'submenus' => ['Species Characterstics'],
    ])
    <div class="row g-4">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="city_name" class="form-label">Characterstics Name <span
                                                class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" id="characterstics_name"
                                            oninput="filterAndFormatInputs(this,{allowAlpha:true,capitalizeWords:true})"
                                            wire:model="characterstics_name" placeholder="Enter Characterstics Name">
                                        @error('characterstics_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="resetFields"
                                class="btn btn-sm btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-primary px-5" wire:loading.attr="disabled">
                                {{ $isEditing ? 'Update' : 'Save' }}
                                <i class="spinner-border spinner-border-sm" wire:loading.delay
                                    wire:target="{{ $isEditing ? 'update' : 'store' }}"></i>
                            </button>
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
                                @foreach ($Speciescharacterstic as $index => $speciescate)
                                    <tr>
                                        <td>{{ $Speciescharacterstic->total() - ($Speciescharacterstic->firstItem() + $index) + 1 }}
                                        </td>
                                        <td>{{ $speciescate->title }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    wire:change="toggleStatus({{ $speciescate->id }})"
                                                    id="{{ $speciescate->id }}" @checked($speciescate->status)>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-center" title="Edit"
                                                wire:click="edit({{ $speciescate->id }})">
                                                <i class="bx bx-edit text-dark fs-5"></i>
                                            </a>
                                            @if (!in_array($speciescate->id, [1, 2, 3, 4, 5, 6, 7, 9]))
                                                <a href="javascript:void(0)"
                                                    wire:click="confirmDelete({{ $speciescate->id }})" title="Delete">
                                                    <i class="bx bx-trash text-danger fs-5"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$Speciescharacterstic" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
