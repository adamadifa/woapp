<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\WeddingProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Store a newly created task.
     */
    public function store(Request $request, WeddingProject $project): RedirectResponse
    {
        $request->validate([
            'milestone_id' => ['required', 'exists:schedule_milestones,id'],
            'title' => ['required', 'string', 'max:255'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'in:todo,in_progress,done'],
            'due_date' => ['nullable', 'date'],
        ]);

        Task::create($request->all());

        return redirect()->route('wo.projects.show', $project)->with('success', 'Task baru berhasil ditambahkan ke milestone.');
    }

    /**
     * Update the specified task.
     */
    public function update(Request $request, WeddingProject $project, Task $task): RedirectResponse
    {
        $request->validate([
            'milestone_id' => ['required', 'exists:schedule_milestones,id'],
            'title' => ['required', 'string', 'max:255'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'in:todo,in_progress,done'],
            'due_date' => ['nullable', 'date'],
        ]);

        $task->update($request->all());

        return redirect()->route('wo.projects.show', $project)->with('success', 'Task berhasil diperbarui.');
    }

    /**
     * Remove the specified task.
     */
    public function destroy(WeddingProject $project, Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('wo.projects.show', $project)->with('success', 'Task berhasil dihapus.');
    }
}
