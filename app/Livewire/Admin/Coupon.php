<?php

namespace App\Livewire\Admin;

use App\Models\Coupon as CouponModel;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component, WithPagination};


#[Layout('components.layouts.admin-app')]
class Coupon extends Component
{
    use WithPagination;

    public $itemId;
    public $coupon_code, $start_date, $end_date, $amount, $status, $search = '';
    public $isEditing = false;
    public $pageTitle = 'Coupons';

    public $model = CouponModel::class;

    public function mount() {}

    public function rules()
    {
        $table = (new $this->model)->getTable();

        return [
            'coupon_code' => $this->isEditing
                ? 'required|string|max:50|unique:' . $table . ',coupon_code,' . $this->itemId . ',coupon_id'
                : 'required|string|max:50|unique:' . $table . ',coupon_code',

            'start_date' => 'required',
            'end_date' => 'required',
            'amount' => 'required',
        ];
    }
    public function render()
    {
        $items = $this->model::query()
            ->when(
                $this->search,
                fn($q) =>
                $q->where('coupon_code', 'like', "%{$this->search}%")
            )
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.coupon', compact('items'));
    }

    public function store()
    {
        $this->validate($this->rules());

        $this->model::create([
            'coupon_code' => $this->coupon_code,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'amount' => $this->amount,
            'status'=>1,
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
        $this->coupon_code = $item->coupon_code;
        $this->start_date = $item->start_date;
        $this->end_date = $item->end_date;
        $this->status = $item->status;
        $this->amount = $item->amount;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate($this->rules());

        $this->model::findOrFail($this->itemId)->update([
            'coupon_code' => $this->coupon_code,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'amount' => $this->amount,
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
        $this->model::destroy($this->itemId);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' deleted successfully!'
        ]);
    }

    public function resetForm()
    {
        $this->reset([
            'coupon_code',
            'start_date',
            'end_date',
            'status',
            'amount'
        ]);
        $this->resetValidation();
    }

    public function toggleStatus($id)
    {
        $model = $this->model::findOrFail($id);
        $model->status = !$model->status;
        $model->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    public function updating()
    {
        $this->resetPage();
    }
}
