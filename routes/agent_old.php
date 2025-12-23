<?php


use App\Livewire\TravelAgent\Auth\{LoginComponent};
use App\Livewire\TravelAgent\{Dashboard};
use App\Livewire\TravelAgent\Package\{PackageDetail, PackageList};
use Illuminate\Support\Facades\{Request, Route};


Route::prefix('agent')->name('agent.')->group(function () {

    Route::middleware('guest:agent')->group(function () {
        Route::get('/', LoginComponent::class);
        Route::get('login', LoginComponent::class)->name('login');
    });

    Route::middleware(['auth.guard:agent', 'agent'])->group(callback: function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('logout', [LoginComponent::class, 'logout'])->name('logout');


        Route::prefix('package')->name('package.')->group(function () {
            Route::get('/', PackageList::class)->name('package');
            Route::get('details/{uuid?}', PackageDetail::class)->name('details');
        });
    });
});
