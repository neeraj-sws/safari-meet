<div>
    @if ($showActivityCard)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $modalTitle }}</h5>
                <button type="button" class="btn-close" wire:click="$set('showActivityCard', false)"></button>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="storeActivity">

                    <div class="mb-3" x-data="{ heading: @entangle('heading') }">
                        <label class="form-label">Heading <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" x-model="heading"
                            oninput="filterAndFormatInputs(this,{allowNumbers:true,allowAlpha:true,capitalizeWords:true,allowedSpecialChars:'-&,()'})"
                            x-on:input="heading = heading.replace(/\b\w/g, l => l.toUpperCase())">
                        @error('heading')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    @foreach ($activity as $index => $item)
                        <div class="row align-items-end mb-3">
                            <div class="col-11">
                                <label class="form-label">Activity</label>
                                <input type="text" class="form-control"
                                    oninput="filterAndFormatInputs(this, {allowNumbers: true, allowAlpha: true, allowedSpecialChars: '-()./:\'\''})"
                                    wire:model="activity.{{ $index }}">
                                @error("activity.$index")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-1 text-end">
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="removeActivity({{ $index }})">
                                    &times;
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="addActivity">
                            + Add Activity
                        </button>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('showActivityCard', false)">Cancel</button>
                        <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="storeActivity">Save</span>
                            <span wire:loading wire:target="storeActivity">
                                <span class="spinner-border spinner-border-sm"></span> Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif


    <div class="row">
        @for ($i = 1; $i <= $days; $i++)
            @php
                $day = $dayWiseData[$i] ?? null;
                $heading = $day['heading'] ?? '';
                $activities = $day['activities'] ?? [];
            @endphp

            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <strong>Day {{ $i }}</strong>
                        <button type="button" wire:click="addActivityModel({{ $i }})"
                            class="btn btn-sm btn-light text-dark">+ Add Activity</button>
                    </div>
                    <div class="card-body">
                        @if ($heading)
                            <h6 class="mb-3">{{ $heading }}</h6>
                        @endif

                        <ul class="list-group list-group-flush">
                            @foreach ($activities as $act)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fas fa-check me-2 text-success"></i>
                                        {{ $act['activity'] }}
                                    </span>
                                    <button type="button"
                                        wire:click="deleteActivity({{ $i }}, {{ $act['safari_itinerary_activities_id'] }})"
                                        class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </li>
                            @endforeach

                            @if (count($activities) == 0)
                                <li class="list-group-item text-muted">
                                    No activities added yet.
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
