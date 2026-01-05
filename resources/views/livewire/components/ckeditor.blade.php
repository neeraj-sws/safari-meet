<div wire:ignore>
    <div class="form-group mb-3">
        <textarea id="myeditorinstance" class="form-control pro_description" placeholder="Please Add Content Here..."
            rows="5">{{ $textEditor }}</textarea>
        @error('textEditor')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
@push('scripts')
    <script data-navigate-once>
        if (typeof window.ckEditorInstance === 'undefined') {
            window.ckEditorInstance = null;
        }

        if (typeof loadCKEditor === 'undefined') {
            // Dynamic CKEditor loader
            window.loadCKEditor = () => {
                return new Promise((resolve, reject) => {
                    if (window.ClassicEditor) return resolve(window.ClassicEditor);

                    const scriptTag = document.createElement('script');
                    scriptTag.src = 'https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js';
                    scriptTag.onload = () => resolve(window.ClassicEditor);
                    scriptTag.onerror = reject;
                    document.head.appendChild(scriptTag);
                });
            };
        }

        function setupCKEditorComponent(quotationValue = '') {
            const textarea = document.querySelector('#myeditorinstance');
            if (!textarea) return;

            const componentId = @json($this->getId());

            loadCKEditor().then(ClassicEditor => {
                if (window.ckEditorInstance) {
                    window.ckEditorInstance.destroy().then(() => {
                        window.ckEditorInstance = null;
                        createEditor(ClassicEditor, textarea, quotationValue, componentId);
                    });
                } else {
                    createEditor(ClassicEditor, textarea, quotationValue, componentId);
                }
            });
        }

        function createEditor(ClassicEditor, textarea, content, componentId) {
            ClassicEditor.create(textarea).then(editor => {
                window.ckEditorInstance = editor;
                editor.setData(content || '');

                editor.model.document.on('change:data', () => {
                    Livewire.find(componentId)?.set('textEditor', editor.getData());
                });

                editor.ui.view.editable.element.addEventListener('blur', () => {
                    setTimeout(() => {
                        Livewire.dispatch('editorTextChange', {
                            value: editor.getData()
                        });
                    }, 500);
                });
            });
        }

        document.addEventListener('livewire:navigated', () => {
            setTimeout(() => {
                const content = @json($textEditor ?? '');
                setupCKEditorComponent(content);
            }, 300);
        }, {
            once: true
        });

        document.addEventListener('DOMContentLoaded', () => {
            const content = @json($textEditor ?? '');
            setupCKEditorComponent(content);
        });
    </script>
@endpush
