<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    /**
     * Display current subscription status & history.
     */
    public function index(): View
    {
        $wo = Auth::user()->woProfile;
        
        if (!$wo) {
            abort(404, 'Profil bisnis tidak ditemukan.');
        }

        $subscriptions = $wo->subscriptions()->orderBy('created_at', 'desc')->get();
        $pendingSubscription = $wo->subscriptions()->where('status', 'pending')->first();
        
        $prices = [
            'basic' => (int) \App\Models\SystemSetting::getValue('plan_basic_price', 199000),
            'pro' => (int) \App\Models\SystemSetting::getValue('plan_pro_price', 499000),
            'enterprise' => (int) \App\Models\SystemSetting::getValue('plan_enterprise_price', 999000),
        ];

        return view('wo.subscription.index', compact('wo', 'subscriptions', 'pendingSubscription', 'prices'));
    }

    /**
     * Display checkout page for selected plan.
     */
    public function checkout(string $plan): View|RedirectResponse
    {
        $wo = Auth::user()->woProfile;
        
        if (!$wo) {
            abort(404, 'Profil bisnis tidak ditemukan.');
        }

        // Check if there is already a pending subscription request
        $pendingSubscription = $wo->subscriptions()->where('status', 'pending')->first();
        if ($pendingSubscription) {
            return redirect()->route('wo.subscription.index')->with('error', 'Anda masih memiliki transaksi tertunda yang menunggu persetujuan admin.');
        }

        $validPlans = [
            'basic' => ['name' => 'Basic', 'price' => (int) \App\Models\SystemSetting::getValue('plan_basic_price', 199000)],
            'pro' => ['name' => 'Pro', 'price' => (int) \App\Models\SystemSetting::getValue('plan_pro_price', 499000)],
            'enterprise' => ['name' => 'Enterprise', 'price' => (int) \App\Models\SystemSetting::getValue('plan_enterprise_price', 999000)]
        ];

        if (!array_key_exists($plan, $validPlans)) {
            return redirect()->route('wo.subscription.index')->with('error', 'Paket langganan tidak valid.');
        }

        $planData = $validPlans[$plan];
        $bankTransferInfo = \App\Models\SystemSetting::getValue('bank_transfer_info', "BCA: 123-456-7890 a.n. PT WOApp Digital");

        return view('wo.subscription.checkout', compact('wo', 'plan', 'planData', 'bankTransferInfo'));
    }

    /**
     * Store manual transfer payment proof.
     */
    public function store(Request $request, string $plan): RedirectResponse
    {
        $wo = Auth::user()->woProfile;
        
        if (!$wo) {
            abort(404, 'Profil bisnis tidak ditemukan.');
        }

        $pendingSubscription = $wo->subscriptions()->where('status', 'pending')->first();
        if ($pendingSubscription) {
            return redirect()->route('wo.subscription.index')->with('error', 'Anda masih memiliki transaksi tertunda.');
        }

        $validPlans = [
            'basic' => (int) \App\Models\SystemSetting::getValue('plan_basic_price', 199000),
            'pro' => (int) \App\Models\SystemSetting::getValue('plan_pro_price', 499000),
            'enterprise' => (int) \App\Models\SystemSetting::getValue('plan_enterprise_price', 999000)
        ];

        if (!array_key_exists($plan, $validPlans)) {
            return redirect()->route('wo.subscription.index')->with('error', 'Paket langganan tidak valid.');
        }

        $request->validate([
            'payment_proof' => ['required', 'image', 'max:2048'], // Max 2MB
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $wo->subscriptions()->create([
            'plan' => $plan,
            'amount' => $validPlans[$plan],
            'payment_method' => 'manual_transfer',
            'payment_proof' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('wo.subscription.index')->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi dan aktivasi oleh admin.');
    }
}
