<?php

namespace App\Livewire\Admin\ShareSafari\Add;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Helpers\UserHelper;
use App\Models\{SpeciesCategory, Park, ParkSafariType, SafariesType, ShareSafari, StayCategory, VisitPurpose};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('components.layouts.admin-app')]
class AddSharedSafariComponent extends Component
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
        return view('livewire.admin.share-safari.add.add-shared-safari');
    }

    public function store()
    {
        $this->validate($this->rules());

        $shareSafari = null;
        if ($this->isEditing && $this->uuid) {
            $shareSafari = ShareSafari::where('uuid', $this->uuid)->firstOrFail();
        }

        if ($this->min_price_pp > 0) {
            if ($this->min_price_pp > 0) {
                $minAllowed = $this->min_price_pp;
                $maxAllowed = $this->min_price_pp * 1.08;

                if ($this->max_price_pp < $minAllowed || $this->max_price_pp > $maxAllowed) {
                    return $this->dispatch('swal:toast', ['type' => 'info', 'title' => '', 'message' => 'Max price must be greater than min price and less then 8%']);
                }
            }
        }

        $imagePath = $this->previousImage;
        if ($this->display_image) {
            $image = $this->display_image;
            $path = 'uploads/sharesafarie';
            // $origPath = $image->store($path, 'public_root');
            // $imagePath = ImageHelper::convertToAvif($origPath, $path);
            // if (!empty($this->previousImage) && file_exists(public_path($this->previousImage))) {
            //     @unlink(public_path($this->previousImage));
            // }
            ImageUploadHelper::delete($this->previousImage);
            $imagePath = ImageUploadHelper::upload($image, $path);
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

        $IdAddress = UserHelper::UserIPDetails();

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
                'ip_address' => $IdAddress['ip_address'],
                'browser' => $IdAddress['browser'],
                'os' => $IdAddress['os'],
                'device' => $IdAddress['is_mobile'] ? 'Mobile' : 'Desktop',
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
                'organized_by' => Auth::guard('admin')->user()->id,
                'organized_type' => 'admin',
                'ip_address' => $IdAddress['ip_address'],
                'browser' => $IdAddress['browser'],
                'os' => $IdAddress['os'],
                'device' => $IdAddress['is_mobile'] ? 'Mobile' : 'Desktop',
            ]);
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
        if (empty($this->uuid)) {

            $type = ($shareSafari->organized_type == 'admin') ? 'App\Models\Admin' : 'App\Models\User';
            createNotification(
                9,
                1,
                'App\Models\Admin',
                $shareSafari->organized_by,
                $type,
                [
                    'user_name' => Auth::guard('admin')->user()->name,
                    'safari_id' => $shareSafari->id,
                    'safari_name' => $shareSafari->title ?? null,
                    'safari_url' => route('shared-safari.detail', ['slug' => $shareSafari->slug])
                ]
            );

            return redirect()->route('admin.sharedsafari.details', $shareSafari->uuid);
        } else {

            $type = ($shareSafari->organized_type == 'admin') ? 'App\Models\Admin' : 'App\Models\User';
            createNotification(
                9,
                1,
                'App\Models\Admin',
                $shareSafari->organized_by,
                $type,
                [
                    'user_name' => Auth::guard('admin')->user()->name,
                    'safari_id' => $shareSafari->id,
                    'safari_name' => $shareSafari->title ?? null,
                    'safari_url' => route('shared-safari.detail', ['slug' => $shareSafari->slug])
                ]
            );
            return redirect()->route('admin.sharedsafari.share.safari');
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
                    if (!is_null($value) && trim((string) $value) !== (string) $value) {
                        $fail('Day cannot have leading or trailing spaces.');
                    }
                },
            ],
            'night' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim((string) $value) !== (string) $value) {
                        $fail('Night cannot have leading or trailing spaces.');
                    }
                },
            ],
            'safari_type' => 'required',
            'safari_count' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && trim((string) $value) !== (string) $value) {
                        $fail('Safari Count cannot have leading or trailing spaces.');
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
                    if (!is_null($value) && trim((string) $value) !== (string) $value) {
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
                    if (!is_null($value) && trim((string) $value) !== (string) $value) {
                        $fail('Total Seats cannot have leading or trailing spaces.');
                    }
                },
            ],
            'share_seats' => 'required',
            'display_image' => ($this->isEditing && !empty($this->previousImage))
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360'
                : 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',
        ];
    }

    public function messages()
    {
        return [
            'display_image.max' => 'The display image must not be greater than 5 MB.',
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
