<?php

namespace App\Livewire\TravelAgent\SharedSafari;

use App\Helpers\ImageHelper;
use App\Helpers\SettingHelper;
use App\Models\{SpeciesCategory, Park, ParkSafariType, SafariesType, ShareSafari, StayCategory, VisitPurpose};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('components.layouts.agent-app')]
class AddEditComponet extends Component
{

    use WithFileUploads;

    public $showModal = false, $isEditing = false, $editId, $deleteId;
    public $modalTitle = 'Add', $pageTitle = 'Add Shared Safari';

    public $title, $safari_park, $day, $night;
    public $visit_purpose_id, $stay_category_id, $min_price_pp, $max_price_pp, $total_seats, $share_seats;
    public $display_image, $previousImage;
    public $safariTypes = [], $safari_type = [], $showError = false, $safari_count;
    public $safariParks = [], $visitPurposes, $stayCategories, $uuid;

    public function mount($uuid = null)
    {
        if (Auth::guard('web')->user()->status != 1) {
            return redirect()->route('profile-edit');
        }
        $this->safariParks = Park::where('status', 1)->pluck('name', 'park_id');
        $this->visitPurposes = VisitPurpose::pluck('name', 'visit_purpose_id');
        $this->stayCategories = StayCategory::pluck('name', 'stay_category_id');

        if (!empty($uuid)) {
            $this->uuid = $uuid;
            $sharedSafari = ShareSafari::where('uuid', $uuid)->first();
            $this->title = $sharedSafari->title;
            $this->safari_park = $sharedSafari->safari_park_id;
            $this->day = $sharedSafari->day;
            $this->night = $sharedSafari->night;
            $this->safari_count = $sharedSafari->no_of_safari;
            $this->visit_purpose_id = $sharedSafari->visit_purpose_id;
            $this->stay_category_id = $sharedSafari->stay_category_id;
            $this->min_price_pp = $sharedSafari->min_price_pp;
            $this->max_price_pp = $sharedSafari->max_price_pp;
            $this->total_seats = $sharedSafari->total_seats;
            $this->share_seats = $sharedSafari->share_seats;
            $this->previousImage = $sharedSafari->display_image;
            $this->safari_type = SafariesType::where('shared_safari_id', $sharedSafari->id)->pluck('safari_type_id')->toArray();
            $this->isEditing = true;
            $this->updatedSafariPark();
            $this->pageTitle = 'Update Shared Safari';
        }
    }

    public function render()
    {
        return view('livewire.travel-agent.shared-safari.add-edit-componet');
    }
    public function store()
    {
        $this->validate($this->rules());

        $shareSafari = null;
        if ($this->isEditing && $this->uuid) {
            $shareSafari = ShareSafari::where('uuid', $this->uuid)->firstOrFail();
        }

        $imagePath = $this->previousImage;
        if ($this->display_image) {
            $image = $this->display_image;
            $path = 'uploads/sharesafarie';
            $origPath = $image->store($path, 'public_root');
            $imagePath = ImageHelper::convertToAvif($origPath, $path);
            if (!empty($this->previousImage) && file_exists(public_path($this->previousImage))) {
                @unlink(public_path($this->previousImage));
            }
        }

        $title = $this->title;
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            ShareSafari::where('slug', $slug)
            ->when($shareSafari, fn($q) => $q->where('shared_safari_id', '!=', $shareSafari->id))
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        if ($shareSafari) {

            $shareSafari->update([
                'title' => $this->title,
                'slug' => $slug,
                'safari_park_id' => $this->safari_park,
                'day' => $this->day,
                'night' => $this->night,
                'no_of_safari' => $this->safari_count,
                'visit_purpose_id' => $this->visit_purpose_id,
                'stay_category_id' => $this->stay_category_id,
                'min_price_pp' => $this->min_price_pp,
                'max_price_pp' => $this->max_price_pp,
                'total_seats' => $this->total_seats,
                'share_seats' => $this->share_seats,
                'display_image' => $imagePath,
            ]);
        } else {

            $shareSafari = ShareSafari::create([
                'title' => $this->title,
                'slug' => $slug,
                'safari_park_id' => $this->safari_park,
                'day' => $this->day,
                'night' => $this->night,
                'no_of_safari' => $this->safari_count,
                'visit_purpose_id' => $this->visit_purpose_id,
                'stay_category_id' => $this->stay_category_id,
                'min_price_pp' => $this->min_price_pp,
                'max_price_pp' => $this->max_price_pp,
                'total_seats' => $this->total_seats,
                'share_seats' => $this->share_seats,
                'display_image' => $imagePath,
                'organized_by' => Auth::guard('web')->user()->id,
                'organized_type' => 'agent',
            ]);

            $publish_status = SettingHelper::get('publish_agent_sharedsafari', '0');
            if ($publish_status) {
                $shareSafari->update([
                    'status' => 1,
                    'is_approved' => 1,
                ]);
            }
        }

        SafariesType::where('shared_safari_id', $shareSafari->id)->delete();
        foreach ($this->safari_type as $type_id) {
            SafariesType::create([
                'shared_safari_id' => $shareSafari->id,
                'safari_type_id' => $type_id,
            ]);
        }

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ($this->isEditing ? ' Updated Successfully' : ' Added Successfully'),
        ]);
        $this->showModal = false;
        $this->resetFields();

        if ($this->isEditing) {
            return redirect()->route('agent.shared-safari.safari');
        } else {
            return redirect()->route('agent.shared-safari.details', $shareSafari->uuid);
        }
    }


    public function resetFields()
    {
        $this->reset([
            'title',
            'safari_park',
            'day',
            'night',
            'visit_purpose_id',
            'stay_category_id',
            'min_price_pp',
            'max_price_pp',
            'total_seats',
            'share_seats',
            'display_image',
            'previousImage',
            'editId',
            'deleteId',
            'safari_count',
            'safari_type'
        ]);
        $this->resetValidation();
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
            'safari_park' => 'required',
            'day' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim((string)$value) !== (string)$value) {
                        $fail('Day cannot have leading or trailing spaces.');
                    }
                },
            ],
            'night' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim((string)$value) !== (string)$value) {
                        $fail('Night cannot have leading or trailing spaces.');
                    }
                },
            ],
            'safari_type' => 'required',
            'safari_count' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim((string)$value) !== (string)$value) {
                        $fail('Number of Safaris cannot have leading or trailing spaces.');
                    }
                },
            ],
            'visit_purpose_id' => 'required',
            'stay_category_id' => 'required',
            'min_price_pp' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim((string)$value) !== (string)$value) {
                        $fail('Minimum Price Per Person cannot have leading or trailing spaces.');
                    }
                },
            ],
            'max_price_pp' => [
                'required',
                'numeric',
                'gte:' . (is_numeric((int) $this->min_price_pp) ? (int) $this->min_price_pp : 1)
            ],
            'total_seats' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim((string)$value) !== (string)$value) {
                        $fail('Total Seats cannot have leading or trailing spaces.');
                    }
                },
            ],
            'share_seats' => 'required',
            'display_image' => ($this->isEditing && !empty($this->previousImage))
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
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
            ->where('park_id', $this->safari_park)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->safari_type_id ?? null,
                    'name' => $item->safari_type->name ?? null,
                ];
            });
    }

    public function updatedMaxPricePp()
    {
        if ($this->min_price_pp > 0) {
            $minAllowed = $this->min_price_pp;
            $maxAllowed = $this->min_price_pp * 1.08;

            $this->showError = $this->max_price_pp < $minAllowed || $this->max_price_pp > $maxAllowed;
        } else {
            $this->showError = false;
        }
    }
}
