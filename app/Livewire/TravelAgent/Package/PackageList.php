<?php

namespace App\Livewire\TravelAgent\Package;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Helpers\UserHelper;
use App\Models\{Feature, FeaturePackageSafari, FeatureThingsToCarrySafari, ItineraryPackage, Park, Package, PackageBanner, ParkSafariType, SafariAccommodation, SafariesType, SafariRatingHeading, StayCategory, VisitPurpose, WeatherModel};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Layout, On};
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.agent-app')]
class PackageList extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $showModal = false, $isEditing = false, $editId, $deleteId;
    public $modalTitle = 'Add', $pageTitle = 'Package';
    public $search = '';
    public $step = 1;

    public $title, $safariPark, $day, $night, $safari_no = 1;
    public $visit_purpose_id, $stay_category_id, $min_price_pp, $max_price_pp, $total_seats, $share_seats;
    public $safari_plan, $display_image, $previousImage;
    public $safariParks, $visitPurposes, $stayCategories;
    public $filter_park, $filter_visitPurposes, $filter_stayCategories;
    public $filter_park_temp, $filter_visitPurposes_temp, $filter_stayCategories_temp;
    public $uploaded_images = [], $ids, $details, $categories = [], $category, $best_month_start, $best_month_end, $start_date, $end_date;
    public $safariTypes = [], $safari_type = [], $inclusion_listes = [], $tour_highlights = [], $bttv_list = [], $no_of_safari;

    public function mount()
    {
        if (Auth::guard('web')->user()->status != 1) {
            return redirect()->route('profile-edit');
        }
        $this->safariParks = Park::pluck('name', 'park_id');
        $this->visitPurposes = VisitPurpose::pluck('name', 'visit_purpose_id');
        $this->stayCategories = StayCategory::pluck('name', 'stay_category_id');
        $this->inclusion_listes = Feature::where('type', 1)->pluck('title', 'features_id');
        $this->bttv_list = WeatherModel::where('status', 1)->pluck('title', 'park_weather_id');
        // $this->dispatch('init-datepicker', ['selector' => '.datepicker']);+
        $totalPackages = Package::whereNot('type', 0)->where('is_completed', 0)->where('organized_by', Auth::guard('web')->user()->id)->get();
        foreach ($totalPackages as $package) {

            $allCompleted =
                PackageBanner::where('package_id', $package->id)->exists() &&
                ItineraryPackage::where('package_id', $package->id)->exists() &&
                FeaturePackageSafari::where('package_id', $package->id)->where('type', 1)->exists() &&
                FeaturePackageSafari::where('package_id', $package->id)->where('type', 2)->exists() &&
                SafariAccommodation::where('package_id', $package->id)->exists() &&
                SafariRatingHeading::where('package_id', $package->id)->exists() &&
                FeatureThingsToCarrySafari::where('share_safari_id', $package->id)->exists();

            // $package->update(['is_completed' => $allCompleted ? 1 : 0]);
        }
    }

    public function render()
    {
        $shareSafaries = Package::where('title', 'like', "%{$this->search}%")->orderBy('updated_at', 'desc')->whereNot('type', 0)->where('organized_by', Auth::guard('web')->user()->id);
        if (isset($this->filter_park_temp) && !empty($this->filter_park_temp)) {
            $shareSafaries->where('park_id', $this->filter_park_temp);
        }
        if (isset($this->filter_visitPurposes_temp) && !empty($this->filter_visitPurposes_temp)) {
            $shareSafaries->where('visit_purpose_id', $this->filter_visitPurposes_temp);
        }
        if (isset($this->filter_stayCategories_temp) && !empty($this->filter_stayCategories_temp)) {
            $shareSafaries->where('stay_category_id', $this->filter_stayCategories_temp);
        }

        $shareSafaries = $shareSafaries->latest()->paginate(10);

        return view('livewire.travel-agent.package.package-list', compact('shareSafaries'));
    }

    public function applyFilter()
    {
        $this->filter_park_temp = $this->filter_park;
        $this->filter_visitPurposes_temp = $this->filter_visitPurposes;
        $this->filter_stayCategories_temp = $this->filter_stayCategories;
    }

    public function resetFilter()
    {
        $this->reset(['search', 'filter_park', 'filter_visitPurposes', 'filter_stayCategories', 'filter_park_temp', 'filter_visitPurposes_temp', 'filter_stayCategories_temp',]);
    }

    public function resetFields()
    {
        $this->reset([
            'title',
            'safariPark',
            'visit_purpose_id',
            'stay_category_id',
            'min_price_pp',
            'max_price_pp',
            'display_image',
            'previousImage',
            'editId',
            'deleteId',
            'start_date',
            'end_date',
            'category',
            'safari_type',
            'safariTypes',
            'tour_highlights',
            'no_of_safari',
        ]);
        $this->resetValidation();
    }

    public function openModal()
    {
        $this->resetFields();
        $this->modalTitle = 'Add ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate($this->rules(), $this->messages());

        if (count($this->tour_highlights) != 4) {
            return $this->dispatch('swal:toast', [
                'type' => 'info',
                'title' => '',
                'message' => 'Must selecte 4 Items in Tour highlights.'
            ]);
        }

        if ($this->min_price_pp != $this->max_price_pp) {
            return $this->dispatch('swal:toast', ['type' => 'info', 'title' => '', 'message' => 'Maximum Price Per Person must be  same  Minimum Price Per Person.']);
        }


        $image = $this->display_image;
        $path = 'uploads/safari/package';
        // $origPath = $image->store($path, 'public_root');
        $avifPath = '';
        // $avifPath = ImageHelper::convertToAvif($origPath, $path);
        $avifPath = ImageUploadHelper::upload($image, $path);

        $imagePath = $avifPath;

        $title = $this->title;
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;
        while (Package::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $IdAddress = UserHelper::UserIPDetails();

        $package = Package::create([
            'title' => $this->title,
            'slug' => $slug,
            'park_id' => $this->safariPark,
            'visit_purpose_id' => $this->visit_purpose_id,
            'stay_category_id' => $this->stay_category_id,
            'min_price_pp' => $this->min_price_pp,
            'max_price_pp' => $this->max_price_pp,
            'display_image' => $imagePath,
            'start_tour' => $this->start_date,
            'end_tour' => $this->end_date,
            'no_of_safari' => $this->no_of_safari,
            'tour_highlights' => json_encode($this->tour_highlights),
            'organized_by' => Auth::guard('web')->user()->id,
            'type' => 1,
            'ip_address' => $IdAddress['ip_address'],
            'browser' => $IdAddress['browser'],
            'os' => $IdAddress['os'],
            'device' => $IdAddress['is_mobile'] ? 'Mobile' : 'Desktop',
        ]);

        foreach ($this->safari_type as $type_id) {
            SafariesType::create([
                'package_id' => $package->id,
                'safari_type_id' => $type_id,
            ]);
        }

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);

        $this->showModal = false;
        $this->resetFields();
        return redirect()->route('agent.package.details', $package->uuid);
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->resetFields();
        $Package = Package::findOrFail($id);

        $this->title = $Package->title;
        $this->safariPark = $Package->park_id;
        $this->visit_purpose_id = $Package->visit_purpose_id;
        $this->stay_category_id = $Package->stay_category_id;
        $this->min_price_pp = $Package->min_price_pp;
        $this->max_price_pp = $Package->max_price_pp;
        $this->previousImage = $Package->display_image;
        $this->start_date = $Package->start_tour;
        $this->end_date = $Package->end_tour;
        $this->no_of_safari = $Package->no_of_safari;
        $this->tour_highlights = json_decode($Package->tour_highlights, true) ?? [];
        $this->safari_type = SafariesType::where('package_id', $Package->id)->pluck('safari_type_id')->toArray();
        $this->safariTypes = ParkSafariType::with('safari_type')
            ->where('park_id', $Package->park_id)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->safari_type_id ?? null,
                    'name' => $item->safari_type->name ?? null,
                ];
            });

        $this->editId = $Package->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function detail($id)
    {
        $this->ids = $id;
        $this->details = 1;
    }

    public function updateData()
    {
        $this->validate($this->rules(), $this->messages());

        if (count($this->tour_highlights) != 4) {
            return $this->dispatch('swal:toast', [
                'type' => 'info',
                'title' => '',
                'message' => 'Must selecte 4 Items in Tour highlights.'
            ]);
        }

        if ($this->min_price_pp != $this->max_price_pp) {
            return $this->dispatch('swal:toast', ['type' => 'info', 'title' => '', 'message' => 'Maximum Price Per Person must be  same  Minimum Price Per Person.']);
        }
        $Package = Package::findOrFail($this->editId);

        if (($this->display_image)) {
            $image = $this->display_image;
            $path = 'uploads/safari/package';
            // $origPath = $image->store($path, 'public_root');
            // $avifPath = '';
            // $avifPath = ImageHelper::convertToAvif($origPath, $path);
            ImageUploadHelper::delete($this->previousImage);
            $avifPath = ImageUploadHelper::upload($image, $path);
            $imagePath = $avifPath;
        } else {
            $imagePath = $this->previousImage;
        }

        $title = $this->title;
        $slug = $Package->slug;

        if ($title !== $Package->title) {
            $baseSlug = Str::slug($title);
            $slug = $baseSlug;
            $counter = 1;

            while (Package::where('slug', $slug)->where('id', '!=', $Package->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
        }
        $IdAddress = UserHelper::UserIPDetails();

        if ($Package->start_tour > $this->start_date) {
            $itineraries = ItineraryPackage::where('package_id', $Package->id)
                ->where('order_by', '>', $this->start_date)
                ->get();

            foreach ($itineraries as $itinerary) {
                $itinerary->packageActivities()->delete();
                $itinerary->delete();
            }
        }

        $Package->update([
            'title' => $this->title,
            'slug' => $slug,
            'park_id' => $this->safariPark,
            'visit_purpose_id' => $this->visit_purpose_id,
            'stay_category_id' => $this->stay_category_id,
            'min_price_pp' => $this->min_price_pp,
            'max_price_pp' => $this->max_price_pp,
            'display_image' => $imagePath,
            'end_tour' => $this->end_date,
            'start_tour' => $this->start_date,
            'no_of_safari' => $this->no_of_safari,
            'tour_highlights' => json_encode($this->tour_highlights),
            'ip_address' => $IdAddress['ip_address'],
            'browser' => $IdAddress['browser'],
            'os' => $IdAddress['os'],
            'device' => $IdAddress['is_mobile'] ? 'Mobile' : 'Desktop',
        ]);
        SafariesType::where('package_id', $Package->id)->delete();
        foreach ($this->safari_type as $type_id) {
            SafariesType::create([
                'package_id' => $Package->id,
                'safari_type_id' => $type_id,
            ]);
        }
        $this->isEditing = false;
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Updated Successfully']);
        $this->showModal = false;
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
        Package::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:60',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Title cannot have leading or trailing spaces.');
                    }
                },
            ],
            'safariPark' => 'required',
            'visit_purpose_id' => 'required|numeric',
            'stay_category_id' => 'required|numeric',
            'min_price_pp' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim((string) $value) !== (string) $value) {
                        $fail('Minimum Price Per Person cannot have leading or trailing spaces.');
                    }
                },
            ],
            'max_price_pp' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim((string) $value) !== (string) $value) {
                        $fail('Maximum Price Per Person cannot have leading or trailing spaces.');
                    }
                },
            ],
            'start_date' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim((string) $value) !== (string) $value) {
                        $fail('Start day cannot have leading or trailing spaces.');
                    }
                },
            ],
            'end_date' => [
                'required',
                'numeric',
                'min:2',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim((string) $value) !== (string) $value) {
                        $fail('End day cannot have leading or trailing spaces.');
                    }
                },
            ],
            'safari_type' => 'required',
            'tour_highlights' => 'required',
            'no_of_safari' => 'required',
            'display_image' => ($this->editId && !empty($this->previousImage))
                ? 'nullable|image|mimes:jpg,jpeg,png,webp'
                : 'required|image|mimes:jpg,jpeg,png,webp',
        ];
    }


    public function messages()
    {
        return [
            'min_price_pp.required' => 'Price Per Person is required.',
            'min_price_pp.numeric' => 'Price Per Person must be a valid number.',
            'min_price_pp.min' => 'Price Per Person must be at least 1.',

            'max_price_pp.required' => 'Maximum Price Per Person is required.',
            'max_price_pp.numeric' => 'Maximum Price Per Person must be a valid number.',
            'max_price_pp.gt' => 'Maximum Price Per Person must be greater than the Minimum Price Per Person.',

            'start_date.required' => 'Stay Day is required.',
            'start_date.numeric' => 'Stay Day must be a valid number.',

            'end_date.required' => 'Stay Night is required.',
            'end_date.numeric' => 'Stay Night must be a valid number.',
        ];
    }


    public function removeDisplayImage(): void
    {
        if ($this->display_image) {
            $this->display_image->delete();
        }
        $this->display_image = null;
    }

    public function updatedSafariPark()
    {
        $this->safariTypes = ParkSafariType::with('safari_type')
            ->where('park_id', $this->safariPark)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->safari_type_id ?? null,
                    'name' => $item->safari_type->name ?? null,
                ];
            });
    }

    public function updatedTourHighlights($value)
    {
        if (count($this->tour_highlights) > 4) {
            $this->tour_highlights = array_filter($this->tour_highlights, fn($item) => $item != $value);
            $this->tour_highlights = array_values($this->tour_highlights);
            $this->dispatch('swal:toast', [
                'type' => 'info',
                'title' => '',
                'message' => 'Only 4 Items can be selected.'
            ]);
        }
    }

    public function toggleStatus($id)
    {
        $park = Package::findOrFail($id);
        $park->status = !$park->status;
        $park->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    public function updatedMinPricePp()
    {
        $this->max_price_pp = $this->min_price_pp;
    }

    public function updatedEndDate()
    {
        if (!empty($this->end_date)) {
            $this->start_date = $this->end_date;
            $this->start_date++;
        } else {
            $this->start_date = '';
        }
    }

    public function redirecttopayment($uuid)
    {
        return redirect()->route('redirect-to-payment-page', [
            'type' => 'safari-package',
            'uuid' => $uuid
        ]);

    }
}
