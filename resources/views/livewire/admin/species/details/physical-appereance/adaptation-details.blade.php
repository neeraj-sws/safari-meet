<div>
    <div class="col-lg-12 mt-3 text-end">
        <a class="btn btn-primary {{ $showActivityModal ? 'd-none' : '' }}" href="javascript:void(0)"
            wire:click="addModel">Add Adaptations</a>
        <a class="btn btn-danger {{ !$showActivityModal ? 'd-none' : '' }}" href="javascript:void(0)"
            wire:click="hideAdaptation">Hide Adaptations</a>
    </div>

    <!-- Activity Card -->
    @if ($showActivityModal)
        <div class="card shadow-sm my-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $modalTitle }}</h5>
            </div>

            <div class="card-body">
                @if ($showActivityModal)
                    <form wire:submit.prevent="storeActivity">
                        {{-- Heading input --}}
                        <div class="mb-3">
                            <label class="form-label">Heading</label>
                            <input type="text" class="form-control text-capitalize" wire:model="heading" oninput="filterAndFormatInputs(this,{allowNumbers:true,allowAlpha:true,allowedSpecialChars:`,–''/&()|-`})">
                            @error('heading')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- CKEditor --}}
                        @php $editorId = 'AddAdaptations-' . $this->getId(); @endphp
                        <livewire:admin.common.ckeditor-component wire:model.defer="description"
                            editor-id="{{ $editorId }}" model="Adaptations" :value="$description" :key="$editorId" />
                        @error('description')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror

                        <div class="text-end">

                            <button type="submit" class="btn btn-success text-end" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="storeActivity">Save</span>
                                <span wire:loading wire:target="storeActivity">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Saving...
                                </span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif

    <!-- Adaptation Cards -->
    <div class="row mt-4">
        @forelse ($adaptationData as $adaptation)
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-secondary  text-white d-flex justify-content-between align-items-center">
                        <strong>{{ $adaptation->title }}</strong>
                        <div>
                            <button type="button" wire:click="addActivityToAdaptation({{ $adaptation->id }})"
                                class="btn btn-sm btn-light text-dark me-1">
                                + Edit
                            </button>
                            <button type="button" wire:click="deleteAdaptation({{ $adaptation->id }})"
                                class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (!empty($adaptation->short_description))
                            <p>{!! $adaptation->short_description !!}</p>
                        @else
                            <p class="text-muted">No description available.</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted text-center">No adaptations added yet.</p>
            </div>
        @endforelse
    </div>
</div>
