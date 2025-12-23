<?php

namespace App\Livewire\Admin;

use App\Models\WeatherModel as Model;
use App\Models\ParkBestTimeModel;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component, WithPagination};
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

#[Layout('components.layouts.admin-app')]
class weatherComponent extends Component
{
    use WithPagination;

    public $itemId;
    public $title, $search = '', $end_date, $start_date;
    public $isEditing = false;
    public $pageTitle = 'Weather';

    public $model = Model::class;
    public $view = 'livewire.admin.weather';

    public function rules()
    {
        $table = (new $this->model)->getTable();

        return [
            'title' => array_merge(
                [
                    'required',
                    'string',
                    'max:50',
                    function ($attribute, $value, $fail) {
                        if (trim($value) !== $value) {
                            $fail('Title cannot have leading or trailing spaces.');
                        }
                    }
                ],
                $this->isEditing
                    ? [Rule::unique($table, 'title')->ignore($this->itemId,'park_weather_id')]
                    : [Rule::unique($table, 'title')]
            ),
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }


    public function render()
    {
        $items = $this->model::where(function ($query) {
            $query->where('title', 'like', "%{$this->search}%");
        })->orderBy('updated_at', 'desc')
            ->latest()->paginate(10);

        return view($this->view, compact('items'));
    }



    public function store()
    {
        $this->validate($this->rules());

        $this->model::create([
            'title' => $this->title,
            'start' => $this->start_date,
            'end' => $this->end_date,
            'status' => true,
        ]);

        $this->resetForm();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' Added Successfully'
        ]);
    }

    public function edit($id)
    {

        $this->resetForm();
        $item = $this->model::findOrFail($id);

        $this->itemId = $item->id;
        $this->title = $item->title;
        $this->start_date = $item->start;
        $this->end_date = $item->end;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate($this->rules());

        $this->model::findOrFail($this->itemId)->update([
            'title' => $this->title,
            'start' => $this->start_date,
            'end' => $this->end_date,
        ]);

        $this->resetForm();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' Updated Successfully'
        ]);
    }

    public function confirmDelete($id)
    {
        $this->itemId = $id;

        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'delete'
        ]);
    }

    #[On('delete')]
    public function delete()
    {

        $exists = ParkBestTimeModel::where('weathers_id', $this->itemId)->exists();

        if ($exists) {

            $this->dispatch('swal:toast', [
                'type' => 'warning',
                'title' => '',
                'message' => 'Cannot delete. This data is used in Park.'
            ]);
            return;
        }

        $this->model::destroy($this->itemId);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' deleted successfully!'
        ]);
    }

    public function resetForm()
    {
        $this->reset(['title', 'start_date', 'end_date', 'itemId', 'isEditing']);
        $this->resetValidation();
    }
    
      public function updating()
    {
        $this->resetPage();
    }
}
