<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimelineTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TimelineTemplateController extends Controller
{
    /**
     * Display a listing of timeline templates.
     */
    public function index(): View
    {
        $templates = TimelineTemplate::orderBy('order')->paginate(10);
        return view('admin.master.timeline-templates.index', compact('templates'));
    }

    /**
     * Store a newly created timeline template.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'days_before_wedding' => 'required|integer|min:0',
            'order' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        TimelineTemplate::create($request->all());

        return redirect()->route('admin.timeline-templates.index')
            ->with('success', 'Template milestone timeline berhasil ditambahkan.');
    }

    /**
     * Update the specified timeline template.
     */
    public function update(Request $request, TimelineTemplate $timelineTemplate): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'days_before_wedding' => 'required|integer|min:0',
            'order' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $timelineTemplate->update($request->all());

        return redirect()->route('admin.timeline-templates.index')
            ->with('success', 'Template milestone timeline berhasil diperbarui.');
    }

    /**
     * Remove the specified timeline template.
     */
    public function destroy(TimelineTemplate $timelineTemplate): RedirectResponse
    {
        $timelineTemplate->delete();
        return redirect()->route('admin.timeline-templates.index')
            ->with('success', 'Template milestone timeline berhasil dihapus.');
    }
}
