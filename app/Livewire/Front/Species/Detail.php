<?php

namespace App\Livewire\Front\Species;

use App\Helpers\UserHelper;
use App\Mail\DynamicMail;
use App\Models\Admin;
use App\Models\EnquiryAccommodation;
use App\Models\Park;
use App\Models\Species;
use App\Models\Enquiry;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Throwable;

class Detail extends Component
{
    public $species;
    public $shareSafaris, $states, $parks, $parkSelect, $stateSelect, $park_datas, $stayCategory, $selectedStayCategories = [], $heroSecion = false, $carousel = false, $packages, $slugData;
    public $safaris, $travellers, $accommodation, $start_date, $end_date, $Speciescharacterstic;
    public $minSafari = 1;
    public $maxSafari = 8;
    public $perPage = 12;
    public $safarisPage = 12;
    public $activeTab = 'overview', $overviewActiveTab, $overviewActiveTabData = 0, $seoContents, $accommodations = [], $user_name, $user_number, $currentUrl, $user_email;

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

    public function mount($slug)
    {
        $this->slugData = $slug;
        $this->species = Species::with(['charactersticDetails'])->where('slug', $slug)->first();
        if (empty($this->species)) {
            return redirect()->route('error.landing');
        }
        $this->currentUrl = url()->current();
        $first = $this->species->charactersticDetails->where('status', 1)->first();
        if (!empty($first)) {
            $this->overviewActiveTab = Str::slug($first?->title, '_');
            $this->overviewActiveTabData = $first->species_characterstics;
        }
        $this->seoContents  = UserHelper::SeoDetails('speciesDetails', $this->species);
        $this->accommodations = EnquiryAccommodation::where('status', 1)->get();
        $activeTabName = request()->query('tab', 'overview');
        if ($activeTabName == 'overview') {
            $this->activeTab = 'overview';
        } elseif ($activeTabName == 'safaris') {
            $this->activeTab = 'safaris';
        } elseif ($activeTabName == 'packages') {
            $this->activeTab = 'packages';
        }
        $subActiveTabName = request()->query('subtab');
        if (!empty($subActiveTabName)) {
            $this->overviewActiveTab = $subActiveTabName;
            $detail = $this->species->charactersticDetails
                ->where('status', 1)
                ->first(function ($item) use ($subActiveTabName) {
                    return Str::slug($item->title, '_') === $subActiveTabName;
                });
            $this->overviewActiveTabData = $detail?->species_characterstics;
        }

       $key = 'species-details' . $this->species->id;

        $this->seoContents = (object) Cache::remember($key, 1440, function () {
            return [
                'meta_title'       => $this->species->meta_title,
                'meta_description' => $this->species->meta_description,
                'meta_image'       => $this->species->meta_image,
            ];
        });
    }
    public function clearAll()
    {
        $this->reset(['stateSelect', 'selectedStayCategories', 'parkSelect']);
        $this->dispatch('filtersCleared');
    }

    public function loadMore()
    {
        $this->perPage += 3;
    }
    public function loadsafarisMore()
    {
        $this->safarisPage += 3;
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.species.detail')->layoutData([
            'seoContents' => $this->seoContents,
        ]);
    }

    public function submit()
    {
        $this->validate();

        $IdAddress =  UserHelper::UserIPDetails();

        $enquiry =  Enquiry::create([
            'name' => ucwords($this->user_name),
            'email' => $this->user_email,
            'number' => $this->user_number,
            'type' => 'Species',
            'type_id' => $this->species->id,
            'url' => $this->currentUrl,
            'safaris' => $this->safaris,
            'travellers' => $this->travellers,
            'accommodation_id' => $this->accommodation,
            'ip_address' => $IdAddress['ip_address'],
            'source' => 'Species Details',
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

        // Mail::to($enquiry->email)->queue(
        //     new DynamicMail($parsed['subject'], $parsed['body'])
        // );
        dispatch(function () use ($enquiry, $parsed) {
            try {
                Mail::to($enquiry->email)->send(
                    new DynamicMail($parsed['subject'], $parsed['body'])
                );
            } catch (Throwable $e) {
                logger()->error('Species enquiry user mail failed', [
                    'enquiry_id' => $enquiry->id ?? null,
                    'email' => $enquiry->email,
                    'error' => $e->getMessage(),
                ]);
            }
        })->onConnection('sync');

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
        $adminEmail = Admin::first()?->email;
        if ($adminEmail) {
            dispatch(function () use ($enquiry, $parsed, $adminEmail) {
                try {
                    Mail::to($adminEmail)->send(
                        new DynamicMail($parsed['subject'], $parsed['body'])
                    );
                } catch (Throwable $e) {
                    logger()->error('Species enquiry admin mail failed', [
                        'enquiry_id' => $enquiry->id ?? null,
                        'email' => $adminEmail,
                        'error' => $e->getMessage(),
                    ]);
                }
            })->onConnection('sync');
        }


        $this->resetFields();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Your quote request has been submitted!']);
    }

    public function resetFields()
    {
        $this->reset('safaris', 'travellers', 'user_email', 'accommodation', 'start_date', 'end_date', 'user_name', 'user_number');
        $this->resetValidation();
    }

    public function setOverViewActiveTab($tab)
    {
        foreach ($this->species->charactersticDetails->where('status', 1) as $characterstic) {
            if (Str::slug($characterstic?->title, '_') === $tab) {
                $this->overviewActiveTab = $tab;
                $this->overviewActiveTabData = $characterstic->species_characterstics;
                break;
            }
        }
    }

    public function setActiveTab($value)
    {
        $this->activeTab = $value;
    }
}



