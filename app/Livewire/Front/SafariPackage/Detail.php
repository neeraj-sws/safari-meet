<?php

namespace App\Livewire\Front\SafariPackage;

use App\Helpers\UserHelper;
use App\Models\Package;
use App\Models\{Admin, SafariFaq, FeaturePackageSafari, FeatureThingsToCarrySafari, ItineraryPackage, PackageBanner, ParkFaq, Report, ReportResion, SafariDetailsDynamicTabs, SafariDiscussion, SafariEnquiry, SafariRatingHeading, Wishlist};
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Detail extends Component
{
    public $package, $durationText, $similarPackages, $faqs, $carousel = true;
    public $dataInclusions, $dataExclusions, $dataAmenities = [], $itineraries = [], $thingsToCarries = [];
    public $bannerImg = [], $types, $ratingHeading = [], $discussions = [], $replyBox = null, $content = [], $replyContent = [];
    public $dynamicTabs = [], $accommodationData, $showEnquireForm = false, $user;
    public $travelers, $start_date, $people, $name, $email, $country, $mobile_number, $message, $wishlistTitle = "Add Wishlist";
    public $reportDiscussionId;
    public $selectedResion;
    public $notes;
    public $reportResions = [],$organizer;
    public $showReportModal = false, $seoContents;

    public function mount($slug)
    {
        $this->package = Package::with([
            'park.state',
            'safariTypes.types',
            'bestTimeToVisit',
            'detailsTabs',
            'banners',
            'thingsToCarries',
            'featuer_safaries',
            'itinerary',
            'agent',
            'safariaccommodation.accommodation',
            'safariaccommodation.accommodation.amenity',
            'safariaccommodation.accommodation.image',
            'safariaccommodation.accommodation.category',
        ])->where('slug', $slug)->first();
        if (empty($this->package)) {
            return redirect()->route('error.landing');
        }
        $this->user = Auth::guard('web')->user();
        $this->types = $this->package->safariTypes->pluck('types.name')->filter()->implode(', ');
        $this->dynamicTabs = $this->package->dynamicTabs;
        $this->faqs          = ParkFaq::where('park_id', $this->package->park->id)->get();
        $this->bannerImg     = $this->package->banners->pluck('image');
        $this->ratingHeading = $this->package->safariRatingHeading;
        $this->thingsToCarries = $this->package->thingsToCarries;
        $this->accommodationData = $this->package->safariaccommodation;

        if ($this->package->type == 0) {
            $this->organizer =  Admin::find($this->package->organized_by);
        } elseif ($this->package->type == 1) {
            $this->organizer =  $this->package->agent ?? null;
        }

        $features = $this->package->featuer_safaries->groupBy('type');
        $this->dataInclusions = $features[1] ?? [];
        $this->dataExclusions = $features[2] ?? [];
        $this->dataAmenities  = $features[3] ?? [];

        $this->itineraries = $this->package->itinerary()->orderBy('order_by')->take($this->package->start_tour)->get();

        $this->similarPackages = Package::with('park.state')
            ->where('park_id', $this->package->park_id)
            ->where('status', 1)
            ->where('is_published', 1)
            ->where('slug', '!=', $slug)
            ->get();
        $checkWishlist = Wishlist::where('package_id', $this->package->id)
            ->where('user_id', Auth::id())
            ->first();
        if ($checkWishlist) {
            $this->wishlistTitle = "Remove Wishlist";
        }

       $key = 'safari-packages-details-' . $this->package->id;

        $this->seoContents = (object) Cache::remember($key, 1440, function () {
            return [
                'meta_title'       => $this->package->meta_title,
                'meta_description' => $this->package->meta_description,
                'meta_image'       => $this->package->meta_image,
            ];
        });

    }


    #[Layout('components.layouts.guest')]
    public function render()
    {
        $this->loadDiscussions();
        return view('livewire.front.safari-package.detail')->layoutData([
            'seoContents' => $this->seoContents,
        ]);
    }

    // private function loadDiscussions()
    // {
    //     $this->discussions = SafariDiscussion::with(['user', 'admin'])
    //         ->where('package_id', $this->package->id)->get();
    // }

    // public function discussionReplyBox($id)
    // {
    //     $this->replyBox = $this->replyBox === $id ? null : $id;
    // }

    // public function save($parentId = null)
    // {
    //     $field   = $parentId ? "replyContent.$parentId" : "content";
    //     $content = $parentId ? ($this->replyContent[$parentId] ?? '') : $this->content;

    //     $this->validate([$field => 'required|string|max:500']);

    //     SafariDiscussion::create([
    //         'package_id' => $this->package->id,
    //         'user_id'    => Auth::id() ?? 1,
    //         'content'    => $content,
    //         'is_admin'   => 0,
    //         'parent_id'  => $parentId,
    //     ]);

    //     $parentId ? $this->replyContent[$parentId] = '' : $this->content = '';
    //     $this->replyBox = null;

    //     $this->dispatch('swal:toast', [
    //         'type' => 'success',
    //         'message' => 'Comment added successfully!',
    //     ]);
    // }

    private function loadDiscussions()
    {
        $this->discussions = SafariDiscussion::with(['user', 'admin', 'replies'])
            ->where('package_id', $this->package->id)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function discussionReplyBox($id)
    {
        $this->replyBox = $this->replyBox === $id ? null : $id;
    }

    public function save($parentId = null)
    {
        $field = $parentId ? "replyContent.$parentId" : "content";
        $content = $parentId ? ($this->replyContent[$parentId] ?? '') : $this->content;

        $this->validate([$field => 'required|string|max:500'], [
            "$field.required" => 'Please write something before posting.',
        ]);

        SafariDiscussion::create([
            'package_id' => $this->package->id,
            'user_id' => Auth::id() ?? 1,
            'content' => $content,
            'is_admin' => 0,
            'parent_id' => $parentId,
        ]);

        if ($parentId) {
            unset($this->replyContent[$parentId]);
        } else {
            $this->content = '';
        }

        $this->replyBox = null;
        $this->loadDiscussions();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Comment added successfully!',
        ]);
    }

    public function showEnquire()
    {
        $this->resetValidation();
        $this->reset(['travelers', 'start_date', 'people', 'name', 'email', 'country', 'mobile_number', 'message']);
        if ($this->user) {
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->mobile_number = $this->user->phone_number ?? null;
            $this->country = $this->user?->country?->name ?? null;
        }

        $this->showEnquireForm = true;
    }

    public function closeShowForm()
    {
        $this->showEnquireForm = false;
    }

    public function saveEnquiry()
    {
        $this->validate([
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'country' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:100',
            'mobile_number' => [
                'required',
                'regex:/^[0-9]{10}$/',
            ],
            'travelers' => 'required|integer|min:1|max:20',
            'start_date' => 'required|date|after_or_equal:today',
            'message' => 'nullable|string|max:1000',
        ], [
            'name.regex' => 'Name should contain only letters.',
            'country.regex' => 'Country should contain only letters.',
            'mobile_number.regex' => 'Enter a valid phone number (only digits, 10 characters).',
        ]);

        $IdAddress =  UserHelper::UserIPDetails();

        SafariEnquiry::create([
            'package_id' => $this->package->id ?? null,
            'package_owner_type' => ($this->package->type ?? 0) == 0 ? 'admin' : 'agent',
            'owner_id' => $this->package->organized_by ?? null,
            'name' => ucwords($this->name),
            'email' => strtolower($this->email),
            'country' => ucwords($this->country),
            'mobile_number' => $this->mobile_number,
            'travelers' => $this->travelers,
            'start_date' => $this->start_date,
            'people' => $this->people,
            'message' => $this->message,
            'user_id' => $this->user->id ?? null,
            'ip_address' => $IdAddress['ip_address'],
            'browser' => $IdAddress['browser'],
            'os' => $IdAddress['os'],
            'device' => $IdAddress['is_mobile'] ? 'Mobile' : 'Desktop',
        ]);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Your safari enquiry has been submitted successfully!',
        ]);
        $this->closeShowForm();
    }

    public function addwishlist($id)
    {
        $checkWishlist = Wishlist::where('package_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($checkWishlist) {
            $checkWishlist->delete();
            $this->wishlistTitle = "Add Wishlist";
            return $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => "Item Removed from Wishlist",
            ]);
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'package_id' => $id,
            ]);

            $this->wishlistTitle = "Remove Wishlist";
            return $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => "Item Added to Wishlist",
            ]);
        }
    }

    public function discussionReport($discussionId)
    {
        $this->reportDiscussionId = $discussionId;
        $this->reportResions = ReportResion::where('status', '1')->get();
        $this->selectedResion = null;
        $this->notes = '';
        $this->showReportModal = true;
    }

    public function submitReport()
    {
        $this->validate([
            'selectedResion' => 'required|exists:report_resions,report_resion_id',
            'notes' => 'nullable|string|max:500',
        ]);
        $discussion =  SafariDiscussion::where('safari_discussion_id', $this->reportDiscussionId)->first();
        Report::create([
            'user_id' => Auth::id(),
            'report_type' => 'comment',
            'comment_id' => $this->reportDiscussionId,
            'comment' => $discussion->content,
            'package_id' =>  $this->package->id,
            'report_resion_id' => $this->selectedResion,
            'details' => $this->notes,
        ]);

        $this->reset(['showReportModal', 'selectedResion', 'notes', 'reportDiscussionId']);
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Report submitted successfully!',
        ]);
    }
}
