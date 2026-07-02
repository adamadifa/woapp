<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Subscription;
use App\Models\WeddingProject;
use App\Models\WoProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Super Admin Dashboard with live stats and subscription orders.
     */
    public function __invoke(Request $request): View
    {
        // 1. Fetch Dynamic Stats
        $totalWo = WoProfile::count();
        $totalClients = Client::count();
        $totalProjects = WeddingProject::whereIn('status', ['planning', 'ongoing'])->count();
        $totalRevenue = Subscription::where('status', 'active')->sum('amount');

        // 2. Fetch Recent Orders / Subscriptions
        $recentOrders = Subscription::with('woProfile.user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalWo',
            'totalClients',
            'totalProjects',
            'totalRevenue',
            'recentOrders'
        ));
    }
}
