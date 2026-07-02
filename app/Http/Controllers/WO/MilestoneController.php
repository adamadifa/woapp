<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\ScheduleMilestone;
use App\Models\TimelineTemplate;
use App\Models\WeddingProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    /**
     * Store a newly created milestone.
     */
    public function store(Request $request, WeddingProject $project): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'in:pending,in_progress,done'],
            'order' => ['nullable', 'integer'],
        ]);

        $data = $request->all();
        $data['project_id'] = $project->id;
        $data['order'] = $data['order'] ?? 0;

        ScheduleMilestone::create($data);

        return redirect()->route('wo.projects.show', $project)->with('success', 'Milestone baru berhasil ditambahkan.');
    }

    /**
     * Update the specified milestone.
     */
    public function update(Request $request, WeddingProject $project, ScheduleMilestone $milestone): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'in:pending,in_progress,done'],
            'order' => ['nullable', 'integer'],
        ]);

        $milestone->update($request->all());

        return redirect()->route('wo.projects.show', $project)->with('success', 'Milestone berhasil diperbarui.');
    }

    /**
     * Remove the specified milestone.
     */
    public function destroy(WeddingProject $project, ScheduleMilestone $milestone): RedirectResponse
    {
        $milestone->delete();

        return redirect()->route('wo.projects.show', $project)->with('success', 'Milestone berhasil dihapus.');
    }

    /**
     * Generate milestones based on master timeline templates.
     */
    public function generateFromTemplate(WeddingProject $project): RedirectResponse
    {
        $templates = TimelineTemplate::orderBy('order')->get();

        if ($templates->isEmpty()) {
            return redirect()->route('wo.projects.show', $project)->with('error', 'Tidak ada data master template timeline untuk di-generate.');
        }

        // Auto calculate due date based on project wedding_date minus template days_before_wedding
        $weddingDate = strtotime($project->wedding_date);

        foreach ($templates as $tmpl) {
            $days = $tmpl->days_before_wedding;
            $dueDate = date('Y-m-d', strtotime("-$days days", $weddingDate));

            ScheduleMilestone::create([
                'project_id' => $project->id,
                'title' => $tmpl->title,
                'description' => $tmpl->description,
                'due_date' => $dueDate,
                'status' => 'pending',
                'order' => $tmpl->order,
            ]);
        }

        return redirect()->route('wo.projects.show', $project)->with('success', 'Timeline milestones berhasil di-generate otomatis dari template.');
    }
}
