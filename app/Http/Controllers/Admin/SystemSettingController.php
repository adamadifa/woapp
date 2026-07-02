<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SystemSettingController extends Controller
{
    /**
     * Display the system settings page.
     */
    public function index(): View
    {
        $settings = SystemSetting::pluck('value', 'key')->all();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update/Store system settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'company_phone' => 'required|string|max:50',
            'company_address' => 'required|string',
            'bank_transfer_info' => 'required|string',
        ]);

        foreach ($request->only(['app_name', 'company_email', 'company_phone', 'company_address', 'bank_transfer_info']) as $key => $val) {
            SystemSetting::setValue($key, $val);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }
}
