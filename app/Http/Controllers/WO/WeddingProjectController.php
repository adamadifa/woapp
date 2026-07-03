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

        $wo = auth()->user()->woProfile;
        $plan = \App\Models\Plan::where('slug', $wo->subscription_plan)->first();
        $maxProjects = $plan ? $plan->max_projects : 1;
        $activeProjectsCount = $wo->projects()->whereIn('status', ['planning', 'ongoing'])->count();
        
        if ($maxProjects !== -1 && $activeProjectsCount >= $maxProjects) {
            return redirect()->back()->with('error', "Batas proyek aktif untuk paket " . strtoupper($wo->subscription_plan) . " telah tercapai (Maks. {$maxProjects}). Silakan upgrade paket langganan Anda.");
        }

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
        $rundownItems = $project->rundownItems()->orderBy('time_start')->get();
        $rundownCount = $rundownItems->count();
        $milestonesCount = $milestones->count();

        // Checklist items and stats
        $checklists = $project->checklists()->orderBy('due_date')->get();
        $checklistCount = $checklists->count();
        $doneChecklistCount = $checklists->where('status', 'done')->count();
        $todoChecklistCount = $checklists->where('status', 'todo')->count();
        $checklistPercent = $checklistCount > 0 ? min(100, round(($doneChecklistCount / $checklistCount) * 100)) : 0;
        
        $checklistCategories = $checklists->groupBy('category')->map(function ($items) {
            $total = $items->count();
            $done = $items->where('status', 'done')->count();
            return [
                'total' => $total,
                'done' => $done,
                'percent' => $total > 0 ? min(100, round(($done / $total) * 100)) : 0,
            ];
        });

        // Guest list and stats
        $guests = $project->guestList()->orderBy('name')->get();
        $totalGuestCount = $guests->sum('guest_count');
        $confirmedGuestCount = $guests->where('rsvp_status', 'confirmed')->sum('guest_count');
        $declinedGuestCount = $guests->where('rsvp_status', 'declined')->sum('guest_count');
        $pendingGuestCount = $guests->where('rsvp_status', 'pending')->sum('guest_count');
        $categoryBreakdown = $guests->groupBy('category')->map(function ($items) {
            return $items->sum('guest_count');
        });

        // Client notes & chat
        $clientNotes = $project->clientNotes()->with('user')->orderBy('created_at', 'asc')->get();

        return view('wo.projects.show', compact(
            'project', 
            'totalBudget', 
            'rundownItems',
            'rundownCount', 
            'milestonesCount', 
            'checklists',
            'checklistCount',
            'doneChecklistCount',
            'todoChecklistCount',
            'checklistPercent',
            'checklistCategories',
            'budgetItems', 
            'vendors', 
            'categories', 
            'milestones', 
            'teamMembers',
            'guests',
            'totalGuestCount',
            'confirmedGuestCount',
            'declinedGuestCount',
            'pendingGuestCount',
            'categoryBreakdown',
            'clientNotes'
        ));
    }

    /**
     * Store notes/chat response to client.
     */
    public function storeNote(Request $request, WeddingProject $project): RedirectResponse
    {
        $request->validate([
            'message' => ['required', 'string'],
            'reference_file' => ['nullable', 'file', 'max:5120'],
        ]);

        $filePath = null;
        $fileName = null;

        if ($request->hasFile('reference_file')) {
            $file = $request->file('reference_file');
            $filePath = $file->store('client_references', 'public');
            $fileName = $file->getClientOriginalName();
        }

        $project->clientNotes()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'file_path' => $filePath,
            'file_name' => $fileName,
        ]);

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'notes'])
            ->with('success', 'Catatan/tanggapan berhasil dikirim ke klien.');
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
