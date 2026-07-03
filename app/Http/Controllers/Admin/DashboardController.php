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

        // 3. Monthly Revenue Data (Last 6 Months)
        $monthlyRevenue = [];
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $revenue = Subscription::where('status', 'active')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('amount');
            $monthlyRevenue[] = (int) $revenue;
        }

        // 4. Subscription Plan Distribution
        $planDistribution = [
            'free' => WoProfile::where('subscription_plan', 'free')->count(),
            'basic' => WoProfile::where('subscription_plan', 'basic')->count(),
            'pro' => WoProfile::where('subscription_plan', 'pro')->count(),
            'enterprise' => WoProfile::where('subscription_plan', 'enterprise')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalWo',
            'totalClients',
            'totalProjects',
            'totalRevenue',
            'recentOrders',
            'months',
            'monthlyRevenue',
            'planDistribution'
        ));
    }
}
