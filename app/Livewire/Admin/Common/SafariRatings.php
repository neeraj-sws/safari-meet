<?php

namespace App\Livewire\Admin\Common;

use App\Models\ParkSafariType;
use App\Models\SafariRating;
use App\Models\SafariRatingHeading;
use Illuminate\Support\Composer;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SafariRatings extends Component
{
    use WithPagination;

    public $type, $model;
    public $showFormSection = false;
    public $Heading = [], $safari_types = [], $FormList = [], $PriceMatrix = [], $deleteId;

    protected $paginationTheme = 'bootstrap';

    public function mount($type, $model)
    {
        abort_if(empty($type) || empty($model), 404);

        $this->type = $type;
        $this->model = $model;
    }


    public function render()
    {
        $column = ($this->type == 1) ? 'share_safari_id' : 'package_id';
        $columnValue = $this->model->id;

        $ratings = SafariRating::where($column, $columnValue)
            ->with(['safariType.safari_type', 'heading'])
            ->orderBy('safari_ratings_id', 'desc')
            ->paginate(10);

        return view('livewire.admin.common.safari-ratings', compact('ratings'));
    }

    public function showForm()
    {
        $column = ($this->type == 1) ? 'share_safari_id' : 'package_id';

        $this->Heading = SafariRatingHeading::where($column, $this->model->id)->get();
        if (count($this->Heading) <= 0) {
            return $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => 'Check the heading. Add headings first!',
            ]);
        }

        $this->FormList = $this->Heading->map(fn($heading) => [
            'heading_label' => $heading->heading_label,
            'id' => $heading->id,
        ])->toArray();

        $this->safari_types = ParkSafariType::with('safari_type')->where('park_id', $this->model->park_id)->get();

        $columnValue = $this->model->id;
        $existingRatings = SafariRating::where($column, $columnValue)->get();

        $this->PriceMatrix = [];

        foreach ($existingRatings as $rating) {
            $this->PriceMatrix[$rating->safari_type_id][$rating->safari_rating_heading_id] = $rating->price;
        }

        $this->showFormSection = true;
    }


    public function hideForm()
    {
        $this->showFormSection = false;
    }


    public function store()
    {
        $rules = [];

        foreach ($this->safari_types as $type) {
            foreach ($this->FormList as $heading) {
                $rules["PriceMatrix.{$type->id}.{$heading['id']}"] = [
                    'required',
                    'numeric',
                    'min:0',
                    'max:999999',
                    function ($attribute, $value, $fail) {
                        if (trim($value) !== $value) {
                            $fail("Cannot have leading or trailing spaces.");
                        }
                    },
                ];
            }
        }

        $messages = [
            'required' => 'This field is required.',
            'numeric' => 'The price must be a number.',
            'min' => 'The price must be at least 0.',
            'max' => 'The price may not be greater than :max.',
        ];

        $this->validate($rules, $messages);

        $column = ($this->type == 1) ? 'share_safari_id' : 'package_id';
        $columnValue = $this->model->id;

        try {
            foreach ($this->PriceMatrix as $safariTypeId => $headings) {
                foreach ($headings as $headingId => $price) {
                    if ($price === null || $price === '') continue;

                    SafariRating::updateOrCreate(
                        [
                            $column => $columnValue,
                            'safari_type_id' => $safariTypeId,
                            'safari_rating_heading_id' => $headingId,
                        ],
                        [
                            'price' => $price,
                        ]
                    );
                }
            }

            $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => 'Saved successfully!',
            ]);

            $this->PriceMatrix = [];
            $this->showFormSection = false;
        } catch (\Exception $e) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'An error occurred while saving: ' . $e->getMessage(),
            ]);
        }
    }


    public function confirmDelete($id)
    {
        $this->deleteId = $id;
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
        try {
            $rating = SafariRating::findOrFail($this->deleteId);
            $rating->delete();

            $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => 'Rating deleted successfully!',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => 'Not Found',
                'message' => 'Rating not found or already deleted.',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'An unexpected error occurred while deleting.',
            ]);
        }
    }
}
