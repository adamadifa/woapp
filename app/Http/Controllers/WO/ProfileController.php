<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\WoProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the WO profile.
     */
    public function edit(): View
    {
        $user = Auth::user();
        $profile = $user->woProfile;

        // If user doesn't have a profile yet, create a default one
        if (!$profile) {
            $profile = WoProfile::create([
                'user_id' => $user->id,
                'business_name' => $user->name,
                'slug' => Str::slug($user->name) . '-' . time(),
                'subscription_plan' => 'free',
            ]);
            
            // Assign tenant_id to the user
            $user->update(['tenant_id' => $profile->id]);
        }

        return view('wo.profile.edit', compact('profile'));
    }

    /**
     * Update the WO profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $profile = $user->woProfile;

        if (!$profile) {
            abort(404, 'Profil bisnis tidak ditemukan.');
        }

        $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'], // Max 2MB
            'delete_logo' => ['nullable', 'boolean'],
        ]);

        $data = $request->only(['business_name', 'description', 'phone', 'address']);
        
        // Auto-update slug if business name changes and slug is empty/customisable
        $data['slug'] = Str::slug($request->business_name);
        
        // Handle logo upload & deletion
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        } elseif ($request->input('delete_logo') === '1') {
            if ($profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }
            $data['logo'] = null;
        }

        $profile->update($data);

        return redirect()->route('wo.profile.edit')->with('success', 'Profil bisnis Anda berhasil diperbarui.');
    }
}
