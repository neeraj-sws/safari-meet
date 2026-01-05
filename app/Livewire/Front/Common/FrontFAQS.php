<?php

namespace App\Livewire\Front\Common;

use App\Models\{SafariFaq, Faq};
use Livewire\Attributes\On;
use Livewire\Component;

class FrontFAQS extends Component
{
    public $data = [], $modalTitle, $faqs = [], $packageId, $shareSafariId,
           $questions = [], $faq_id, $type, $deleteId, $showForm = false;

    public function mount($type, $id)
    {
        if ($type == 2) {
            $this->packageId = $id;
        } elseif ($type == 1) {
            $this->shareSafariId = $id;
        }
        $this->type = $type;
    }

    public function render()
    {
        $query = SafariFaq::query();

        if ($this->packageId) {
            $query->where('package_id', $this->packageId);
        }
        if ($this->shareSafariId) {
            $query->where('share_safari_id', $this->shareSafariId);
        }

        $this->data = $query->get()->toArray();

        return view('livewire.front.common.front-f-a-q-s');
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
        $allEmpty = collect($this->questions)->every(fn($item) =>
            empty(trim($item['question'])) && empty(trim($item['answer']))
        );

        $rules = [
            'questions.*.question' => 'required|string',
            'questions.*.answer'   => 'required|string',
        ];

        if ($allEmpty) {
            $rules['faq_id'] = 'required|exists:faqs,id';
        }

        $this->validate($rules);

        foreach ($this->questions as $item) {
            if (empty(trim($item['question'])) && empty(trim($item['answer']))) {
                continue;
            }

            SafariFaq::create([
                'package_id'      => $this->packageId,
                'share_safari_id' => $this->shareSafariId,
                'question'        => $item['question'],
                'answer'          => $item['answer'],
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
        SafariFaq::destroy($this->deleteId);
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
