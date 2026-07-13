<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\WeddingPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display a listing of the wedding packages.
     */
    public function index(): View
    {
        // Multitenantable trait automatically applies TenantScope (scopes by Auth::user()->tenant_id)
        $packages = WeddingPackage::with('vendors')->orderBy('created_at', 'desc')->paginate(9);
        $vendors = \App\Models\Vendor::where('status', 'active')->orderBy('name')->get();
        return view('wo.packages.index', compact('packages', 'vendors'));
    }

    /**
     * Store a newly created wedding package.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'items' => ['nullable', 'array'],
            'items.*' => ['required', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
            'vendor_ids' => ['nullable', 'array'],
            'vendor_ids.*' => ['exists:vendors,id'],
        ]);

        $data = $request->only(['name', 'description', 'price']);
        $data['is_active'] = $request->boolean('is_active', true);
        
        // Process items array (filter out empty inputs if any)
        $items = $request->input('items', []);
        $data['items'] = array_filter($items, fn($item) => !empty(trim($item)));

        // Handle uploaded images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('packages', 'public');
            }
        }
        $data['images'] = $imagePaths;

        $package = WeddingPackage::create($data);

        $package->vendors()->sync($request->input('vendor_ids', []));

        return redirect()->route('wo.packages.index')->with('success', 'Paket wedding berhasil ditambahkan.');
    }

    /**
     * Update the specified wedding package.
     */
    public function update(Request $request, WeddingPackage $package): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'items' => ['nullable', 'array'],
            'items.*' => ['required', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
            'vendor_ids' => ['nullable', 'array'],
            'vendor_ids.*' => ['exists:vendors,id'],
        ]);

        $data = $request->only(['name', 'description', 'price']);
        $data['is_active'] = $request->boolean('is_active', true);

        // Process items
        $items = $request->input('items', []);
        $data['items'] = array_filter($items, fn($item) => !empty(trim($item)));

        // Handle uploaded images (append to existing or replace?)
        // Let's replace if new images are uploaded, or keep existing if not.
        $imagePaths = $package->images ?? [];
        if ($request->hasFile('images')) {
            // Optional: delete old images
            if (!empty($package->images)) {
                foreach ($package->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('packages', 'public');
            }
        }
        $package->update($data);

        $package->vendors()->sync($request->input('vendor_ids', []));

        return redirect()->route('wo.packages.index')->with('success', 'Paket wedding berhasil diperbarui.');
    }

    /**
     * Remove the specified wedding package.
     */
    public function destroy(WeddingPackage $package): RedirectResponse
    {
        // Delete images from storage
        if (!empty($package->images)) {
            foreach ($package->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $package->delete();

        return redirect()->route('wo.packages.index')->with('success', 'Paket wedding berhasil dihapus.');
    }
}
