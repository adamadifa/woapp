<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of subscriptions.
     */
    public function index(Request $request): View
    {
        $query = Subscription::with('woProfile.user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }

        $subscriptions = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    /**
     * Display the specified subscription / invoice details.
     */
    public function show(Subscription $subscription): View
    {
        $subscription->load('woProfile.user');
        return view('admin.subscriptions.show', compact('subscription'));
    }

    /**
     * Approve manual bank transfer subscription payment.
     */
    public function approve(Subscription $subscription): RedirectResponse
    {
        if ($subscription->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya transaksi berstatus Pending yang dapat disetujui.');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($subscription) {
            // 1. Update subscription status
            $subscription->update([
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addDays(30), // Periode langganan default 30 hari
            ]);

            // 2. Update subscription plan & expired_at on WO Profile
            $woProfile = $subscription->woProfile;
            if ($woProfile) {
                $woProfile->update([
                    'subscription_plan' => $subscription->plan,
                    'expired_at' => $subscription->ends_at,
                ]);
            }
        });

        return redirect()->route('admin.subscriptions.show', $subscription)
            ->with('success', 'Pembayaran langganan manual berhasil disetujui. Lisensi WO telah di-upgrade.');
    }

    /**
     * Reject manual bank transfer subscription payment.
     */
    public function reject(Subscription $subscription): RedirectResponse
    {
        if ($subscription->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya transaksi berstatus Pending yang dapat ditolak.');
        }

        $subscription->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('admin.subscriptions.show', $subscription)
            ->with('success', 'Pembayaran langganan manual ditolak dan dibatalkan.');
    }
}
