<?php

namespace App\Livewire\Front\Park;

use App\Helpers\UserHelper;
use App\Models\{EnquiryAccommodation, Park, Package, Enquiry, ShareSafari};
use Livewire\Component;
use App\Mail\DynamicMail;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class  Detail extends Component
{
    public $parkDetails;
    public $shareSafaris, $states, $parks, $parkSelect, $stateSelect, $park_datas, $stayCategory, $selectedStayCategories = [], $heroSecion = false, $carousel = false, $packages;
    public $safaris, $travellers, $accommodation, $start_date, $end_date, $species;
    public $minSafari = 1;
    public $maxSafari = 8;
    public $perPage = 12;
    public $safarisPage = 12;
    public $activeTab = 'overview', $distanceData = [], $reachabilityModes = [], $cities = [], $activeTabForOverview, $overviewActiveTabData = 0;
    public $seoContents, $accommodations = [], $user_name, $user_number, $currentUrl, $user_email;

    protected $rules = [
        'safaris'   => 'required|integer|min:1',
        'travellers'    => 'required|integer|min:1',
        'accommodation' => 'required|string',
        'start_date'    => 'required|date|after_or_equal:today',
        'end_date'      => 'required|date|after_or_equal:start_date',
        'user_name'     => 'required',
        'user_number' => 'required|digits:10',
        'user_email' => 'required|email:rfc,dns|max:255',
    ];

    protected $messages = [
        'user_name.required'   => 'Name field is required',
        'user_number.required' => 'Number field is required',
    ];



    public function mount($slug = null)
    {
        $this->parkDetails = Park::with(['DetailsCharacterstic', 'parkSafariTypes', 'parkspecies', 'parkBestTimes.weather'])->where('slug', $slug)->first();
        if (empty($this->parkDetails)) {
            return redirect()->route('error.landing');
        }
        $first = $this->parkDetails->DetailsCharacterstic->where('status', 1)->first();
        $this->currentUrl = url()->current();
        if ($first) {
            $this->activeTabForOverview = Str::slug($first?->title, '_');
            $this->overviewActiveTabData = $first->park_tabs_id;
        }

        $this->seoContents  = UserHelper::SeoDetails('parkDetailsPage', $this->parkDetails);
        $this->accommodations = EnquiryAccommodation::where('status', 1)->get();

        $activeTabName = request()->query('tab', 'overview');
        if ($activeTabName == 'overview') {
            $this->activeTab = 'overview';
        } elseif ($activeTabName == 'shared-safaris') {
            $this->activeTab = 'shared-safaris';
        } elseif ($activeTabName == 'packages') {
            $this->activeTab = 'packages';
        }
        
        $subActiveTabName = request()->query('subtab');
        if (!empty($subActiveTabName)) {
            $this->activeTabForOverview = $subActiveTabName;
            $detail = $this->parkDetails->DetailsCharacterstic->where('status', 1)
                ->first(function ($item) use ($subActiveTabName) {
                    return Str::slug($item->title, '_') === $subActiveTabName;
                });
            $this->overviewActiveTabData = $detail?->park_tabs_id;
        }
    }

    public function clearAll()
    {
        $this->dispatch('filtersCleared');
        $this->reset(['stateSelect', 'selectedStayCategories', 'parkSelect']);
    }

    public function loadMore()
    {
        $this->perPage += 3;
    }
    public function loadsafarisMore()
    {
        $this->safarisPage += 3;
    }
    public function store()
    {
        $this->validate();
        $IdAddress =  UserHelper::UserIPDetails();

        $enquiry = Enquiry::create([
            'name' => $this->user_name,
            'email' => $this->user_email,
            'number' => $this->user_number,
            'safaris' => $this->safaris,
            'travellers' => $this->travellers,
            'accommodation_id' => $this->accommodation,
            'type' => 'Park',
            'type_id' => $this->parkDetails->id,
            'url' => $this->currentUrl,
            'ip_address' => $IdAddress['ip_address'],
            'source' => 'Park Details',
            'browser' => $IdAddress['browser'],
            'os' => $IdAddress['os'],
            'device' => $IdAddress['is_mobile'] ? 'Mobile' : 'Desktop',
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $data = [
            'name' => $enquiry->name,
            'number' => $enquiry->number,
            'safaris' => $enquiry->safaris,
            'travellers' => $enquiry->travellers,
            'accommodation' => $enquiry?->accommodation?->title,
            'start_date' => $enquiry->start_date,
            'end_date' => $enquiry->end_date,
        ];

        $parsed = UserHelper::parseTemplate('USERENQUIRY', $data);

        Mail::to($enquiry->email)->queue(
            new DynamicMail($parsed['subject'], $parsed['body'])
        );

        $data = [
            'name' => $enquiry->name,
            'number' => $enquiry->number,
            'safaris' => $enquiry->safaris,
            'travellers' => $enquiry->travellers,
            'accommodation' => $enquiry?->accommodation?->title,
            'start_date' => $enquiry->start_date,
            'end_date' => $enquiry->end_date,
            'admin_view_url' => route('admin.enquiries'),
            'url' => $this->currentUrl,
            'received_at' => $enquiry->created_at,
        ];

        $parsed = UserHelper::parseTemplate('ADMINENQURY', $data);

        Mail::to('shifankhan@yopmail.com')->queue(
            new DynamicMail($parsed['subject'], $parsed['body'])
        );

        $this->dispatch('formSubmitted');
        $this->reset(['safaris', 'user_email', 'travellers', 'accommodation', 'start_date', 'end_date', 'user_name', 'user_number']);
        $this->resetValidation();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Your quote request has been submitted!']);
    }



    #[Layout('components.layouts.guest')]
    public function render()
    {
        $query  = ShareSafari::with('park.state')
            ->take($this->safarisPage);
        if ($this->activeTab == 'safaris') {
            if ($this->stateSelect) {
                $query->whereHas('park.state', function ($q) {
                    $q->where('id', $this->stateSelect);
                });
            }
            if ($this->parkSelect) {
                $query->where('safari_park_id', $this->parkSelect);
            }
            $selectedCategories = array_keys(array_filter($this->selectedStayCategories));
            if (!empty($selectedCategories)) {
                $query->whereIn('stay_category_id', $selectedCategories);
            }
        }
        $this->shareSafaris = $query->get();

        $query  = Package::with('park.state')
            ->take($this->perPage);
        if ($this->activeTab == 'packages') {
            if ($this->stateSelect) {
                $query->whereHas('park.state', function ($q) {
                    $q->where('id', $this->stateSelect);
                });
            }
            if ($this->parkSelect) {
                $query->where('package_park_id', $this->parkSelect);
            }
            $selectedCategories = array_keys(array_filter($this->selectedStayCategories));
            if (!empty($selectedCategories)) {
                $query->whereIn('stay_category_id', $selectedCategories);
            }
        }
        $this->packages = $query->get();
        return view('livewire.front.park.detail')->layoutData([
            'seoContents' => $this->seoContents,
        ]);
    }

    public function setActiveTab($tab)
    {
        foreach ($this->parkDetails?->DetailsCharacterstic->where('status', 1) as $characterstic) {
            if (Str::slug($characterstic?->title, '_') === $tab) {
                $this->activeTabForOverview = $tab;
                $this->overviewActiveTabData = $characterstic->park_tabs_id;
                break;
            }
        }
    }

    public function setActivetyTab($value)
    {
        $this->activeTab = $value;
    }
}
