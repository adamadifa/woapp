<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if ($user && in_array($user->role, ['wo', 'wo_team'])) {
            $wo = $user->woProfile;
            
            if ($wo && $wo->subscription_plan !== 'free' && $wo->expired_at && $wo->expired_at->isPast()) {
                // Subscription has expired! Downgrade to free
                $wo->update([
                    'subscription_plan' => 'free',
                    'expired_at' => null,
                ]);

                // Update active subscription record to expired
                $activeSub = $wo->subscriptions()->where('status', 'active')->first();
                if ($activeSub) {
                    $activeSub->update(['status' => 'expired']);
                }

                // If not requesting subscription billing page, redirect with warning
                if (!$request->routeIs('wo.subscription.*')) {
                    return redirect()->route('wo.subscription.index')->with('error', 'Masa aktif paket langganan Anda telah habis. Akun Anda telah diturunkan kembali ke paket Free.');
                }
            }
        }

        return $next($request);
    }
}
