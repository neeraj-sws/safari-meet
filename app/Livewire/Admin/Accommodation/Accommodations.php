<?php

namespace App\Livewire\Admin\Accommodation;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\Accommodation as Model;
use App\Models\AccommodationAmenity;
use App\Models\AccommodationImage;
use App\Models\ParkAccommodation;
use App\Models\SafariAccommodation;
use App\Models\Amenity;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\StayCategory;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component, WithFileUploads, WithPagination};

#[Layout('components.layouts.admin-app')]
class Accommodations extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $itemId;
    public $title, $icon, $search = '', $StayCategories = [], $states = [], $cities = [], $countries = [], $amenities = [], $country_id, $category_id, $state, $city, $amenity = [], $rating;
    public $images = [], $uploadedImages = [], $time;
    public $isEditing = false;

    public $pageTitle = 'Accommodations';
    public $model = Model::class;
    public $view = 'livewire.admin.accommodation.accommodations';

    public function mount()
    {
        $this->StayCategories = StayCategory::all()->pluck('name', 'id');
        $this->countries = Country::orderByRaw("CASE WHEN name = 'India' THEN 0 ELSE 1 END")
            ->orderBy('name', 'asc')
            ->pluck('name', 'country_id');
        $this->amenities = Amenity::all()->pluck('title', 'id');
    }

    public function render()
    {
        $items = $this->model::with(['category', 'cuntry', 'state', 'city'])->orderBy('updated_at', 'desc')
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->paginate(10);

        return view($this->view, compact('items'));
    }

    public function rules()
    {
        $StayCategory = (new StayCategory)->getKeyName();
        $Country = (new Country)->getKeyName();
        $State = (new State)->getKeyName();
        $City = (new City)->getKeyName();

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Title cannot have leading or trailing spaces.');
                    }
                },
            ],
            'category_id' => ['required', "exists:stay_categories,$StayCategory"],
            'country_id' => ['required', "exists:countries,$Country"],
            'state' => ['required', "exists:states,$State"],
            'city' => ['required', "exists:cities,$City"],
            'amenity' => ['required', 'array', 'min:1'],
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
        ];
    }

    public function resetForm()
    {
        $this->reset(['title', 'category_id', 'country_id', 'city', 'rating', 'state', 'itemId', 'isEditing', 'amenity', 'uploadedImages']);
        $this->resetValidation();
    }



    public function store()
    {
        $this->validate($this->rules());

        if (count($this->uploadedImages) != 5) {

            return $this->dispatch('swal:toast', [
                'type' => 'info',
                'title' => '',
                'message' => ' You can upload a 5 images.'
            ]);
        }

        $accommodation = $this->model::create([
            'title' => $this->title,
            'category_id' => $this->category_id,
            'country_id' => $this->country_id,
            'state_id' => $this->state,
            'city_id' => $this->city,
            'rating' => $this->rating,
        ]);

        foreach ($this->amenity as $item) {
            AccommodationAmenity::create([
                'amenity_id' => $item,
                'accommodation_id' => $accommodation->id,
            ]);
        }

        AccommodationImage::whereIn('image', $this->uploadedImages)
            ->update(['accommodation_id' => $accommodation->id]);

        $this->resetForm();
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Accommodation Added Successfully'
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

        $item = $this->model::with('amenity', 'image')->findOrFail($id);

        $this->itemId = $item->id;
        $this->title = $item->title;
        $this->category_id = $item->category_id;
        $this->country_id = $item->country_id;
        $this->state = $item->state_id;
        $this->city = $item->city_id;
        $this->rating = $item->rating;

        $this->amenity = collect($item->amenity)->pluck('amenity_id')->toArray();
        $this->uploadedImages = collect($item->image)->pluck('image')->toArray();

        $this->updatedCountryId();
        $this->updatedState();
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate($this->rules());

        $accommodation = $this->model::findOrFail($this->itemId);
        $accommodation->update([
            'title' => $this->title,
            'category_id' => $this->category_id,
            'country_id' => $this->country_id,
            'state_id' => $this->state,
            'city_id' => $this->city,
            'rating' => $this->rating,
        ]);

        AccommodationAmenity::where('accommodation_id', $accommodation->id)->delete();
        foreach ($this->amenity as $item) {
            AccommodationAmenity::create([
                'amenity_id' => $item,
                'accommodation_id' => $accommodation->id,
            ]);
        }

        AccommodationImage::whereIn('image', $this->uploadedImages)
            ->update(['accommodation_id' => $accommodation->id]);

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
        $accommodation = $this->model::findOrFail($this->itemId);


        $isInSafari = SafariAccommodation::where('accommodation_id', $accommodation->id)->exists();
        $isInPark = ParkAccommodation::where('accommodation_id', $accommodation->id)->exists();

        if ($isInSafari || $isInPark) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'message' => 'Cannot delete accommodation. It is linked to Safari or Park accommodations.'
            ]);
            return;
        }

        AccommodationAmenity::where('accommodation_id', $accommodation->id)->delete();


        $images = AccommodationImage::where('accommodation_id', $accommodation->id)->get();
        foreach ($images as $img) {
            // if (file_exists(public_path($img->image))) {
            //     unlink(public_path($img->image));
            // }
             ImageUploadHelper::delete($img->image);
            $img->delete();
        }

        $accommodation->delete();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Accommodation deleted successfully!'
        ]);
    }


    public function updatedCountryId()
    {
        $this->states = State::where('country_id', $this->country_id)->pluck('name', 'state_id');
    }

    public function updatedState()
    {
        $this->cities = City::where('state_id', $this->state)->pluck('name', 'city_id');
    }

    public function updatedImages()
    {
        $this->time = time();

        $totalImages = count($this->uploadedImages) + count($this->images);
        if ($totalImages > 5) {
            $this->reset('images');
            $this->dispatch('swal:toast', [
                'type' => 'info',
                'title' => '',
                'message' => ' You can upload a maximum of 5 images.'
            ]);
            return;
        }

        $this->validate([
            'images.*' => 'image',
        ]);

        foreach ($this->images as $image) {
            try {
                // $origPath = $image->store('uploads/accommodations/', 'public_root');
                // $imagePath = ImageHelper::convertToAvif($origPath, 'uploads/accommodations/');
                $imagePath = ImageUploadHelper::upload($image, 'uploads/accommodations');

                AccommodationImage::create([
                    'time' => $this->time,
                    'image' => $imagePath,
                ]);

                $this->uploadedImages[] = $imagePath;
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage());
            }
        }

        $this->reset('images');
    }


    public function removeUploadedImage($index)
    {
        $path = $this->uploadedImages[$index] ?? null;

        if ($path) {
            AccommodationImage::where('image', $path)->delete();
            // if (file_exists(public_path($path))) {
            //     unlink(public_path($path));
            // }
            ImageUploadHelper::delete($path);
            unset($this->uploadedImages[$index]);
            $this->uploadedImages = array_values($this->uploadedImages);
        }
    }
}
