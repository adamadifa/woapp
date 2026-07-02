<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Venue;
use App\Models\WeddingProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WeddingProjectController extends Controller
{
    /**
     * Display a listing of the wedding projects.
     */
    public function index(Request $request): View
    {
        $query = WeddingProject::with(['client', 'venue'])->orderBy('wedding_date', 'asc');

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search Name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $projects = $query->paginate(9);

        // Fetch Clients & Venues for forms/dropdowns
        $clients = Client::orderBy('groom_name')->get();
        $venues = Venue::orderBy('name')->get();

        return view('wo.projects.index', compact('projects', 'clients', 'venues'));
    }

    /**
     * Store a newly created wedding project.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'client_id' => ['required', 'exists:clients,id'],
            'wedding_date' => ['required', 'date'],
            'venue_id' => ['nullable', 'exists:venues,id'],
            'total_budget' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:planning,ongoing,completed,cancelled'],
        ]);

        WeddingProject::create($request->all());

        return redirect()->route('wo.projects.index')->with('success', 'Wedding project baru berhasil dibuat.');
    }

    /**
     * Display the specified wedding project.
     */
    public function show(WeddingProject $project): View
    {
        $project->load(['client.package', 'venue']);
        
        $totalBudget = $project->total_budget;
        $budgetItems = $project->budgetItems()->with('vendor')->get();
        $vendors = \App\Models\Vendor::where('status', 'active')->orderBy('name')->get();
        $categories = \App\Models\VendorCategory::orderBy('name')->get();
        
        $milestones = $project->milestones()->with(['tasks.assignee'])->orderBy('order')->orderBy('due_date')->get();
        $teamMembers = \App\Models\User::where('tenant_id', auth()->user()->tenant_id)->whereIn('role', ['wo', 'wo_team'])->orderBy('name')->get();
        
        // Count active/done items if any
        $rundownCount = $project->rundownItems()->count();
        $milestonesCount = $milestones->count();
        
        return view('wo.projects.show', compact('project', 'totalBudget', 'rundownCount', 'milestonesCount', 'budgetItems', 'vendors', 'categories', 'milestones', 'teamMembers'));
    }

    /**
     * Update the specified wedding project.
     */
    public function update(Request $request, WeddingProject $project): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'client_id' => ['required', 'exists:clients,id'],
            'wedding_date' => ['required', 'date'],
            'venue_id' => ['nullable', 'exists:venues,id'],
            'total_budget' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:planning,ongoing,completed,cancelled'],
        ]);

        $project->update($request->all());

        return redirect()->route('wo.projects.index')->with('success', 'Data wedding project berhasil diperbarui.');
    }

    /**
     * Remove the specified wedding project.
     */
    public function destroy(WeddingProject $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('wo.projects.index')->with('success', 'Wedding project berhasil dihapus.');
    }

    /**
     * Duplicate the specified wedding project.
     */
    public function duplicate(WeddingProject $project): RedirectResponse
    {
        $newProject = $project->replicate();
        $newProject->name = $project->name . ' (Copy)';
        $newProject->status = 'planning';
        $newProject->save();

        // Replicate relations if any
        foreach ($project->budgetItems as $item) {
            $newItem = $item->replicate();
            $newItem->project_id = $newProject->id;
            $newItem->save();
        }
        foreach ($project->milestones as $milestone) {
            $newMilestone = $milestone->replicate();
            $newMilestone->project_id = $newProject->id;
            $newMilestone->save();
        }
        foreach ($project->rundownItems as $rundown) {
            $newRundown = $rundown->replicate();
            $newRundown->project_id = $newProject->id;
            $newRundown->save();
        }

        return redirect()->route('wo.projects.index')->with('success', 'Project berhasil diduplikasi.');
    }
}
