<?php

use App\Livewire\Front\Auth\{AgentRegistration, ChangePassword, EditUserprofileComponent, ForgotPassword, ForgotPasswordReset, LoginComponent, RegisterComponent, Tankyou, TravelPartnerSingUpComponent, UserprofileComponent, VerifyEmail};
use App\Livewire\Front\{MediaFeedComponent, ContactUs, HomeComponent, PaymentPageRedirect, SearchResult, UserPaymentHistory};
use App\Livewire\Front\Pages\{AboutUs, Faqs, PrivacyPolicy, RefundPolicy, TermsConditions, WhyVerifyProfile};
use App\Livewire\Front\Park\{Listing as ParkListing, Detail as ParkDetail};
use App\Livewire\Front\SafariPackage\{Detail as SafariPackageDetail, Listing as SafariPackageListing};
use App\Livewire\Front\SharedSafari\{Listing, Detail};
use App\Livewire\Front\SharedSafari\Organize\CreateSafari;
use App\Livewire\Front\Species\{Detail as SpeciesDetail, Listing as FrontSpeciesListing};
use App\Livewire\TravelAgent\AgentAccommodations;
use App\Livewire\TravelAgent\Dashboard;
use App\Livewire\TravelAgent\Package\PackageDetail;
use App\Livewire\TravelAgent\Package\PackageList;
use App\Livewire\TravelAgent\SharedSafari\{AddEditComponet, SharedSafariComponet, ShareSafariDetail};
use Illuminate\Support\Facades\{Artisan, Route};
use App\Http\Controllers\SocialController;
use App\Livewire\Front\Common\WishlistMaster;
use App\Livewire\TravelAgent\Common\ShowAgentNotification;
use App\Livewire\TravelAgent\Package\PackageEnquiry;


Route::get('/optimize', function () {
    try {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:cache');
        Artisan::call('optimize:clear');
        Artisan::call('optimize');
    } catch (\Exception $e) {
    }
    return 'Application cache has been cleared';
});


Route::get('/', HomeComponent::class)->name('home');
Route::get('thankyou', Tankyou::class)->name('thankyou');

Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback']);
Route::get('auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);

Route::prefix('park')->name('park.')->group(function () {
    Route::get('/', ParkListing::class)->name('list');
    Route::get('/{slug}', ParkDetail::class)->name('detail');
});

Route::prefix('species')->name('species.')->group(function () {
    Route::get('/', FrontSpeciesListing::class)->name('list');
    Route::get('/{slug}', SpeciesDetail::class)->name('detail');
});

Route::prefix('join-shared-safari')->name('shared-safari.')->group(function () {
    Route::get('/', Listing::class)->name('list');
    Route::get('/{slug}', Detail::class)->name('detail');
});

Route::prefix('safari-packages')->name('safari-package.')->group(function () {
    Route::get('/', SafariPackageListing::class)->name('list');
    Route::get('/{slug}', SafariPackageDetail::class)->name('detail');
});
Route::get('media', MediaFeedComponent::class)->name('media');
Route::get('/search-result/{state?}', SearchResult::class)->name('search-result');
Route::get('/sign-up-as-travel-partner', TravelPartnerSingUpComponent::class)->name('travel_partner_signup');
Route::get('privacy-policy', PrivacyPolicy::class)->name('privacyPolicy');
Route::post('/delete-my-account', function () {
    // logic to delete user (or dummy for testing)
    return response()->json([
        'status' => 'success',
        'message' => 'User account deleted'
    ]);
});
Route::get('refund-policy', RefundPolicy::class)->name('refundPolicy');
Route::get('terms-&-conditions', TermsConditions::class)->name('termsConditions');
Route::get('faqs', Faqs::class)->name('faqs');
Route::get('contact-us', ContactUs::class)->name('ContactUs');
Route::get('/error-landing', function () {
    return view('errors.landing');
})->name('error.landing');

Route::get('why-verify-profile', WhyVerifyProfile::class)->name('whyVefrifyProfile');
Route::get('/about-us', AboutUs::class)->name('aboutUs');

Route::middleware('guest:web')->group(function () {
    Route::get('/verify/{slug?}', VerifyEmail::class)->name('email_verify');
    Route::get('/login/{type?}', LoginComponent::class)->name('login');
    Route::get('/forgot-password', ForgotPassword::class)->name('forgotpassword');
    Route::get('/registration', RegisterComponent::class)->name('register');
    Route::get('/agent-registration', AgentRegistration::class)->name('agent_registration');
    Route::get('/reset-password/{slug?}', ForgotPasswordReset::class)->name('forgot_password_link');
});

Route::middleware('auth.guard:web')->group(function () {
    // Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile-edit', EditUserprofileComponent::class)->name('profile-edit');
    Route::get('logout', [LoginComponent::class, 'logout'])->name('logout');
    Route::get('change-password', ChangePassword::class)->name('changepassword');
    Route::get('profile', UserprofileComponent::class)->name('profile');
    Route::get('profile/{type?}', UserprofileComponent::class)->name('profileusersafari');
    Route::get('create-sahared-shafari/{slug?}/{type?}/{subtype?}', CreateSafari::class)->name('createsaharedshafari');
    Route::get('update-sahared-shafari/{slug?}/{type?}/{subtype?}', CreateSafari::class)->name('edit.saharedshafari');
    Route::get('wishlist', WishlistMaster::class)->name('user-wishlist');
    Route::get('payment/{type?}/{uuid?}', PaymentPageRedirect::class)->name('redirect-to-payment-page');
     Route::get('transaction-history', UserPaymentHistory::class)->name('transaction-history');


    // agent panle
    Route::middleware(['check.status'])->group(function () {
        Route::prefix('agent')->name('agent.')->group(function () {
            Route::get('/dashboard', Dashboard::class)->name('dashboard');

            Route::prefix('package')->name('package.')->group(function () {
                Route::get('/', PackageList::class)->name('package');
                Route::get('details/{uuid?}', PackageDetail::class)->name('details');
            });
            Route::get('/package-enquiry', PackageEnquiry::class)->name('enquiries');
            Route::prefix('shared-safari')->name('shared-safari.')->group(function () {
                Route::get('/', SharedSafariComponet::class)->name('safari');
                Route::get('add', AddEditComponet::class)->name('add');
                Route::get('edit/{uuid?}', AddEditComponet::class)->name('edit');
                Route::get('details/{uuid?}', ShareSafariDetail::class)->name('details');
            });
            Route::get('all-notification', ShowAgentNotification::class)->name('allnotification');
            Route::get('accommodations', AgentAccommodations::class)->name('agentaccommodation');
        });
    });
});

require __DIR__ . '/admin.php';
// require __DIR__ . '/agent.php';
require __DIR__ . '/api.php';
