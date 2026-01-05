<?php

use App\Http\Controllers\Api\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Api\Common\Following\FollowingController;
use App\Http\Controllers\Api\Common\Public\ParkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\Auth\UserAuthController;
use App\Http\Controllers\Api\Common\Public\PublicController;
use App\Http\Controllers\Api\Common\SafariPackage\SafariPackageController;
use App\Http\Controllers\Api\Common\SharedSafari\SharedSafariController;
use App\Http\Controllers\Api\Common\Species\SpeciesOverviewController;

// Route::post('login', [AdminAuthController::class, "login"]);
// NEW DEV


Route::post('user/login', [UserAuthController::class, "login"]);
Route::post('user/sing-up', [UserAuthController::class, "signUp"]);
Route::post('user/verify-otp', [UserAuthController::class, "verifyOtp"]);
Route::post('user/request-otp', [UserAuthController::class, "requestNewOtp"]);



Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('/logout', [UserAuthController::class, 'logout']);
        Route::get('/profile', [UserAuthController::class, 'profile']);
        Route::post('/profile-update', [UserAuthController::class, 'profileUpdate']);
        Route::post('/upload-profile-photo', [UserAuthController::class, 'ProfilePhotoUpdate']);

        // Shared Safari Routes
        Route::prefix('shared-safari')->name('shared-safari.')->group(function () {
            Route::get('get-user-created-safari', [SharedSafariController::class, 'getCreatedSharedSafari']);
            Route::post('created-safari', [SharedSafariController::class, 'createSharedSafari']);
            Route::get('safari_type', [SharedSafariController::class, 'safariType']);
            Route::post('create-inclusion', [SharedSafariController::class, 'createInclusion']);
            Route::get('inclusion-list', [SharedSafariController::class, 'InclusionExclusionList']);
            Route::delete('inclusion-exclusion-delete', [SharedSafariController::class, 'InclusionExclusionDelete']);
            Route::get('common-inclusion-exclusion', [SharedSafariController::class, 'InclusionExclusionCommon']);
            Route::post('create-things-to-carry', [SharedSafariController::class, 'thingsToCarryCreate']);
            Route::get('listing-things-to-carry', [SharedSafariController::class, 'listingThingsToCarry']);
            Route::delete('delete-things-to-carry', [SharedSafariController::class, 'deleteThingsToCarry']);
            Route::get('common-things-to-carry', [SharedSafariController::class, 'commonThingsToCarry']);
        });
    });
});

Route::prefix('public')->group(function () {
    Route::prefix('location')->group(function () {
        Route::get('/country', [PublicController::class, 'getCountry']);
        Route::get('/states', [PublicController::class, 'State']);
        Route::get('/city', [PublicController::class, 'city']);
    });
    Route::get('/state', [PublicController::class, 'getState']);
    Route::get('/stay-category', [PublicController::class, 'getStayCategory']);
    Route::get('/get-national-parks', [PublicController::class, 'getNationalParks']);
    Route::get('park/species', [PublicController::class, 'getParkSpecies']);

    Route::prefix('park')->name('spark.')->group(function () {
        Route::get('/', [ParkController::class, 'getParks']);
        Route::get('park-state', [ParkController::class, 'getParkStates']);
        Route::get('park-species', [ParkController::class, 'getParkSpecies']);
        Route::get('search', [ParkController::class, 'getSearchParks']);
        Route::get('details/{slug}', [ParkController::class, 'getParkDetails']);
        Route::get('tabs/details', [ParkController::class, 'getParkTabsDetails']);
    });

    Route::prefix('shared-safari')->name('shared-safari.')->group(function () {
        Route::get('/', [SharedSafariController::class, 'getSharedSafari']);
        Route::get('details/{slug}', [SharedSafariController::class, 'getSharedSafariDetails']);
        Route::get('tabs', [SharedSafariController::class, 'getSharedSafariTabsDetails']);
    });

    Route::prefix('following')->name('following.')->group(function () {
        Route::post('add', [FollowingController::class, 'addFollowing'])->middleware('auth:sanctum');
        Route::post('posts', [FollowingController::class, 'storeImagePost'])->middleware('auth:sanctum');
        Route::post('posts/{id}/like', [FollowingController::class, 'toggleLike'])->middleware('auth:sanctum');
        Route::post('posts/{id}/comment', [FollowingController::class, 'addComment'])->middleware('auth:sanctum');
        Route::get('follower_following_list', [FollowingController::class, 'FollowerFollowingList']);
        Route::get('show-posts', [FollowingController::class, 'getRecentPosts']);
       Route::get('get-post-comments', [FollowingController::class, 'getPostComments']);
       Route::get('get-post-likes', [FollowingController::class, 'getPostLikes']);
    });

    Route::prefix('safari-package')->name('shared-safari.')->group(function () {
        Route::get('/', [SafariPackageController::class, 'getsafariPackage']);
        Route::get('details/{slug}', [SafariPackageController::class, 'getSafariPackageDetails']);
        Route::get('tabs', [SafariPackageController::class, 'getSafariPackageTabsDetails']);
        Route::post('disscussion', [SafariPackageController::class, 'DiscussionData']);
    });
    Route::prefix('species')->name('shared-safari.')->group(function () {
        Route::get('/', [SpeciesOverviewController::class, 'TopSpecies']);
        Route::get('/{slug}', [SpeciesOverviewController::class, 'speciesDetail']);
        Route::get('/tab/{id}', [SpeciesOverviewController::class, 'speciesData']);
    });

    Route::get('/get-besttime-to-visit', [PublicController::class, 'getBestTimetoVisit']);
    Route::get('/get-inclusions', [PublicController::class, 'getInclusions']);
    Route::get('/get-themes', [PublicController::class, 'getThemes']);
    Route::get('/get-safari-budget', [PublicController::class, 'getSafariBudget']);
    Route::get('/get-filters', [PublicController::class, 'getFilterData']);
});
