<?php

namespace App\Livewire\Admin\Park\Details\TravelTips;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\ParkWhatToCarryModel;
use App\Models\ThingsToCarry;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class WhatToCarry extends Component
{
    use WithPagination, WithFileUploads;

    public $park, $characterDetails;
    public $showForm = false, $showEditForm = false;
    public $FormList = [], $thingsToCarries = [], $whattocarry = [];
    public $heading, $short_description, $image, $previousImage, $whatToCarryId;
    public $deleteId = null;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->thingsToCarries = ThingsToCarry::get();
    }

    public function render()
    {
        $bestWhatToCarry = ParkWhatToCarryModel::where('park_id', $this->park->id)->latest()->paginate(10);
        return view('livewire.admin.park.details.travel-tips.what-to-carry', compact('bestWhatToCarry'));
    }

    public function showToCarry()
    {
        $this->showForm = true;
        $this->FormList = [];
    }

    public function hideToCarry()
    {
        $this->showForm = false;
        $this->reset(['heading', 'short_description', 'image']);
    }

    #[On('icon-selected')]
    public function updateIcon($data)
    {
        $this->{$data['field']} = $data['value'];
    }

    public function storeWhatToCarry()
    {
        $this->validate([
            'FormList.*.heading' => 'required|string|max:255',
            'FormList.*.short_description' => 'required|string|max:500',
        ], [
            'FormList.*.heading.required' => 'The heading field is required.',
            'FormList.*.short_description.required' => 'The short description field is required.',
        ]);

        foreach ($this->FormList as $item) {
            ParkWhatToCarryModel::create([
                'park_id' => $this->park->id ?? null,
                'heading' => $item['heading'],
                'short_description' => $item['short_description'],
                'image' => $item['image'] ?? null,
            ]);
        }

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'What To Carry Added Successfully',
        ]);

        $this->reset(['FormList', 'whattocarry']);
        $this->showForm = false;
    }

    public function EditWhatToCarry($id)
    {
        $item = ParkWhatToCarryModel::find($id);
        if (!$item)
            return;

        $this->heading = $item->heading;
        $this->short_description = $item->short_description;
        $this->previousImage = $item->image;
        $this->whatToCarryId = $item->id;
        $this->showEditForm = true;
    }

    public function updateWhatToCarry()
    {
        $this->validate([
            'heading' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
<<<<<<< HEAD
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',
        ], [
            'image.max' => 'The banner image must not be greater than 15 MB.',
=======
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'image.max' => 'The banner image must not be greater than 5 MB.',
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        ]);

        $item = ParkWhatToCarryModel::find($this->whatToCarryId);
        if (!$item)
            return;

        $item->heading = $this->heading;
        $item->short_description = $this->short_description;

        if ($this->image) {
            // $origPath = $this->image->store('uploads/thing-to-carry', 'public_root');
            // $imagePath = ImageHelper::convertToAvif($origPath, 'uploads/thing-to-carry');

            // if (!empty($this->previousImage) && file_exists(public_path($this->previousImage))) {
            //     @unlink(public_path($this->previousImage));
            // }
            ImageUploadHelper::delete($this->previousImage);
            $imagePath = ImageUploadHelper::upload($this->image, 'uploads/park/thing-to-carry');
        } else {
            $imagePath = $this->previousImage;
        }

        $item->image = $imagePath;
        $item->save();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Updated successfully!',
        ]);

        $this->closeEditModal();
    }

    public function closeEditModal()
    {
        $this->reset(['heading', 'short_description', 'image', 'previousImage', 'whatToCarryId']);
        $this->showEditForm = false;
    }

    public function updatedWhattocarry()
    {
        $existingIds = collect($this->FormList)->pluck('id')->all();
        $newIds = array_diff($this->whattocarry, $existingIds);

        if (!empty($newIds)) {
            $newThings = ThingsToCarry::whereIn('things_to_carry_id', $newIds)->get();

            foreach ($newThings as $carry) {
                array_unshift($this->FormList, [
                    'heading' => $carry->title,
                    'short_description' => $carry->short_description,
                    'id' => $carry->id,
                    'image' => $carry->image,
                ]);
            }
        }

        $this->FormList = array_values(array_filter($this->FormList, function ($item) {
            return empty($item['id']) || in_array($item['id'], $this->whattocarry);
        }));
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
            'action' => 'deleteConfirmed',
        ]);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $item = ParkWhatToCarryModel::find($this->deleteId);
        if ($item) {
            $item->delete();
            $this->dispatch('swal:toast', [
                'type' => 'success',
                'message' => 'Item deleted successfully!',
            ]);
        } else {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'message' => 'Item not found!',
            ]);
        }
        $this->deleteId = null;
    }

    public function AddBlankFormList()
    {
        array_unshift($this->FormList, [
            'heading' => '',
            'short_description' => '',
            'id' => '',
            'image' => '',
        ]);
    }

    public function removeImage()
    {
        $this->image = null;
    }

    public function removeFormList($index)
    {
        if (isset($this->FormList[$index])) {
            $idToRemove = $this->FormList[$index]['id'] ?? null;

            if ($idToRemove !== null) {
                $this->whattocarry = array_filter($this->whattocarry, function ($id) use ($idToRemove) {
                    return $id != $idToRemove;
                });
            }
            unset($this->FormList[$index]);
            $this->FormList = array_values($this->FormList);
            $this->whattocarry = array_values($this->whattocarry);
        }
    }
}
