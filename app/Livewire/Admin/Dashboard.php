<?php

namespace App\Livewire\Admin;

use App\Models\{Park, ShareSafari, Package, Species, Payment, User};
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.admin-app')]
class Dashboard extends Component
{
    public $parksCount;
    public $safarisCount;
    public $packagesCount;
    public $speciesCount;

    // Active/Inactive counts
    public $activeSafaris;
    public $inactiveSafaris;
    public $activePackages;
    public $inactivePackages;
    public $activeParks;
    public $inactiveParks;
    public $activeSpecies;
    public $inactiveSpecies;

    // Recent data
    public $recentSafaris;
    public $recentPackages;

    // Additional stats
    public $approvedSafaris;
    public $pendingSafaris;
    public $popularSafaris;
    public $trendingSafaris;

    // Payment & Financial stats
    public $totalRevenue;
    public $todayRevenue;
    public $monthRevenue;
    public $totalPayments;
    public $recentPayments;

    // User stats
    public $totalUsers;
    public $newUsersThisMonth;

    public function render()
    {
        // Total counts
        $this->parksCount = Park::count();
        $this->safarisCount = ShareSafari::count();
        $this->packagesCount = Package::count();
        $this->speciesCount = Species::count();

        // Active/Inactive counts
        $this->activeSafaris = ShareSafari::where('status', 1)->count();
        $this->inactiveSafaris = ShareSafari::where('status', 0)->count();
        $this->activePackages = Package::where('status', 1)->count();
        $this->inactivePackages = Package::where('status', 0)->count();
        $this->activeParks = Park::where('status', 1)->count();
        $this->inactiveParks = Park::where('status', 0)->count();
        $this->activeSpecies = Species::where('status', 1)->count();
        $this->inactiveSpecies = Species::where('status', 0)->count();

        // Recent data with relationships (last 5)
        $this->recentSafaris = ShareSafari::with('park')
            ->latest()
            ->take(5)
            ->get();
        $this->recentPackages = Package::with('park')
            ->latest()
            ->take(5)
            ->get();

        // Approval stats
        $this->approvedSafaris = ShareSafari::where('is_approved', 1)->count();
        $this->pendingSafaris = ShareSafari::where('is_approved', 0)->count();

        // Popular/Trending stats
        $this->popularSafaris = ShareSafari::where('popular', 1)->count();
        $this->trendingSafaris = ShareSafari::where('trending', 1)->count();

        // Payment & Financial stats
        $this->totalRevenue = Payment::sum('final_amount') ?? 0;
        $this->todayRevenue = Payment::whereDate('created_at', today())->sum('final_amount') ?? 0;
        $this->monthRevenue = Payment::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('final_amount') ?? 0;
        $this->totalPayments = Payment::count();

        // Today's payments with user and payable relationships
        $this->recentPayments = Payment::with(['user', 'payable'])
            ->whereDate('created_at', now()->toDateString())
            ->latest()
            ->get();

        // User stats
        $this->totalUsers = User::count();
        $this->newUsersThisMonth = User::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        return view('livewire.admin.dashboard');
    }
}
