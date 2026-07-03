<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlanController extends Controller
{
    /**
     * Display a listing of plans.
     */
    public function index(): View
    {
        $plans = Plan::orderBy('price', 'asc')->get();
        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new plan.
     */
    public function create(): View
    {
        return view('admin.plans.create');
    }

    /**
     * Store a newly created plan.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:plans,slug',
            'price' => 'required|numeric|min:0',
            'max_projects' => 'required|integer',
            'max_team_members' => 'required|integer',
            'features' => 'required|string',
        ]);

        $features = array_values(array_filter(array_map('trim', explode("\n", $request->features))));

        Plan::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->slug),
            'price' => $request->price,
            'max_projects' => $request->max_projects,
            'max_team_members' => $request->max_team_members,
            'has_custom_landing' => $request->boolean('has_custom_landing'),
            'has_client_dashboard' => $request->boolean('has_client_dashboard'),
            'features' => $features,
        ]);

        return redirect()->route('admin.plans.index')->with('success', 'Paket langganan baru berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified plan.
     */
    public function edit(Plan $plan): View
    {
        $featuresString = is_array($plan->features) ? implode("\n", $plan->features) : '';
        return view('admin.plans.edit', compact('plan', 'featuresString'));
    }

    /**
     * Update the specified plan.
     */
    public function update(Request $request, Plan $plan): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:plans,slug,' . $plan->id,
            'price' => 'required|numeric|min:0',
            'max_projects' => 'required|integer',
            'max_team_members' => 'required|integer',
            'features' => 'required|string',
        ]);

        $features = array_values(array_filter(array_map('trim', explode("\n", $request->features))));

        $plan->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->slug),
            'price' => $request->price,
            'max_projects' => $request->max_projects,
            'max_team_members' => $request->max_team_members,
            'has_custom_landing' => $request->boolean('has_custom_landing'),
            'has_client_dashboard' => $request->boolean('has_client_dashboard'),
            'features' => $features,
        ]);

        return redirect()->route('admin.plans.index')->with('success', 'Paket langganan berhasil diperbarui.');
    }

    /**
     * Remove the specified plan.
     */
    public function destroy(Plan $plan): RedirectResponse
    {
        // Don't allow deleting core system plans unless necessary, but let's allow general delete
        if (in_array($plan->slug, ['free', 'basic', 'pro'])) {
            return redirect()->route('admin.plans.index')->with('error', 'Paket sistem inti (Free, Basic, Pro) tidak dapat dihapus.');
        }

        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Paket langganan berhasil dihapus.');
    }
}
