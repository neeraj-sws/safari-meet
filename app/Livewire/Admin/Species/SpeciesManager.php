<?php

namespace App\Livewire\Admin\Species;

use App\Models\{
<<<<<<< HEAD
    Species
=======
    Species,
    SpeciesThreatModel,
    SpeciesPhysicalAppereancesModel,
    SpeciesOverviewModel,
    SpeciesLifestyleModel,
    SpeciesInterestingFactsModel,
    DietModel,
    SpeciesDetailsDynamicTabs,
    SpeciesDetailsCharactersticModel,
    AdaptationModel
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
};

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class SpeciesManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $showModal = false, $isEditing = false, $editId, $deleteId, $previousImage, $display_image, $banner_image, $previousBannerImage;
    public $modalTitle = 'Add', $pageTitle = 'Species';
    public $search = '';
    public $name;
    public function render()
    {
        $species = Species::where('name', 'like', "%{$this->search}%")->orderBy('updated_at', 'desc')
            ->latest()->paginate(10);
        return view('livewire.admin.species.species-manager', compact('species'));
    }

    public function resetFilter()
    {
        $this->reset(['search']);
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->resetFields();
        $this->modalTitle = 'Add ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        $path = 'uploads/species';


        // $displayOrigPath = $this->display_image->store($path, 'public_root');
        // $displayImagePath = ImageHelper::convertToAvif($displayOrigPath, $path);
         $displayImagePath = ImageUploadHelper::upload($this->display_image, $path);


        // $bannerOrigPath = $this->banner_image->store($path, 'public_root');
        // $bannerImagePath = ImageHelper::convertToAvif($bannerOrigPath, $path);
        $bannerImagePath = ImageUploadHelper::upload($this->banner_image, $path);


        $baseSlug = Str::slug($this->name);
        $slug = $baseSlug;
        $counter = 1;
        while (Species::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }


        $species = Species::create([
            'name' => $this->name,
            'slug' => $slug,
            'display_image' => $displayImagePath,
            'banner_image' => $bannerImagePath,
            'status' => false,
        ]);


        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' Added Successfully'
        ]);

        $this->showModal = false;
        $this->resetFields();

        return redirect()->route('admin.species.add-species', $species->uuid);
    }


    public function edit($id)
    {
        $this->resetValidation();
        $this->resetFields();
        $species = Species::findOrFail($id);

        $this->name = $species->name;
        $this->previousImage = $species->display_image;
        $this->previousBannerImage = $species->banner_image;

        $this->editId = $species->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();
        $species = Species::findOrFail($this->editId);
        $path = 'uploads/species';
        if (($this->display_image)) {
            // if ($this->previousImage && file_exists(public_path($this->previousImage))) {
            //     @unlink(public_path($this->previousImage));
            // }
            ImageUploadHelper::delete($species->display_image);
            // $image = $this->display_image;
            // $origPath = $image->store($path, 'public_root');

            // $avifPath = '';
            // $avifPath = ImageHelper::convertToAvif($origPath, $path);
            // $imagePath = $avifPath;
            $imagePath = ImageUploadHelper::upload($this->display_image, $path);
        } else {
            $imagePath = $this->previousImage;
        }
        if (($this->banner_image)) {

            // if ($this->previousBannerImage && file_exists(public_path($this->previousBannerImage))) {
            //     @unlink(public_path($this->previousBannerImage));
            // }
            // $image = $this->banner_image;
            // $path = 'uploads/species';
            // $origPath = $image->store($path, 'public_root');

            // $avifPath = '';
            // $avifPath = ImageHelper::convertToAvif($origPath, $path);
            // $bannerimagePath = $avifPath;
                ImageUploadHelper::delete($species->banner_image);
             $bannerimagePath = ImageUploadHelper::upload($this->banner_image, $path);
        } else {
            $bannerimagePath = $this->previousBannerImage;
        }
        if ($species->name !== $this->name) {
            $baseSlug = Str::slug($this->name);
            $slug = $baseSlug;
            $counter = 1;
            while (Species::where('slug', $slug)->where('Species_id', '!=', $species->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
        } else {
            $slug = $species->slug;
        }

        $species->update([
            'name' => $this->name,
            'slug' => $slug,
            'display_image' => $imagePath,
            'banner_image' => $bannerimagePath,
        ]);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Updated Successfully']);
        $this->showModal = false;
        $this->isEditing = false;
        $this->resetFields();
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
        Species::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }

    public function resetFields()
    {
        $this->reset(
            'name',
            'editId',
            'display_image',
            'previousImage',
            'deleteId',
            'banner_image',
            'previousBannerImage'
        );
    }
    public function toggleStatus($id)
    {
        $species = Species::findOrFail($id);
        $species->status = !$species->status;
        $species->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    public function toggleStatusToSpecies($id)
    {
        $species = Species::findOrFail($id);
        $species->top_species = !$species->top_species;
        $species->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Name cannot have leading or trailing spaces.');
                    }
                },
            ],
            'display_image' => ($this->editId && !empty($this->previousImage))
<<<<<<< HEAD
                ? 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:15360'
                : 'required|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:15360',

            'banner_image' => ($this->editId && !empty($this->previousBannerImage))
                ? 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:15360'
                : 'required|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:15360',
=======
                ? 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:5120'
                : 'required|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:5120',

            'banner_image' => ($this->editId && !empty($this->previousBannerImage))
                ? 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:5120'
                : 'required|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:5120',
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Name is required.',
            'name.string' => 'The Name must be a valid string.',
            'name.min' => 'The Name must be at least 3 characters long.',
            'name.max' => 'The Name may not be greater than 100 characters.',
            'name.regex' => 'The Name may only contain letters and spaces between words.',

<<<<<<< HEAD
            'display_image.max' => 'The display image must not be greater than 15 MB.',
            'banner_image.max'  => 'The banner image must not be greater than 15 MB.',
=======
            'display_image.max' => 'The display image must not be greater than 5 MB.',
            'banner_image.max'  => 'The banner image must not be greater than 5 MB.',
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        ];
    }


    public function removeDisplayImage(): void
    {
<<<<<<< HEAD
        $this->clearTemporaryUpload('display_image');
    }

    public function removeBannerImage(): void
    {
        $this->clearTemporaryUpload('banner_image');
    }

    public function removeOverViewImage(): void
    {
        $this->removeDisplayImage();
    }

    private function clearTemporaryUpload(string $property): void
    {
        $file = $this->{$property};

        if ($file && method_exists($file, 'delete')) {
            $file->delete();
        }

        $this->{$property} = null;
        $this->resetValidation($property);
=======
        if ($this->display_image) {
            $this->display_image->delete();
        }
        $this->display_image = null;
    }
    public function removeBannerImage()
    {
        if ($this->banner_image) {
            $this->banner_image->delete();
        }
        $this->banner_image = null;
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
    }
}
