<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="row ">
                    <div class="col-12 mb-2 ">
                        <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control  @error('subject') is-invalid @enderror"
                            wire:model="subject">
                        @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <div class="">
                            @php $editorId = 'body-'.$template->template_code. $this->getId(); @endphp
                            <livewire:admin.common.ckeditor-component model="body" :value="$body"
                                editor-id="{{ $editorId }}" wire:model.defer="body" />
                        </div>
                    </div>
                    @if (count($placeholders) > 0)
                    <div class="mb-1">
                        <label class="form-label">Placeholder</label>
                        <div class="col-md-10">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($placeholders as $key => $placeholder)
                                <span onclick="copyToClipboard('{{ $placeholder }}', this)" id="{{ $key }}"
                                    class="badge bg-light text-primary border border-primary px-3 py-2 copy-placeholder"
                                    style="cursor: pointer;">
                                    {{ $key }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-12 text-end mt-4">
                        <button type="submit" wire:target="store" wire:loading.attr="disabled" class="btn btn-primary"
                            id="submitOverview">
                            <span wire:loading.remove="" wire:target="store">
                                Submit
                            </span>
                            <span wire:loading="" wire:target="store">
                                <span class="spinner-border spinner-border-sm me-1" role="status"
                                    aria-hidden="true"></span>
                                Submitting...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
    window.copyToClipboard = function(placeholder, el) {
            const input = document.createElement('input');
            input.value = placeholder;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);

            const originalText = el.textContent;
            el.textContent = "Copied";
            el.classList.add('bg-success', 'text-black');

            setTimeout(() => {
                el.textContent = originalText;
                el.classList.remove('bg-success', 'text-black');
            }, 2000);
        };
</script>
@endpush
