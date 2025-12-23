<div class="container">
    @include('livewire.components.breadcrumb', [
        'menu' => $pageTitle,
        'submenus' => ['Information Tab'],
    ])
    <div class="row g-4">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-group" x-data="{ characterstics_name: @entangle('characterstics_name') }">
                                        <label for="city_name" class="form-label">Information Name <span
                                                class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" id="characterstics_name"
                                            oninput="filterAndFormatInputs(this,{ allowAlpha: true,capitalizeWords: true })"
                                            x-model="characterstics_name"
                                            x-on:input="characterstics_name = characterstics_name.replace(/\b\w/g, l => l.toUpperCase())"
                                            placeholder="Enter Information Name">
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
                                @foreach ($parkCharacterstic as $index => $characterstick)
                                    <tr>
                                        <td>{{ $parkCharacterstic->total() - ($parkCharacterstic->firstItem() + $index) + 1 }}
                                        </td>
                                        <td>{{ $characterstick->title }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    wire:change="toggleStatus({{ $characterstick->id }})"
                                                    id="{{ $characterstick->id }}" @checked($characterstick->status)>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-center" title="Edit"
                                                wire:click="edit({{ $characterstick->id }})">
                                                <i class="bx bx-edit text-dark fs-5"></i>
                                            </a>
                                            @if (!in_array($characterstick->id, [1, 2, 3, 4, 5, 6, 7, 8, 9]))
                                                <a href="javascript:void(0)"
                                                    wire:click="confirmDelete({{ $characterstick->id }})"
                                                    title="Delete">
                                                    <i class="bx bx-trash text-danger fs-5"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$parkCharacterstic" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
