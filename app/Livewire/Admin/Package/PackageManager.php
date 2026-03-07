<?php

namespace App\Livewire\Admin\Package;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Helpers\UserHelper;
use App\Models\{Feature, Park, ItineraryPackage, Package, ParkSafariType, SafariesType, StayCategory, VisitPurpose, WeatherModel};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Layout, On};
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class PackageManager extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $showModal = false, $isEditing = false, $editId, $deleteId;
    public $publishedStatusId, $publishedStatusValue;
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
    public $safariTypes = [], $safari_type = [], $inclusion_listes = [], $tour_highlights = [], $bttv_list = [], $no_of_safari, $activeState = 1, $adminCount, $userCount;

    public function mount()
    {
        $this->safariParks = Park::pluck('name', 'park_id');
        $this->visitPurposes = VisitPurpose::pluck('name', 'visit_purpose_id');
        $this->stayCategories = StayCategory::pluck('name', 'stay_category_id');
        $this->inclusion_listes = Feature::where('type', 1)->pluck('title', 'features_id');
        $this->bttv_list = WeatherModel::where('status', 1)->pluck('title', 'park_weather_id');
        $this->dispatch('init-datepicker', ['selector' => '.datepicker']);
    }
    public function render()
    {
        $this->userCount = Package::where('type', 1)->count();
        $this->adminCount = Package::where('type', 0)->count();
        $shareSafaries = Package::with('payment')->orderBy('updated_at', 'desc');
        if (!empty($this->search)) {
            $shareSafaries->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            });
        }
        if ($this->activeState == 1) {
            $shareSafaries->where('type', 0);
        }
        if ($this->activeState == 0) {
            $shareSafaries->where('type', 1);
        }
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

        return view('livewire.admin.package.index', compact('shareSafaries'));
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
        // $avifPath = '';
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
            'organized_by' => Auth::guard('admin')->user()->id,
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
        $this->detail($package->id);
        return redirect()->route('admin.package.details', $package->uuid);
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
        // echo"he";die;
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
            // if (!empty($this->previousImage) && file_exists(public_path($this->previousImage))) {
                //     @unlink(public_path($this->previousImage));
            // }
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

            while (Package::where('slug', $slug)->where('package_id', '!=', $Package->id)->exists()) {
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

    public function confirmPublishStatus($id, $status)
    {
        $this->publishedStatusId = $id;
        $this->publishedStatusValue = $status;
        
        $statusText = $status == 1 ? 'approve' : 'reject';
        
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => "Do you want to {$statusText} this package?",
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, ' . ($status == 1 ? 'approve' : 'reject') . ' it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'executePublishStatus'
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
            'visit_purpose_id' => 'required|integer',
            'stay_category_id' => 'required|integer',

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
            ],
            'end_date' => [
                'required',
                'numeric',
            ],

            'safari_type' => 'required',
            'tour_highlights' => 'required',
            'no_of_safari' => 'required|integer|min:1',

            'display_image' => ($this->editId && !empty($this->previousImage))
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:15360',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required.',
            'title.min' => 'Title must be at least 3 characters.',
            'title.max' => 'Title cannot exceed 60 characters.',
            'title.regex' => 'Title must only contain alphabetic characters and spaces.',

            'safariPark.required' => 'Safari Park is required.',

            'visit_purpose_id.required' => 'Visit Purpose is required.',
            'visit_purpose_id.integer' => 'Visit Purpose must be a valid ID.',

            'stay_category_id.required' => 'Stay Category is required.',
            'stay_category_id.integer' => 'Stay Category must be a valid ID.',

            'min_price_pp.numeric' => 'Minimum Price Per Person must be a valid number.',
            'min_price_pp.min' => 'Minimum Price Per Person must be at least 0.',

            'max_price_pp.numeric' => 'Maximum Price Per Person must be a valid number.',
            'max_price_pp.gte' => 'Maximum Price Per Person must be greater than or equal to Minimum Price Per Person.',

            'start_date.date' => 'Start Date must be a valid date.',
            'end_date.date' => 'End Date must be a valid date.',
            'end_date.after_or_equal' => 'End Date must be after or equal to Start Date.',

            'safari_type.required' => 'Safari Type is required.',
            'tour_highlights.required' => 'Tour Highlights are required.',
            'no_of_safari.required' => 'Number of Safaris is required.',
            'no_of_safari.integer' => 'Number of Safaris must be a number.',
            'no_of_safari.min' => 'Number of Safaris must be at least 1.',

            'display_image.required' => 'Display Image is required.',
            'display_image.image' => 'Display Image must be an image file.',
            'display_image.mimes' => 'Display Image must be a jpg, jpeg, png, or webp file.',
            'display_image.max' => 'The banner image must not be greater than 5 MB.',
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

    #[On('executePublishStatus')]
    public function executePublishStatus()
    {
        $park = Package::findOrFail($this->publishedStatusId);
        $park->is_published = $this->publishedStatusValue;
        $park->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    public function toggleStatusPopular($id)
    {
        $safari = Package::findOrFail($id);
        $safari->popular = !$safari->popular;
        $safari->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    public function toggleStatusTrending($id)
    {
        $safari = Package::findOrFail($id);
        $safari->trending = !$safari->trending;
        $safari->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
    public function toggleStatusTopRated($id)
    {
        $safari = Package::findOrFail($id);
        $safari->top_rated = !$safari->top_rated;
        $safari->save();

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
}
