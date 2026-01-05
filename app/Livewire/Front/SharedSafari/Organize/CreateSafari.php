<?php

namespace App\Livewire\Front\SharedSafari\Organize;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Helpers\SettingHelper;
use App\Helpers\UserHelper;
use App\Mail\DynamicMail;
use App\Models\{Admin, Feature, FeaturePackageSafari, FeatureThingsToCarrySafari, JoinSharedSafari, Park, ParkSafariType, SafariAllottedSeat, SafariesType, SafariFaq, SharedSafariDetailsTabs, SharedShafariTabs, ShareSafari, StayCategory, VisitPurpose};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

#[Layout('components.layouts.guest')]
class CreateSafari extends Component
{
    use WithFileUploads;

    // Form Data
    public $parks = [], $visitPurposes = [], $stayCategories = [];
    public $title, $safari_park, $day, $night, $safari_count;
    public $sharedSafariId, $visit_purpose_id, $stay_category_id;
    public $price_min, $price_max, $total_seats, $share_seats, $display_image, $previousImage;
    public $safariTypes = [], $safari_type = [];
    public $status, $type, $display_image_ready = true;

    // UI State
    public $active = 1;
    public $showError = false;
    public $isEditing = false;
    public $isUpdate = false;
    public $isUploading = false;
    public $options = 0;
    public $redirectMainUrl = 'createsaharedshafari';

    // Safari Characteristics
    public $characterstics = [];
    public $characterDetailsData = [];
    public $detailsMap = [];
    public $showNavTab;
    public $hasActiveData;
    public $sharedSafar;
    public $sharedSafari;

    /**
     * Tab configuration mapping
     */
    private const TABS = [
        1 => 'basic-info',
        2 => 'details',
        3 => 'upload',
        4 => 'other',
    ];

    private const TAB_LABELS = [
        1 => 'Basic Info',
        2 => 'Details',
        3 => 'Upload',
        4 => 'Other',
    ];

    /**
     * Characteristic IDs for tab handling
     */
    private const CHARACTERISTIC_EXCLUSION_IDS = [4, 5];

    public function mount($slug = null, $type = null, $subtype = null)
    {
        $this->checkUserStatus();
        $this->loadDropdownData();

        if ($slug === null) {
            return;
        }

        $this->sharedSafari = $sharedSafari = ShareSafari::where('slug', $slug)->first();

        if (empty($sharedSafari)) {
            return;
        }

        $this->initializeEditMode($sharedSafari);
        $this->sharedSafariId = $sharedSafari->id;
        $this->loadTabData($sharedSafari, $type, $subtype);
    }

    /**
     * Check if user status is valid
     */
    private function checkUserStatus(): void
    {
        if (Auth::guard('web')->user()->status != 1) {
            redirect()
                ->route('profile-edit')
                ->with('error', 'Verify/Update your profile to create safari')
                ->send();
        }
    }

    /**
     * Load all dropdown data
     */
    private function loadDropdownData(): void
    {
        $this->parks = Park::where('status', 1)->pluck('name', 'park_id');
        $this->visitPurposes = VisitPurpose::pluck('name', 'visit_purpose_id');
        $this->stayCategories = StayCategory::pluck('name', 'stay_category_id');
    }

    /**
     * Initialize edit mode based on current route
     */
    private function initializeEditMode(ShareSafari $safari): void
    {
        $isEditRoute = request()->route()->getName() === 'edit.saharedshafari';
        $isCompleted = $safari->is_create_safari_complete === 'completed';

        if ($isEditRoute && $isCompleted) {
            $this->type = 'edit';
            $this->isUpdate = true;
            $this->redirectMainUrl = 'edit.saharedshafari';
        } else {
            $this->type = null;
            $this->redirectMainUrl = 'createsaharedshafari';
        }
    }

    /**
     * Load data for specific tab
     */
    private function loadTabData(ShareSafari $safari, ?string $type, ?string $subtype): void
    {
        match ($type) {
            'basic-info' => $this->loadBasicInfoTab($safari),
            'details' => $this->loadDetailsTab($safari),
            'upload' => $this->loadUploadTab($safari),
            'other' => $this->loadOtherTab($safari, $subtype),
            default => null,
        };
    }

    /**
     * Load basic info tab data
     */
    private function loadBasicInfoTab(ShareSafari $safari): void
    {
        $this->active = 1;
        $this->title = $safari->title;
        $this->safari_park = $safari->safari_park_id;
        $this->day = $safari->day;
        $this->night = $safari->night;
        $this->safari_count = $safari->no_of_safari;
        $this->status = $safari->status;
        $this->updatedSafariPark();
        $this->safari_type = SafariesType::where('shared_safari_id', $safari->id)
            ->pluck('safari_type_id')
            ->toArray();
    }

    /**
     * Load details tab data
     */
    private function loadDetailsTab(ShareSafari $safari): void
    {
        $this->active = 2;
        $this->visit_purpose_id = $safari->visit_purpose_id;
        $this->stay_category_id = $safari->stay_category_id;
        $this->price_min = $safari->min_price_pp;
        $this->price_max = $safari->max_price_pp;
        $this->total_seats = $safari->total_seats;
        $this->share_seats = $safari->share_seats;
        $this->updatedTotalSeats();
    }

    /**
     * Load upload tab data
     */
    private function loadUploadTab(ShareSafari $safari): void
    {
        $this->active = 3;
        $this->previousImage = $safari->display_image;
        $this->isEditing = true;
        $this->display_image_ready = true;
        $this->reset('display_image');
    }

    /**
     * Load other (characteristics) tab data
     */
    private function loadOtherTab(ShareSafari $safari, ?string $subtype): void
    {
        $this->active = 4;
        $this->sharedSafar = $safari;

        $this->characterstics = SharedShafariTabs::where('status', 1)
            ->whereNotIn('shared_shafari_tabs_id', self::CHARACTERISTIC_EXCLUSION_IDS)
            ->get();

        $this->loadCharacteristicsData($safari, $subtype);
    }

    /**
     * Load characteristics data for a safari
     */
    private function loadCharacteristicsData(ShareSafari $safari, ?string $subtype): void
    {
        $this->characterDetailsData = SharedSafariDetailsTabs::where('shared_safari_id', $safari->id)->get();
        $this->detailsMap = $this->characterDetailsData->keyBy('shared_safari_tabs_id')->toArray();

        $targetTabId = $this->mapSubtypeToTabId($subtype);
        $this->showNavTab = $this->characterstics
            ->where('shared_shafari_tabs_id', $targetTabId)
            ->first() ?? $this->characterstics->first();

        $this->ensureTabDataExists();
    }

    /**
     * Map subtype string to tab ID
     */
    private function mapSubtypeToTabId(?string $subtype): ?int
    {
        return match ($subtype) {
            'exclusions' => 2,
            'inclusions' => 1,
            'things-to-carry' => 3,
            default => null,
        };
    }

    /**
     * Ensure characteristics data exists for current tab
     */
    private function ensureTabDataExists(): void
    {
        if ($this->showNavTab && !isset($this->detailsMap[$this->showNavTab->id])) {
            SharedSafariDetailsTabs::create([
                'shared_safari_tabs_id' => $this->showNavTab->id,
                'shared_safari_id' => $this->sharedSafar->id,
                'title' => $this->showNavTab->title,
                'status' => true,
            ]);

            $this->loadCharacteristicsData($this->sharedSafar, null);
        } else {
            $this->hasActiveData = $this->detailsMap[$this->showNavTab->id] ?? null;
        }
    }

    public function render()
    {
        return view('livewire.front.shared-safari.organize.create-safari');
    }


    public function store()
    {
        if (Auth::guard('web')->user()->status == 0) {
            return redirect()->route('profile-edit');
        }

        return match ($this->active) {
            1 => $this->storeBasicInfo(),
            2 => $this->storeDetails(),
            3 => $this->storeUploadImage(),
            4 => null,
            default => null,
        };
    }

    /**
     * Store basic info (tab 1)
     */
    private function storeBasicInfo()
    {
        $this->validate($this->getBasicInfoValidationRules());

        $userDetails = UserHelper::UserIPDetails();
        $safariData = $this->prepareBasicInfoData($userDetails);

        if (empty($this->sharedSafariId)) {
            $this->sharedSafari = ShareSafari::create($safariData);
            $this->syncSafariTypes($this->sharedSafari->id);
            $this->logActivity('safari.create', $this->sharedSafari->id);
        } else {
            $this->updateExistingSafari($safariData);
        }

        $this->sharedSafariId = $this->sharedSafari->id;

        return redirect()->route($this->redirectMainUrl, [
            'slug' => $this->sharedSafari->slug,
            'type' => 'details'
        ])->with('success', 'Details Added Successfully');
    }

    /**
     * Get validation rules for basic info
     */
    private function getBasicInfoValidationRules(): array
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
            'day' => 'required',
            'night' => 'required',
            'safari_count' => 'required|numeric|min:1',
            'safari_type' => 'required',
        ];
    }

    /**
     * Prepare data for basic info safari
     */
    private function prepareBasicInfoData(array $userDetails): array
    {
        $slug = $this->generateUniqueSlug($this->title);

        return [
            'title' => $this->title,
            'slug' => $slug,
            'safari_park_id' => $this->safari_park,
            'day' => $this->day,
            'night' => $this->night,
            'no_of_safari' => $this->safari_count,
            'organized_by' => Auth::guard('web')->user()->id,
            'organized_type' => Auth::guard('web')->user()->user_type == 1 ? 'agent' : 'user',
            'ip_address' => $userDetails['ip_address'],
            'browser' => $userDetails['browser'],
            'os' => $userDetails['os'],
            'device' => $userDetails['is_mobile'] ? 'Mobile' : 'Desktop',
        ];
    }

    /**
     * Generate unique slug for safari
     */
    private function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (ShareSafari::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }

    /**
     * Sync safari types
     */
    private function syncSafariTypes(int $safariId): void
    {
        foreach ($this->safari_type as $typeId) {
            SafariesType::create([
                'shared_safari_id' => $safariId,
                'safari_type_id' => $typeId,
            ]);
        }
    }

    /**
     * Update existing safari
     */
    private function updateExistingSafari(array $data): void
    {
        $safari = ShareSafari::find($this->sharedSafariId);
        if (!$safari)
            return;

        $safari->update($data);
        SafariesType::where('shared_safari_id', $safari->id)->delete();
        $this->syncSafariTypes($safari->id);
        $this->sharedSafari = $safari;
    }

    /**
     * Log activity
     */
    private function logActivity(string $action, int $safariId): void
    {
        log_activity($action, [
            'safari_id' => $safariId,
            'safari_title' => $this->sharedSafari->title ?? null,
            'message' => (Auth::guard('web')->user()->user_type == 1 ? 'agent' : 'user') . ' tried to create a shared safari.'
        ]);
    }

    /**
     * Store details (tab 2)
     */
    private function storeDetails()
    {
        $this->validate($this->getDetailsValidationRules());
        $this->validatePriceRange();

        $userDetails = UserHelper::UserIPDetails();
        $safari = ShareSafari::find($this->sharedSafariId);
        if (!$safari)
            return;

        $safari->update([
            'visit_purpose_id' => $this->visit_purpose_id,
            'stay_category_id' => $this->stay_category_id,
            'min_price_pp' => $this->price_min,
            'max_price_pp' => $this->price_max,
            'total_seats' => $this->total_seats,
            'share_seats' => $this->share_seats,
            'ip_address' => $userDetails['ip_address'],
            'browser' => $userDetails['browser'],
            'os' => $userDetails['os'],
            'device' => $userDetails['is_mobile'] ? 'Mobile' : 'Desktop',
        ]);

        return redirect()->route($this->redirectMainUrl, [
            'slug' => $safari->slug,
            'type' => 'upload'
        ])->with('success', 'Details Added Successfully');
    }

    /**
     * Get validation rules for details
     */
    private function getDetailsValidationRules(): array
    {
        return [
            'visit_purpose_id' => 'required',
            'price_min' => 'required|numeric',
            'price_max' => 'required|numeric',
            'total_seats' => 'required|numeric|min:1',
            'share_seats' => 'required|numeric|min:1',
        ];
    }

    /**
     * Validate price range
     */
    private function validatePriceRange(): void
    {
        if ($this->price_min <= 0) {
            return;
        }

        $minAllowed = $this->price_min;
        $maxAllowed = $this->price_min * 1.08;

        if ($this->price_max < $minAllowed || $this->price_max > $maxAllowed) {
            $this->dispatch('swal:toast', [
                'type' => 'info',
                'title' => '',
                'message' => 'Max price must be greater than min price and less than 8%'
            ]);
        }
    }

    /**
     * Store upload image (tab 3)
     */
    private function storeUploadImage()
    {
        $safari = ShareSafari::find($this->sharedSafariId);
        if (!$safari)
            return;

        $this->validate([
            'display_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:5120',
        ], [
            'display_image.max' => 'The display image must not be greater than 5 MB.',
        ]);

        $userDetails = UserHelper::UserIPDetails();
        $imagePath = null;

        if (!empty($this->display_image)) {
            ImageUploadHelper::delete($this->previousImage);
            $imagePath = ImageUploadHelper::upload($this->display_image, 'uploads/user-safari');
        } else {
            $imagePath = $this->previousImage;
        }


        $safari->update([
            'display_image' => $imagePath,
            'ip_address' => $userDetails['ip_address'],
            'browser' => $userDetails['browser'],
            'os' => $userDetails['os'],
            'device' => $userDetails['is_mobile'] ? 'Mobile' : 'Desktop',
        ]);
        //  dd($imagePath,$safari);
        return redirect()->route($this->redirectMainUrl, [
            'slug' => $safari->slug,
            'type' => 'other'
        ])->with('success', 'Details Added Successfully');
    }

    public function removeDisplayImage()
    {
        $this->reset('display_image');
    }

    public function updatedDisplayImage()
    {
        $this->validate([
            'display_image' => 'required|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:5120',
        ]);
    }

    public function updatedPriceMin()
    {
        $this->price_max = $this->price_min;
    }

    public function updatedPriceMax()
    {
        if ($this->price_min > 0) {
            $this->validateAndUpdatePriceError();
        } else {
            $this->showError = false;
        }
    }

    /**
     * Validate and update price error state
     */
    private function validateAndUpdatePriceError(): void
    {
        $minAllowed = $this->price_min;
        $maxAllowed = $this->price_min * 1.08;

        $this->showError = !($this->price_max >= $minAllowed && $this->price_max <= $maxAllowed);
    }


    public function changeTab($value)
    {
        $this->active = $value;

        match ($value) {
            1 => $this->loadBasicInfoTab($this->getSharedSafari()),
            2 => $this->loadDetailsTab($this->getSharedSafari()),
            3 => $this->loadUploadTab($this->getSharedSafari()),
            4 => $this->loadOtherTab($this->getSharedSafari(), null),
            default => null,
        };
    }

    /**
     * Get shared safari instance
     */
    private function getSharedSafari(): ShareSafari
    {
        return ShareSafari::find($this->sharedSafariId);
    }

    public function toggleStatus($id)
    {
        if (!$this->checkDetailsTabls($id)) {
            return $this->dispatch('swal:toast', [
                'type' => 'info',
                'title' => '',
                'message' => 'Fill the Details'
            ]);
        }

        $this->showNavTab = $this->characterstics
            ->where('shared_shafari_tabs_id', $id)
            ->first() ?? null;

        $this->loadOrCreateTabData($id);

        if ($id === 5) {
            return $this->completeSafariCreation();
        }

        return $this->redirectToNextTab();
    }


    /**
     * Load or create tab data
     */
    private function loadOrCreateTabData(int $id): void
    {
        if (!array_key_exists($id, $this->detailsMap)) {
            $characteristic = SharedShafariTabs::find($id);
            if ($characteristic) {
                $newEntry = SharedSafariDetailsTabs::create([
                    'shared_safari_tabs_id' => $characteristic->id,
                    'shared_safari_id' => $this->sharedSafar->id,
                    'title' => $characteristic->title,
                    'status' => true,
                ]);
                $this->detailsMap[$id] = $newEntry->toArray();
                $this->hasActiveData = $this->detailsMap[$id];
            } else {
                $this->hasActiveData = null;
            }
        } else {
            $this->hasActiveData = $this->detailsMap[$id];
        }
    }

    /**
     * Complete safari creation process
     */
    private function completeSafariCreation()
    {
        $safari = ShareSafari::find($this->sharedSafariId);
        $message = '';
        $type = 'info';
        if ($this->isUpdate) {
            return $this->handleSafariUpdate($safari);
        }

        return $this->handleNewSafariCreation($safari);
    }

    /**
     * Handle update of existing safari
     */
    private function handleSafariUpdate(ShareSafari $safari)
    {
        if (!$this->CheckDataIsFilled()) {
            return $this->dispatch('swal:toast', [
                'type' => 'info',
                'title' => '',
                'message' => 'Fill the Details'
            ]);
        }

        $safari->update(['is_create_safari_complete' => 'completed']);

        // if ($this->shouldAutoApprove()) {
        //     $safari->update(['is_approved' => 1]);
        // }
        $safari->save();
        $this->sharedSafariUpdatedNotification($safari);

        if ($safari->is_paid == 0) {
            return $this->redirectToPaymentPage($safari);

        }

        return redirect()->route('shared-safari.detail', $safari->slug);
    }

    /**
     * Handle new safari creation
     */
    private function handleNewSafariCreation(ShareSafari $safari)
    {

        $safari->update([
            'status' => 1,
            'is_create_safari_complete' => 'completed'
        ]);

        $message = 'Please wait for admin approval.';
        $type = 'info';

        // if ($this->shouldAutoApprove()) {
        //     $safari->update(['is_approved' => 1]);
        //     $message = 'Safari Created Successfully';
        //     $type = 'success';
        // }

        $this->createSafariNotification($safari);
        $safari->save();
        if ($safari->is_paid == 0) {
            return $this->redirectToPaymentPage($safari);

        }

        return redirect()->route('shared-safari.detail', $safari->slug)
            ->with($type, $message);
    }

    /**
     * Redirect to Payment Page.
     **/

    private function redirectToPaymentPage(ShareSafari $safari)
    {
        return redirect()->route('redirect-to-payment-page', ['type' => 'shared-safari', 'uuid' => $safari->uuid]);
    }

    /**
     * Check if safari should be auto-approved
     */
    private function shouldAutoApprove(): bool
    {
        $user = Auth::guard('web')->user();
        $publishKey = $user->user_type == 1
            ? 'publish_agent_sharedsafari'
            : 'publish_user_sharedsafari';

        return (bool) SettingHelper::get($publishKey, 0);
    }

    /**
     * Create notification for new safari
     */
    private function createSafariNotification(ShareSafari $safari): void
    {
        $msgType = $safari->organized_type === 'admin'
            ? 'App\Models\Admin'
            : 'App\Models\User';

        createNotification(
            8,
            1,
            'App\Models\Admin',
            $safari->organized_by,
            $msgType,
            [
                'user_name' => Auth::guard('web')->user()->name,
                'safari_id' => $safari->id,
                'safari_name' => $safari->title ?? null,
                'message' => Auth::guard('web')->user()->name . ' Created ' . $safari->title . ' shared safari.',
                'heading' => 'Create Safari',
                'safari_url' => route('shared-safari.detail', ['slug' => $safari->slug])
            ],
            'system'
        );

        $this->sendSafariEmail($safari, 'New Shared Safari Created Successfully');
    }

    /**
     * Send safari creation email
     */
    private function sendSafariEmail(ShareSafari $safari, string $title): void
    {
        $data = [
            'title' => $title,
            'name' => Admin::find(1)->name,
            'description' => 'A new safari has been created. Please check the information below.',
            'safari_name' => $safari->title,
            'start_date' => $safari->day,
            'end_date' => $safari->night,
            'total_seats' => $safari->total_seats,
            'available_seats' => $safari->share_seats,
            'no_of_safari' => $safari->no_of_safari,
            'updated_by' => Auth::guard('web')->user()->name,
            'updated_at' => now()->format('d M Y'),
            'year' => date('Y')
        ];

        $parsed = UserHelper::parseTemplate('SHAREDSAFARI', $data);
        Mail::to(Admin::find(1)->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));
    }

    /**
     * Redirect to next tab
     */
    private function redirectToNextTab()
    {
        $routeName = $this->type === 'edit'
            ? 'edit.saharedshafari'
            : 'createsaharedshafari';

        return redirect()->route($routeName, [
            'slug' => $this->sharedSafar->slug,
            'type' => 'other',
            'subtype' => Str::slug($this->showNavTab->title)
        ]);
    }

    /**
     * Send updated safari notification
     */
    public function sharedSafariUpdatedNotification($safari): void
    {
        $type = $safari->organized_type === 'admin'
            ? 'App\Models\Admin'
            : 'App\Models\User';

        createNotification(
            9,
            1,
            'App\Models\Admin',
            $safari->organized_by,
            $type,
            [
                'user_name' => Auth::guard('web')->user()->name,
                'safari_id' => $safari->id,
                'safari_name' => $safari->title ?? null,
                'message' => Auth::guard('web')->user()->name . ' Updated ' . $safari->title . ' shared safari.',
                'safari_url' => route('shared-safari.detail', ['slug' => $safari->slug])
            ],
            'system'
        );

        $this->sendSafariEmail($safari, 'Shared Safari Updated');
    }

    public function CheckDataIsFilled()
    {
        return FeaturePackageSafari::where('share_safari_id', $this->sharedSafariId)
            ->where('type', 1)
            ->exists()
            && FeaturePackageSafari::where('share_safari_id', $this->sharedSafariId)
                ->where('type', 2)
                ->exists();
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

    public function updatedTotalSeats()
    {
        $this->options = $this->total_seats;
    }

    public function updatedStatus()
    {
        $safari = ShareSafari::find($this->sharedSafariId);

        match ($this->status) {
            'active' => $safari->update(['status' => 1]),
            'inactive' => $safari->update(['status' => 2]),
            'seat_full' => $safari->update(['is_seat_full' => true]),
            default => null,
        };

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Status Changed Successfully'
        ]);
    }

    public function checkDetailsTabls($id)
    {
        return match ($id) {
            2 => FeaturePackageSafari::where('share_safari_id', $this->sharedSafariId)
                ->where('type', 1)
                ->exists(),
            3 => FeaturePackageSafari::where('share_safari_id', $this->sharedSafariId)
                ->where('type', 2)
                ->exists(),
            5 => $this->handleThingsToCarryStatus(),
            default => false,
        };
    }

    /**
     * Handle things to carry status check and update
     */
    private function handleThingsToCarryStatus(): bool
    {
        $thingsToCarryExists = FeatureThingsToCarrySafari::where('share_safari_id', $this->sharedSafariId)
            ->exists();

        $thingsToCarryStatus = SharedSafariDetailsTabs::where('shared_safari_tabs_id', 3)
            ->where('shared_safari_id', $this->sharedSafariId)
            ->first();

        if ($thingsToCarryStatus) {
            $thingsToCarryStatus->update(['status' => $thingsToCarryExists ? 1 : 0]);
        }

        return true;
    }

    // public function submitSharedSafari()
    // {
    //     $shareSafari = ShareSafari::find($this->sharedSafariId);

    //     if (!$shareSafari) {
    //         return redirect()
    //             ->back()
    //             ->with('error', 'Shared Safari not found. Please try again.');
    //     }

    //     return redirect()
    //         ->route('shared-safari.detail', $shareSafari->slug)
    //         ->with('success', 'Shared Safari created successfully! Please wait for admin approval.');
    // }
}
