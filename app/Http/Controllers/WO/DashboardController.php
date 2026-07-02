<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\WeddingProject;
use App\Models\Vendor;
use App\Models\WeddingPackage;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display WO dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Ensure user has WoProfile first
        $profile = $user->woProfile;
        if (!$profile) {
            // Auto-create standard profile
            $profile = \App\Models\WoProfile::create([
                'user_id' => $user->id,
                'business_name' => $user->name,
                'slug' => \Illuminate\Support\Str::slug($user->name) . '-' . time(),
            ]);
            $user->update(['tenant_id' => $profile->id]);
        }

        // Fetch statistics (automatically scoped by tenant thanks to Multitenantable trait)
        $activeProjectsCount = WeddingProject::whereIn('status', ['planning', 'ongoing'])->count();
        $clientsCount = Client::count();
        $totalBudget = WeddingProject::sum('total_budget');
        $vendorsCount = Vendor::count();
        $packagesCount = WeddingPackage::count();

        // Get upcoming weddings (take 5)
        $upcomingProjects = WeddingProject::with('client')
            ->where('wedding_date', '>=', now()->toDateString())
            ->orderBy('wedding_date', 'asc')
            ->take(5)
            ->get();

        // Get recent clients
        $recentClients = Client::with('package')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('wo.dashboard', compact(
            'activeProjectsCount',
            'clientsCount',
            'totalBudget',
            'vendorsCount',
            'packagesCount',
            'upcomingProjects',
            'recentClients'
        ));
    }
}
