<?php

use App\Helpers\ImageHelper;
use App\Http\Controllers\CkEditorController;
use App\Http\Controllers\Admin\TableTruncateController;
use App\Http\Controllers\TestController;
use App\Livewire\Admin\Auth\{LoginComponent};
use App\Livewire\Admin\{AdminProfile, HomePageBanner, AlbumForm, CityCrud, ContactSettingForm, Countries, Coupon, Dashboard, FaqCategoryManager, FaqManager, Features, PaymentHistory, ReachabilityModes, ReportMaster, ReportResion, SafariTypes, SiteSettingForm, SpeciesFamily, SpeciesGenu, States, SystemFaqCrud, ThingToCarries, weatherComponent, WildlifeCrud};
use App\Livewire\Admin\Accommodation\Accommodations;
use App\Livewire\Admin\Amenity\Amenities;
use App\Livewire\Admin\Activity\ActivityLog;
use App\Livewire\Admin\Amenity\TestingIcon;
use App\Livewire\Admin\Jobs\FailedJobComponent;
use App\Livewire\Admin\Notification\Templates;
use App\Livewire\Admin\ClearData\ClearData;
use App\Livewire\Admin\Common\ShowAllNotification;
use App\Livewire\Admin\Enquiries\{GeneralEnquiry,ContactUsFormListing, PackageEnquiry};
use App\Livewire\Admin\Park\Details\{ParkDetails};
use App\Livewire\Admin\Package\{PackageManager, PackageDetail, PackagesDetailsTabs};
use App\Livewire\Admin\Pages\{AboutUs, PrivacyPolicy, RefundPolicy, TermsAndConditions,WhyVerifyProfile};
use App\Livewire\Admin\Park\{ParkTabsComponent, ParkManager};
use App\Livewire\Admin\Park\Add\AddParkComponent;
use App\Livewire\Admin\Park\Add\EditParkComponent;
use App\Livewire\Admin\Seo\SeoMaster;
use App\Livewire\Admin\ShareSafari\Add\AddSharedSafariComponent;
use App\Livewire\Admin\ShareSafari\Details\PersonalChat;
use App\Livewire\Admin\ShareSafari\IntertedUserLists;
use App\Livewire\Admin\ShareSafari\SharedSafariDetailsTabs;
use App\Livewire\Admin\ShareSafari\ShareSafariCrud as ShareSafariShareSafariCrud;
use App\Livewire\Admin\ShareSafari\ShareSafariDetail;
use App\Livewire\Admin\Species\{SpeciesCategories, SpeciesCharacterstics, SpeciesManager};
use App\Livewire\Admin\Species\Add\AddOverView;
use App\Livewire\Admin\Species\Add\AddSpecies;
use App\Livewire\Admin\Species\Details\SpeciesDetails;
use App\Livewire\Admin\TravelAgent\{TravelAgent,TravelAgentDetails};
use App\Models\Amenity;
use App\Livewire\Admin\SiteSetting\AdminSiteSetting;
use App\Livewire\Admin\Users\Details;
use App\Livewire\Admin\Users\User;
use App\Livewire\Admin\Social\MediaPost;
use Illuminate\Support\Facades\{Request, Route};

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('/', LoginComponent::class);
        Route::get('login', LoginComponent::class)->name('login');
    });

    Route::middleware(['auth.guard:admin', 'admin'])->group(callback: function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('logout', [LoginComponent::class, 'logout'])->name('logout');
        Route::get('profiles', AdminProfile::class)->name('profiles');

        Route::prefix('species')->name('species.')->group(function () {
            Route::get('categories', SpeciesCategories::class)->name('categories');
            Route::get('characteristics', SpeciesCharacterstics::class)->name('speciesCharacterstics');
            Route::get('/', SpeciesManager::class)->name('species');
            Route::get('details/{uuid?}', SpeciesDetails::class)->name('add-species');
            // Route::post('ckeditor-upload', [CkEditorController::class, 'ImageUpload'])->name('ckeditorupload');
        });

        Route::prefix('park')->name('park.')->group(function () {
            Route::get('information', ParkTabsComponent::class)->name('speciesCharacterstics');
            Route::get('/', ParkManager::class)->name('park');
            Route::get('/add', AddParkComponent::class)->name('add-park');
            Route::get('details/{uuid?}', ParkDetails::class)->name('parkdetails');
            Route::get('/edit/{id?}', AddParkComponent::class)->name('edit-park');
        });

        Route::prefix('package')->name('package.')->group(function () {
            Route::get('information', PackagesDetailsTabs::class)->name('characterstics');
            Route::get('/', PackageManager::class)->name('package');
            Route::get('details/{uuid?}', PackageDetail::class)->name('details');
        });

        Route::prefix('shared-safari')->name('sharedsafari.')->group(function () {
            Route::get('information', SharedSafariDetailsTabs::class)->name('safariCharacterstics');
            Route::get('/', ShareSafariShareSafariCrud::class)->name('share.safari');
            Route::get('add', AddSharedSafariComponent::class)->name('addsafari');
            Route::get('edit/{uuid?}', AddSharedSafariComponent::class)->name('editsafari');
            Route::get('details/{uuid?}', ShareSafariDetail::class)->name('details');
            Route::get('chate/{uuid?}', PersonalChat::class)->name('persnal-chat');
            Route::get('interested-user/{uuid?}', IntertedUserLists::class)->name('interested');
        });

        Route::prefix('data-cleaner')->name('cleardata.')->group(function () {
            Route::get('/', ClearData::class)->name('cleardata');
            Route::post('/truncate-table', TableTruncateController::class)->name('truncate-table');
        });
        Route::prefix('notification')->name('notification.')->group(function () {
            Route::get('templates', Templates::class)->name('template');
        });
         Route::prefix('social')->name('social.')->group(function () {
             Route::get('media-post', MediaPost::class)->name('mediapost');
        });

        Route::get('/species-family', SpeciesFamily::class)->name('species_family');
        Route::get('/species-genus', SpeciesGenu::class)->name('species_genus');
        Route::get('/reachability-modes', ReachabilityModes::class)->name('reachability_modes');
        Route::get('/seo-pages', SeoMaster::class)->name('seo_pages');

        Route::get('/safari-types', SafariTypes::class)->name('safari_type');
        Route::get('/city', CityCrud::class)->name('city');
        Route::get('/states', States::class)->name('states');
        Route::get('/countries', Countries::class)->name('countries');
        Route::get('/weather', weatherComponent::class)->name('weather');


        Route::get('/faqs', FaqManager::class)->name('faqs');
        Route::get('/things-to-carries', ThingToCarries::class)->name('things_to_carries');
        Route::get('/system-faq', SystemFaqCrud::class)->name('system_faq');
        Route::get('/inclusion-exclusion', Features::class)->name('features');
        Route::get('/enquiries', GeneralEnquiry::class)->name('enquiries');
        Route::get('/package-enquiry', PackageEnquiry::class)->name('packageenquiries');
         Route::get('/contact-submissions', ContactUsFormListing::class)->name('contact-submissions');
         Route::get('failed-jobs',FailedJobComponent::class)->name('failed-jobs');
        Route::get('/faqs-category', FaqCategoryManager::class)->name('faqs.category');
        Route::get('/activity-log', ActivityLog::class)->name('activity-log');

        Route::get('albums', AlbumForm::class)->name('albums');

        Route::get('/contact-us', ContactSettingForm::class)->name('contact_us');
        Route::get('/about-us', AboutUs::class)->name('about_us');
        Route::get('/why-verify-profile', WhyVerifyProfile::class)->name('why_verify_profile');
        Route::get('/privacy-policy', PrivacyPolicy::class)->name('privacy_policy');
        Route::get('/refund-policy', RefundPolicy::class)->name('refund_policy');
        Route::get('/terms-and-conditions', TermsAndConditions::class)->name('terms_and_conditions');

        Route::get('/settings', AdminSiteSetting::class)->name('settings');
        Route::get('/amenities', Amenities::class)->name('amenities');
        Route::get('travel-agent', TravelAgent::class)->name('travel_agent');
        Route::get('travel-agent/{id}/details',TravelAgentDetails::class)->name('travel-agent.details');
        Route::get('accommodations', Accommodations::class)->name('accommodationList');
        Route::get('report-resion', ReportResion::class)->name('reportresion');
        Route::get('report', ReportMaster::class)->name('report');
        // Route::get('/testing-icon', TestingIcon::class)->name('amenities');

        Route::get('users', User::class)->name('allUser');
        Route::get('users/{id}/details',Details::class)->name('user.details');
        Route::get('all-notification',ShowAllNotification::class)->name('allnotification');

        Route::get('/home-page-banner', HomePageBanner::class)->name('home_page_banner');

         Route::get('coupons', Coupon::class)->name('coupon');
         Route::get('transaction-history', PaymentHistory::class)->name('transaction-history');
    });
});
