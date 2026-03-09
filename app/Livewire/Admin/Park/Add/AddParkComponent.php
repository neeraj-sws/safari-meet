<?php

namespace App\Livewire\Admin\Park\Add;

use App\Helpers\ImageUploadHelper;
use App\Models\City;
use App\Models\Country;
use Livewire\Component;
use App\Models\Park;
use App\Models\State;
use App\Models\Species;
use App\Models\WeatherModel;
use App\Helpers\ImageHelper;
use App\Models\ParkBestTimeModel;
use App\Models\ParkDetail;
use App\Models\ParkSafariType;
use App\Models\ParkWildlifeFoundModel;
use App\Models\SafariType;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('components.layouts.admin-app')]
class AddParkComponent extends Component
{
    use WithFileUploads;

    public $pageTitle = 'Add Park';
    public $park_name, $short_description, $description,
    $city_id, $state_id, $country_id, $area, $established, $famous_for,
    $best_time, $core_zone, $buffer_zone, $entry_gates, $nearest_railway,
    $afternoon_time, $morning_time, $safariType = [], $wildlife_found = [],
    $core_zone_price, $buffer_zone_price, $best_time_visit = [],
    $data_image, $previousImage, $park_id, $banner_title;

    public $countries = [], $states = [], $cities = [], $wildlives, $BestTimeVisit, $safari_types;
    public $showModal = false, $isEditing = false, $EditID, $previousBannerImage, $banner_image;

    protected function rules()
    {
        return [
            'park_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Park Name cannot have leading or trailing spaces.');
                    }
                },
            ],
            'established' => 'required|date_format:Y-m-d',

            'core_zone' => [
                'required',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Core Zone cannot have leading or trailing spaces.');
                    }
                },
            ],

            'buffer_zone' => [
                'required',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Buffer Zone cannot have leading or trailing spaces.');
                    }
                },
            ],

            'core_zone_price' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim($value) !== $value) {
                        $fail('Core Zone Price cannot have leading or trailing spaces.');
                    }
                },
            ],

            'buffer_zone_price' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim($value) !== $value) {
                        $fail('Buffer Zone Price cannot have leading or trailing spaces.');
                    }
                },
            ],

            'short_description' => [
                'required',
                'string',
                'min:3',
                'max:115',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Short Description cannot have leading or trailing spaces.');
                    }
                },
            ],

            'safariType' => 'required',
            'wildlife_found' => 'required',
            'area' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Area cannot have leading or trailing spaces.');
                    }
                },
            ],

            'famous_for' => [
                'required',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Famous For cannot have leading or trailing spaces.');
                    }
                },
            ],

            'entry_gates' => [
                'nullable',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim($value) !== $value) {
                        $fail('Entry Gates cannot have leading or trailing spaces.');
                    }
                },
            ],

            'country_id' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',

            'nearest_railway' => [
                'required',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Nearest Railway cannot have leading or trailing spaces.');
                    }
                },
            ],

            'afternoon_time' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Afternoon Time cannot have leading or trailing spaces.');
                    }
                },
            ],

            'morning_time' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Morning Time cannot have leading or trailing spaces.');
                    }
                },
            ],

            'banner_title' => [
                'required',
                'string',
                'min:3',
                'max:50',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Banner Title cannot have leading or trailing spaces.');
                    }
                },
            ],

            'data_image' => ($this->isEditing && !empty($this->previousImage))
<<<<<<< HEAD
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:15360',

            'banner_image' => ($this->isEditing && !empty($this->previousBannerImage))
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:15360',
=======
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:5120',

            'banner_image' => ($this->isEditing && !empty($this->previousBannerImage))
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        ];
    }


    protected function messages()
    {
        return [

            'park_name.required' => 'The Park Name is required.',
            'park_name.string' => 'The Park Name must be a valid string.',
            'park_name.min' => 'The Park Name must be at least 3 characters.',
            'park_name.max' => 'The Park Name may not be greater than 100 characters.',
            'park_name.regex' => 'The Park Name can only contain alphabets and single spaces between words.',

            'established.required' => 'The established date is required.',
            'established.date_format' => 'The established date must be in the format: YYYY-MM-DD.',

            'core_zone.required' => 'The Core Zone is required.',
            'core_zone.regex' => 'The Core Zone can only contain alphabets, commas, and spaces.',
            'core_zone.max' => 'The Core Zone may not be greater than 100 characters.',

            'buffer_zone.required' => 'The Buffer Zone is required.',
            'buffer_zone.regex' => 'The Buffer Zone can only contain alphabets, commas, and spaces.',
            'buffer_zone.max' => 'The Buffer Zone may not be greater than 100 characters.',

            'core_zone_price.regex' => 'The Core Zone Price can only contain letters, numbers, and the characters: -, $, ₹, and ,.',

            'buffer_zone_price.regex' => 'The Buffer Zone Price can only contain letters, numbers, and the characters: -, $, ₹, and ,.',

            'short_description.required' => 'The Short Description is required.',
            'short_description.string' => 'The Short Description must be a valid string.',
            'short_description.min' => 'The Short Description must be at least 3 characters.',
            'short_description.max' => 'The Short Description may not be greater than 110 characters.',
            'short_description.regex' => 'The Short Description can only contain alphabets, spaces, commas, periods, and apostrophes.',

            'safariType.required' => 'The Safari Type is required.',

            'wildlife_found.required' => 'The Wildlife Found information is required.',

            'entry_gates.regex' => 'The Entry Gates can only contain alphabets, commas, and spaces.',
            'entry_gates.max' => 'The Entry Gates may not be greater than 100 characters.',

            'country_id.required' => 'The Country ID is required.',
            'country_id.integer' => 'The Country ID must be a valid number.',

            'city_id.required' => 'The City ID is required.',
            'city_id.integer' => 'The City ID must be a valid number.',

            'state_id.required' => 'The State ID is required.',
            'state_id.integer' => 'The State ID must be a valid number.',

            'nearest_railway.regex' => 'The Nearest Railway can only contain alphabets, commas, and spaces.',
            'nearest_railway.max' => 'The Nearest Railway may not be greater than 100 characters.',

            'afternoon_time.required' => 'The Afternoon Time is required.',
            'afternoon_time.regex' => 'The Afternoon Time can only contain letters, numbers, and the characters: -, /, |, :, ;.',

            'morning_time.required' => 'The Morning Time is required.',
            'morning_time.regex' => 'The Morning Time can only contain letters, numbers, and the characters: -, /, |, :, ;.',

            'banner_title.required' => 'The Banner Title is required.',
            'banner_title.string' => 'The Banner Title must be a valid string.',
            'banner_title.min' => 'The Banner Title must be at least 3 characters.',
            'banner_title.max' => 'The Banner Title may not be greater than 50 characters.',
            'banner_title.regex' => 'The Banner Title can only contain alphabets and single spaces between words.',

            'core_zone.*' => 'Core Zone cannot have leading or trailing spaces.',
            'buffer_zone.*' => 'Buffer Zone cannot have leading or trailing spaces.',
            'core_zone_price.*' => 'Core Zone Price cannot have leading or trailing spaces.',
            'buffer_zone_price.*' => 'Buffer Zone Price cannot have leading or trailing spaces.',
            'short_description.*' => 'Short Description cannot have leading or trailing spaces.',
            'area.*' => 'Area cannot have leading or trailing spaces.',
            'famous_for.*' => 'Famous For cannot have leading or trailing spaces.',
            'entry_gates.*' => 'Entry Gates cannot have leading or trailing spaces.',
            'nearest_railway.*' => 'Nearest Railway cannot have leading or trailing spaces.',
            'afternoon_time.*' => 'Afternoon Time cannot have leading or trailing spaces.',
            'morning_time.*' => 'Morning Time cannot have leading or trailing spaces.',
            'banner_title.*' => 'Banner Title cannot have leading or trailing spaces.',
            'park_name.*' => 'Park Name cannot have leading or trailing spaces.',
<<<<<<< HEAD
            'data_image.max' => 'The display image must not be greater than 15 MB.',
            'banner_image.max' => 'The banner image must not be greater than 15 MB.',
=======
            'data_image.max' => 'The display image must not be greater than 5 MB.',
            'banner_image.max' => 'The banner image must not be greater than 5 MB.',
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        ];
    }

    public function mount($id = null)
    {
        $this->EditID = $id;
        $this->countries = Country::orderByRaw("CASE WHEN name = 'India' THEN 0 ELSE 1 END")
            ->orderBy('name', 'asc')
            ->pluck('name', 'country_id');

        $this->wildlives = Species::where('status', true)->pluck('name', 'species_id');
        $this->BestTimeVisit = WeatherModel::where('status', true)->get();
        $this->safari_types = SafariType::where('status', true)->pluck('name', 'safari_type_id')->toArray();
        if (!empty($this->EditID)) {
            $this->pageTitle = 'Edit Park';
            $park = Park::findOrFail($this->EditID);

            $this->states = State::where('country_id', $park->country_id)->pluck('name', 'state_id');
            $this->cities = City::where('state_id', $park->state_id)->pluck('name', 'city_id');

            $this->safariType = ParkSafariType::where('park_id', $park->id)->pluck('safari_type_id')->toArray();
            $this->best_time_visit = ParkBestTimeModel::where('park_id', $park->id)->pluck('weathers_id')->toArray();
            $this->wildlife_found = ParkWildlifeFoundModel::where('park_id', $park->id)->pluck('species_id')->toArray();

            $this->park_name = $park->name;
            $this->short_description = $park->short_description;
            $this->city_id = $park->city_id;
            $this->state_id = $park->state_id;
            $this->country_id = $park->country_id;
            $this->area = $park->area;
            $this->established = $park->established;
            $this->famous_for = $park->famous_for;
            $this->core_zone = $park->core_zone;
            $this->buffer_zone = $park->buffer_zone;
            $this->core_zone_price = $park->core_zone_price;
            $this->buffer_zone_price = $park->buffer_zone_price;
            $this->entry_gates = $park->entry_gates;
            $this->nearest_railway = $park->nearest_railway;
            $this->morning_time = $park->morning_time;
            $this->afternoon_time = $park->afternoon_time;
            $this->previousImage = $park->display_image;
            $this->previousBannerImage = $park->banner_image;
            $this->description = $park->description;
            $this->banner_title = $park->banner_title;
            $this->park_id = $park->id;

            $this->isEditing = true;
        }
        $this->dispatch('init-datepicker', ['selector' => '.datepicker']);
    }

    public function render()
    {
        return view('livewire.admin.park.add.addpark');
    }

    public function resetFields()
    {
        $this->reset([
            'park_name',
            'area',
            'established',
            'famous_for',
            'description',
            'banner_title',
            'best_time',
            'short_description',
            'city_id',
            'state_id',
            'country_id',
            'core_zone',
            'buffer_zone',
            'core_zone_price',
            'buffer_zone_price',
            'best_time_visit',
            'safariType',
            'entry_gates',
            'nearest_railway',
            'afternoon_time',
            'morning_time',
            'wildlife_found',
            'data_image',
            'previousImage',
            'park_id',
            'isEditing',
            'banner_image',
            'previousBannerImage',
        ]);
    }

    public function store()
    {
        $this->validate();

        $path = 'uploads/park';
        // $origPath = $this->data_image->store($path, 'public_root');
        // $imagePath = ImageHelper::convertToAvif($origPath, $path);

        // $origPath = $this->banner_image->store($path, 'public_root');
        // $bannerimagePath = ImageHelper::convertToAvif($origPath, $path);
        $imagePath = ImageUploadHelper::upload($this->data_image, $path);
        $bannerimagePath = ImageUploadHelper::upload($this->banner_image, $path);

        $baseSlug = Str::slug($this->park_name);
        $slug = $baseSlug;
        $counter = 1;
        while (Park::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $park = Park::create([
            'name' => ucwords($this->park_name),
            'slug' => $slug,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'banner_title' => ucwords($this->banner_title),
            'city_id' => $this->city_id,
            'state_id' => $this->state_id,
            'country_id' => $this->country_id,
            'area' => $this->area,
            'established' => $this->established,
            'famous_for' => ucwords($this->famous_for),
            'core_zone' => ucwords($this->core_zone),
            'buffer_zone' => ucwords($this->buffer_zone),
            'core_zone_price' => $this->core_zone_price,
            'buffer_zone_price' => $this->buffer_zone_price,
            'entry_gates' => ucwords($this->entry_gates),
            'nearest_railway' => ucwords($this->nearest_railway),
            'morning_time' => $this->morning_time,
            'afternoon_time' => $this->afternoon_time,
            'display_image' => $imagePath,
            'banner_image' => $bannerimagePath,
        ]);

        foreach ($this->safariType as $type) {
            ParkSafariType::create([
                'park_id' => $park->id,
                'safari_type_id' => $type,
            ]);
        }
        foreach ($this->wildlife_found as $wildlife) {
            ParkWildlifeFoundModel::create([
                'park_id' => $park->id,
                'species_id' => $wildlife,
            ]);
        }
        foreach ($this->best_time_visit as $bestTime) {
            ParkBestTimeModel::create([
                'park_id' => $park->id,
                'weathers_id' => $bestTime,
            ]);
        }


        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
        $this->resetFields();
        return redirect()->route('admin.park.parkdetails', $park->uuid);
    }


    public function update()
    {
        $this->validate();
        $park = Park::findOrFail($this->park_id);

        $imagePath = $this->previousImage;
        $bannerimagePath = $this->previousBannerImage;

        $park->name = $this->park_name;
        $park->short_description = $this->short_description;
        $park->description = $this->description;
        $park->banner_title = $this->banner_title;
        $park->city_id = $this->city_id;
        $park->state_id = $this->state_id;
        $park->country_id = $this->country_id;
        $park->area = $this->area;
        $park->established = $this->established;
        $park->famous_for = $this->famous_for;
        $park->core_zone = $this->core_zone;
        $park->buffer_zone = $this->buffer_zone;
        $park->entry_gates = $this->entry_gates;
        $park->nearest_railway = $this->nearest_railway;
        $park->morning_time = $this->morning_time;
        $park->afternoon_time = $this->afternoon_time;
        $park->core_zone_price = $this->core_zone_price;
        $park->buffer_zone_price = $this->buffer_zone_price;

        if ($this->data_image) {
            // if (!empty($this->previousImage) && file_exists(public_path($this->previousImage))) {
            //     @unlink(public_path($this->previousImage));
            // }
            // $origPath = $this->data_image->store('uploads/park', 'public_root');
            // $imagePath = ImageHelper::convertToAvif($origPath, 'uploads/park');
            ImageUploadHelper::delete($this->previousImage);
            $imagePath = ImageUploadHelper::upload($this->data_image, 'uploads/par');
        }
        if ($this->banner_image) {
            // if (!empty($this->previousBannerImage) && file_exists(public_path($this->previousBannerImage))) {
            //     @unlink(public_path($this->previousBannerImage));
            // }
            // $origPath = $this->banner_image->store('uploads/park', 'public_root');
            // $bannerimagePath = ImageHelper::convertToAvif($origPath, 'uploads/park');
            ImageUploadHelper::delete($this->previousBannerImage);
            $bannerimagePath = ImageUploadHelper::upload($this->banner_image, 'uploads/par');
        }
        $park->display_image = $imagePath;

        $park->banner_image = $bannerimagePath;
        $park->save();

        ParkSafariType::where('park_id', $park->id)->delete();
        foreach ($this->safariType as $type) {
            ParkSafariType::create([
                'park_id' => $park->id,
                'safari_type_id' => $type,
            ]);
        }
        ParkWildlifeFoundModel::where('park_id', $park->id)->delete();
        foreach ($this->wildlife_found as $wildlife) {
            ParkWildlifeFoundModel::create([
                'park_id' => $park->id,
                'species_id' => $wildlife,
            ]);
        }
        ParkBestTimeModel::where('park_id', $park->id)->delete();
        foreach ($this->best_time_visit as $bestTime) {
            ParkBestTimeModel::create([
                'park_id' => $park->id,
                'weathers_id' => $bestTime,
            ]);
        }
        $this->isEditing = false;
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Updated Successfully']);
        $this->resetFields();
        return redirect()->route('admin.park.park');
    }

    public function removeDisplayImage()
    {
        $this->reset('data_image');
    }
    public function removeBannerImage()
    {
        $this->reset('banner_image');
    }

    public function updatedCountryId($value)
    {
        $this->states = State::where('country_id', $value)->pluck('name', 'state_id');
    }

    public function updatedStateId($value)
    {
        $this->cities = City::where('state_id', $value)->pluck('name', 'city_id');
    }

    public function updatedWildlifeFound($id)
    {
        if (count($this->wildlife_found) > 4) {
            $this->wildlife_found = array_filter($this->wildlife_found, fn($item) => $item != $id);
            $this->wildlife_found = array_values($this->wildlife_found);
            $this->dispatch('swal:toast', [
                'type' => 'info',
                'title' => '',
                'message' => 'Only 4 names can be selected.'
            ]);
        }
    }

    public function updatedShortDescription()
    {
        if (strlen($this->short_description) > 115) {
            $this->dispatch('swal:toast', [
                'type' => 'info',
                'title' => '',
                'message' => 'Short description cannot exceed 110 characters.'
            ]);
            $this->short_description = substr($this->short_description, 0, 110);
        }
    }

    public function updatedSafariType($id)
    {
        if (count($this->safariType) > 4) {
            $this->safariType = array_filter($this->safariType, fn($item) => $item != $id);
            $this->safariType = array_values($this->safariType);
            $this->dispatch('swal:toast', [
                'type' => 'info',
                'title' => '',
                'message' => 'Only 4 names can be selected.'
            ]);
        }
    }
}
