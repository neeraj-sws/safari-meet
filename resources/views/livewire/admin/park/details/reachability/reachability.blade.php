<div>
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="storereachability">
                        <div class="row mt-3 align-items-center">

                            @foreach ($availableReachabilities as $index => $reachabilities)
                                @php
                                    $isLast = $loop->last;
                                    $isOdd = count($availableReachabilities) % 2 !== 0;
                                    $colClass = $isLast && $isOdd ? 'col-12' : 'col-6';

                                    $editorId = 'selectedReachability-' . $index . '-' . $this->getId();
                                    $label =
                                        $selectedReachabilityListes[$index]['title'] ??
                                        ($selectedReachabilityListes[$index]['title'] = $reachabilities);
                                @endphp

                                <div class="{{ $colClass }}">
                                    <div class="mb-3" key="{{ $this->getId() }}" wire:ignore>
                                        <livewire:admin.common.ckeditor-component model="{{ $label }}"
                                            :value="$selectedReachabilityListes[$index]['description'] ?? ''" editor-id="{{ $editorId }}"
                                            wire:model.defer="selectedReachabilityListes.{{ $index }}.description" />
                                        @error("selectedReachabilityListes.$index.description")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-12 text-end mt-4">
                            <button type="submit" wire:target="storereachability" wire:loading.attr="disabled"
                                class="btn btn-primary" id="submitOverview">
                                <span wire:loading.remove wire:target="storereachability">
                                    Submit
                                </span>
                                <span wire:loading wire:target="storereachability">
                                    <span class="spinner-border spinner-border-sm me-1" role="status"
                                        aria-hidden="true"></span>
                                    Submitting...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
