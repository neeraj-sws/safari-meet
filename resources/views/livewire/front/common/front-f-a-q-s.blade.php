<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">FAQs</h5>
        <button type="button" wire:click="addModel()" class="btn {{ $showForm ? 'btn-danger': 'btn-success' }}  btn-sm">
             {{ $showForm ? 'Close Form' : 'Add FAQ' }}
        </button>
    </div>
    @if ($showForm)
        <div class="card mt-3 shadow-sm rounded-3">
            <div class="card-body">
                <form wire:submit.prevent="store">
                    <h5 class="mb-3">{{ $modalTitle }}</h5>

                    <div class="mb-3">
                        <label class="form-label">Select FAQ Template</label>
                        <select wire:model.live="faq_id" class="form-select">
                            <option value="">-- Select --</option>
                            @foreach ($faqs as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('faq_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <hr>

                    @foreach ($questions as $index => $item)
                        <div class="mb-3">
                            <label>Question</label>
                            <input type="text" class="form-control"
                                oninput="filterAndFormatInputs(this, {allowNumbers: true,allowAlpha: true, allowedSpecialChars: '-()./,:\'?\''})"
                                wire:model="questions.{{ $index }}.question"
                                {{ $item['readonly'] ?? false ? 'readonly' : '' }}>
                            @error("questions.$index.question")
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Answer</label>
                            <textarea class="form-control" wire:model="questions.{{ $index }}.answer"
                                oninput="filterAndFormatInputs(this, {allowNumbers: true,allowAlpha: true, allowedSpecialChars: '-()./,:\'\''})"
                                {{ $item['readonly'] ?? false ? 'readonly' : '' }}></textarea>
                            @error("questions.$index.answer")
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @empty($item['readonly'])
                            <button type="button" class="btn btn-outline-danger btn-sm mb-3"
                                wire:click="removeQuestion({{ $index }})">
                                Remove
                            </button>
                        @endempty
                        <hr>
                    @endforeach

                    <button type="button" class="btn btn-outline-primary btn-sm" wire:click="addQuestion">
                        + Add Question
                    </button>

                    <div class="mt-3">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('showForm', false)">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <div class="card shadow-sm rounded-3">
        <div class="card-body p-4">
            @forelse ($data as $index => $item)
                <div class="border rounded p-3 mb-3 bg-light">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>Q{{ $index + 1 }}:</strong> {{ $item['question'] ?? 'N/A' }}
                            <p class="mb-0 text-muted"><em>{{ $item['answer'] ?? 'N/A' }}</em></p>
                        </div>
                        <button type="button" wire:click="confirmDelete({{ $item['safari_faqs_id'] }}, 'delete')"
                            class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-muted">No FAQs added yet.</p>
            @endforelse
        </div>
    </div>
</div>
