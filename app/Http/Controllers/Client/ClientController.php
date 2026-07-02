<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientNote;
use App\Models\WeddingProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Get active wedding project for current client user.
     */
    private function getProject()
    {
        $client = Client::where('user_id', auth()->id())->first();
        if (!$client) {
            abort(404, 'Data client tidak ditemukan.');
        }

        $project = $client->projects()->first();
        if (!$project) {
            abort(404, 'Wedding project belum dikonfigurasi untuk Anda.');
        }

        return $project;
    }

    /**
     * Display Client Dashboard.
     */
    public function dashboard(): View
    {
        $project = $this->getProject();

        // 1. Preparation Progress
        $checklistCount = $project->checklists()->count();
        $doneChecklistCount = $project->checklists()->where('status', 'done')->count();
        $prepPercent = $checklistCount > 0 ? min(100, round(($doneChecklistCount / $checklistCount) * 100)) : 0;

        // 2. Upcoming Milestones (nearest 3)
        $upcomingMilestones = $project->milestones()
            ->where('status', 'todo')
            ->orderBy('due_date')
            ->take(3)
            ->get();

        // 3. Budget Summary
        $totalBudget = $project->total_budget;
        $usedBudget = $project->budgetItems()->sum('actual_cost');
        $remainingBudget = $totalBudget - $usedBudget;
        $budgetPercent = $totalBudget > 0 ? min(100, round(($usedBudget / $totalBudget) * 100)) : 0;

        // 4. Guest RSVP Confirmed
        $confirmedGuests = $project->guestList()->where('rsvp_status', 'confirmed')->sum('guest_count');
        $totalGuests = $project->guestList()->sum('guest_count');

        // 5. Recent Activity Logs (Activity Log Mock)
        $activities = collect();

        // Add guest updates
        $project->guestList()->orderBy('updated_at', 'desc')->take(3)->get()->each(function ($item) use ($activities) {
            $activities->push([
                'title' => "RSVP Tamu: {$item->name}",
                'desc' => "Status RSVP diubah menjadi: " . strtoupper($item->rsvp_status) . " ({$item->guest_count} Pax)",
                'time' => $item->updated_at,
                'icon' => 'users',
            ]);
        });

        // Add checklist updates
        $project->checklists()->orderBy('updated_at', 'desc')->take(3)->get()->each(function ($item) use ($activities) {
            $activities->push([
                'title' => "Persiapan: {$item->name}",
                'desc' => "Status persiapan ditandai sebagai: " . ($item->status === 'done' ? 'SELESAI' : 'BELUM SELESAI'),
                'time' => $item->updated_at,
                'icon' => 'check-circle',
            ]);
        });

        // Add budget updates
        $project->budgetItems()->orderBy('updated_at', 'desc')->take(3)->get()->each(function ($item) use ($activities) {
            $activities->push([
                'title' => "Keuangan: {$item->category}",
                'desc' => "Pengeluaran diperbarui sebesar Rp " . number_format($item->actual_cost, 0, ',', '.'),
                'time' => $item->updated_at,
                'icon' => 'credit-card',
            ]);
        });

        $recentActivities = $activities->sortByDesc('time')->take(5);

        return view('client.dashboard', compact(
            'project',
            'prepPercent',
            'upcomingMilestones',
            'totalBudget',
            'usedBudget',
            'remainingBudget',
            'budgetPercent',
            'confirmedGuests',
            'totalGuests',
            'recentActivities'
        ));
    }

    /**
     * Display Schedule & Milestones (Read-only).
     */
    public function schedule(): View
    {
        $project = $this->getProject();
        $milestones = $project->milestones()->orderBy('due_date')->get();

        return view('client.schedule', compact('project', 'milestones'));
    }

    /**
     * Display Budget Tracker details (Read-only).
     */
    public function budget(): View
    {
        $project = $this->getProject();
        $budgetItems = $project->budgetItems()->get();
        $totalBudget = $project->total_budget;
        $usedBudget = $budgetItems->sum('actual_cost');
        $remainingBudget = $totalBudget - $usedBudget;
        $budgetPercent = $totalBudget > 0 ? min(100, round(($usedBudget / $totalBudget) * 100)) : 0;

        return view('client.budget', compact('project', 'budgetItems', 'totalBudget', 'usedBudget', 'remainingBudget', 'budgetPercent'));
    }

    /**
     * Display Contracted Vendors (Read-only).
     */
    public function vendors(): View
    {
        $project = $this->getProject();
        $vendorIds = $project->budgetItems()->whereNotNull('vendor_id')->pluck('vendor_id')->unique();
        $vendors = \App\Models\Vendor::whereIn('id', $vendorIds)->get();

        return view('client.vendors', compact('project', 'vendors'));
    }

    /**
     * Display Guest List details (Read-only).
     */
    public function guests(): View
    {
        $project = $this->getProject();
        $guests = $project->guestList()->orderBy('name')->get();
        
        $totalGuestsCount = $guests->sum('guest_count');
        $confirmedGuestsCount = $guests->where('rsvp_status', 'confirmed')->sum('guest_count');
        $declinedGuestsCount = $guests->where('rsvp_status', 'declined')->sum('guest_count');
        $pendingGuestsCount = $guests->where('rsvp_status', 'pending')->sum('guest_count');

        return view('client.guests', compact(
            'project',
            'guests',
            'totalGuestsCount',
            'confirmedGuestsCount',
            'declinedGuestsCount',
            'pendingGuestsCount'
        ));
    }

    /**
     * Display Wedding Day Rundown (Read-only).
     */
    public function rundown(): View
    {
        $project = $this->getProject();
        $rundownItems = $project->rundownItems()->orderBy('time_start')->get();

        return view('client.rundown', compact('project', 'rundownItems'));
    }

    /**
     * Display Client-WO Notes & Chats.
     */
    public function notes(): View
    {
        $project = $this->getProject();
        $notes = $project->clientNotes()->with('user')->orderBy('created_at', 'asc')->get();

        return view('client.notes', compact('project', 'notes'));
    }

    /**
     * Store new client communication note.
     */
    public function storeNote(Request $request): RedirectResponse
    {
        $project = $this->getProject();
        
        $request->validate([
            'message' => ['required', 'string'],
            'reference_file' => ['nullable', 'file', 'max:5120'], // Max 5MB
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

        return redirect()->route('client.notes')->with('success', 'Catatan/feedback berhasil dikirim ke WO.');
    }
}
