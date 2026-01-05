@push('styles')

@endpush
<div class="container" id="amanity">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/css/fontawesome-iconpicker.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/js/fontawesome-iconpicker.min.js"></script> --}}
    <div>
        <form wire:submit.prevent="save">
            <div class="form-group">
                <label>Select Icon</label>
                <div class="input-group" wire:ignore>
                    <input type="text" id="iconPickerInput" class="form-control iconPicker" value="{{ $icon }}">
                    <span class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="{{ $icon }}" id="selectedIconPreview"></i>
                        </button>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Save</button>
        </form>

        @if (session()->has('message'))
            <div class="alert alert-success mt-2">
                {{ session('message') }}
            </div>
        @endif
    </div>

</div>
@push('scripts')


    <script>
        // document.addEventListener("livewire:init", function() {
        //     $('#iconPickerInput').iconpicker().on('iconpickerSelected', function(event) {
        //         Livewire.dispatch('updateIcon', {
        //             icon: event.iconpickerValue
        //         });
        //         $('#selectedIconPreview').attr('class', event.iconpickerValue);
        //     });
        // });
    </script>
@endpush
