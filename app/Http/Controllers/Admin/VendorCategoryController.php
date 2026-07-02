<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VendorCategoryController extends Controller
{
    /**
     * Display a listing of vendor categories.
     */
    public function index(): View
    {
        $categories = VendorCategory::orderBy('name')->paginate(10);
        return view('admin.master.vendor-categories.index', compact('categories'));
    }

    /**
     * Store a newly created vendor category.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:vendor_categories,name',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        VendorCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon ?? 'sparkles',
            'description' => $request->description,
        ]);

        return redirect()->route('admin.vendor-categories.index')
            ->with('success', 'Kategori vendor berhasil ditambahkan.');
    }

    /**
     * Update the specified vendor category.
     */
    public function update(Request $request, VendorCategory $vendorCategory): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:vendor_categories,name,' . $vendorCategory->id,
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $vendorCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon ?? 'sparkles',
            'description' => $request->description,
        ]);

        return redirect()->route('admin.vendor-categories.index')
            ->with('success', 'Kategori vendor berhasil diperbarui.');
    }

    /**
     * Remove the specified vendor category.
     */
    public function destroy(VendorCategory $vendorCategory): RedirectResponse
    {
        $vendorCategory->delete();
        return redirect()->route('admin.vendor-categories.index')
            ->with('success', 'Kategori vendor berhasil dihapus.');
    }
}
