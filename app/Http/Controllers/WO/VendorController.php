<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorController extends Controller
{
    /**
     * Display a listing of the vendors.
     */
    public function index(): View
    {
        // Fetch all registered vendors for the active WO (scoped via Multitenantable)
        $vendors = Vendor::orderBy('created_at', 'desc')->paginate(10);
        
        // Fetch master categories for selection dropdowns
        $categories = VendorCategory::orderBy('name')->get();

        return view('wo.vendors.index', compact('vendors', 'categories'));
    }

    /**
     * Store a newly created vendor.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'status' => ['required', 'in:active,inactive'],
            'notes' => ['nullable', 'string'],
            'packages' => ['nullable', 'array'],
            'packages.*.name' => ['nullable', 'string', 'max:255'],
            'packages.*.price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $data = $request->all();
        if ($request->has('packages')) {
            $data['packages'] = array_values(array_filter($request->input('packages', []), function ($pkg) {
                return !empty(trim($pkg['name'] ?? ''));
            }));
        }

        Vendor::create($data);

        return redirect()->route('wo.vendors.index')->with('success', 'Vendor baru berhasil ditambahkan.');
    }

    /**
     * Update the specified vendor.
     */
    public function update(Request $request, Vendor $vendor): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'status' => ['required', 'in:active,inactive'],
            'notes' => ['nullable', 'string'],
            'packages' => ['nullable', 'array'],
            'packages.*.name' => ['nullable', 'string', 'max:255'],
            'packages.*.price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $data = $request->all();
        if ($request->has('packages')) {
            $data['packages'] = array_values(array_filter($request->input('packages', []), function ($pkg) {
                return !empty(trim($pkg['name'] ?? ''));
            }));
        } else {
            $data['packages'] = null;
        }

        $vendor->update($data);

        return redirect()->route('wo.vendors.index')->with('success', 'Data vendor berhasil diperbarui.');
    }

    /**
     * Remove the specified vendor.
     */
    public function destroy(Vendor $vendor): RedirectResponse
    {
        $vendor->delete();

        return redirect()->route('wo.vendors.index')->with('success', 'Vendor berhasil dihapus.');
    }
}
