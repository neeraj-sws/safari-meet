<?php

namespace App\Livewire\Admin\Common;

use App\Models\{ParkFaq, Faq};
use Livewire\Attributes\On;
use Livewire\Component;

class FAQS extends Component
{
    public $data = [], $modalTitle, $faqs = [], $packageId, $shareSafariId,
        $questions = [], $faq_id, $type, $deleteId, $showForm = false;

    public function mount($park)
    {
        // if ($type == 2) {
        //     $this->packageId = $id;
        // } elseif ($type == 1) {
        //     $this->shareSafariId = $id;
        // }
        $this->type = $park;
    }

    public function render()
    {
        $query = ParkFaq::where('park_id', $this->type->id);

        // if ($this->packageId) {
        //     $query->where('package_id', $this->packageId);
        // }
        // if ($this->shareSafariId) {
        //     $query->where('share_safari_id', $this->shareSafariId);
        // }

        $this->data = $query->get()->toArray();
        return view('livewire.admin.common.f-a-q-s');
    }

    public function addModel()
    {
        $this->modalTitle = 'Add FAQ';
        $this->faqs = Faq::where('category_id', 2)->pluck('question', 'faq_id');
        $this->resetValidation();
        $this->resetData();
        $this->showForm = !$this->showForm;
    }

    public function store()
    {
        $allEmpty = collect($this->questions)->every(
            fn($item) =>
            empty(trim($item['question'])) && empty(trim($item['answer']))
        );

        $rules = [
            'questions.*.question' => 'required|string',
            'questions.*.answer'   => 'required|string',
        ];

        $messages = [
            'questions.*.question.required' => 'Please enter a question for all items.',
            'questions.*.answer.required'   => 'Please enter an answer for all questions.',
        ];

        if ($allEmpty) {
            $rules['faq_id'] = 'required|exists:faqs,faq_id';
            $messages['faq_id.required'] = 'Please select a valid FAQ.';
            $messages['faq_id.exists'] = 'The selected FAQ does not exist.';
        }

        $this->validate($rules, $messages);

        foreach ($this->questions as $item) {
            if (empty(trim($item['question'])) && empty(trim($item['answer']))) {
                continue;
            }

            ParkFaq::create([
                'park_id' => $this->type->id,
                'question' => ucwords($item['question']),
                'answer' => $item['answer'],
            ]);
        }

        $this->showForm = false;
        $this->resetValidation();
        $this->resetData();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Faq saved successfully.'
        ]);
    }

    public function resetData()
    {
        $this->questions = [];
        $this->faq_id = '';
    }

    public function updatedFaqId($id)
    {
        if ($id) {
            $faq = Faq::find($id);
            if ($faq) {
                $this->questions[] = [
                    'question' => $faq->question,
                    'answer'   => $faq->answer,
                    'readonly' => false,
                ];
                $this->faq_id = '';
            }
        }
    }

    public function addQuestion()
    {
        $this->questions[] = ['question' => '', 'answer' => ''];
    }

    public function confirmDelete($id, $type = 'delete')
    {
        $this->deleteId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'action' => $type
        ]);
    }

    #[On('delete')]
    public function delete()
    {
        ParkFaq::destroy($this->deleteId);
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => 'Deleted',
            'message' => 'Faq deleted successfully.'
        ]);
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }
}
