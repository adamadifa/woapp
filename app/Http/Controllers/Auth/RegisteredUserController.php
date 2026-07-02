<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'business_name' => ['required', 'string', 'max:255'],
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'wo',
                'is_active' => true,
            ]);

            // Create profile for this WO
            $woProfile = \App\Models\WoProfile::create([
                'user_id' => $user->id,
                'business_name' => $request->business_name,
                'slug' => \Illuminate\Support\Str::slug($request->business_name) . '-' . uniqid(),
                'subscription_plan' => 'free',
            ]);

            // Set tenant_id to link this user to the newly created WO profile
            $user->update([
                'tenant_id' => $woProfile->id,
            ]);

            event(new Registered($user));
            Auth::login($user);
        });

        return redirect(route('dashboard', absolute: false));
    }
}
