<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\BudgetItem;
use App\Models\WeddingProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BudgetItemController extends Controller
{
    /**
     * Store a newly created budget item in storage.
     */
    public function store(Request $request, WeddingProject $project): RedirectResponse
    {
        $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'vendor_id' => ['nullable', 'exists:vendors,id'],
            'description' => ['nullable', 'string', 'max:255'],
            'estimated_cost' => ['required', 'numeric', 'min:0'],
            'actual_cost' => ['required', 'numeric', 'min:0'],
            'payment_status' => ['required', 'in:unpaid,dp,paid'],
            'payment_proof' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->all();
        $data['project_id'] = $project->id;

        // Handle payment proof upload
        if ($request->hasFile('payment_proof')) {
            $data['payment_proof'] = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        BudgetItem::create($data);

        return redirect()->route('wo.projects.show', $project)->with('success', 'Item budget berhasil ditambahkan.');
    }

    /**
     * Update the specified budget item in storage.
     */
    public function update(Request $request, WeddingProject $project, BudgetItem $budgetItem): RedirectResponse
    {
        $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'vendor_id' => ['nullable', 'exists:vendors,id'],
            'description' => ['nullable', 'string', 'max:255'],
            'estimated_cost' => ['required', 'numeric', 'min:0'],
            'actual_cost' => ['required', 'numeric', 'min:0'],
            'payment_status' => ['required', 'in:unpaid,dp,paid'],
            'payment_proof' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->all();

        // Handle payment proof upload
        if ($request->hasFile('payment_proof')) {
            // Delete old proof
            if ($budgetItem->payment_proof) {
                Storage::disk('public')->delete($budgetItem->payment_proof);
            }
            $data['payment_proof'] = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        $budgetItem->update($data);

        return redirect()->route('wo.projects.show', $project)->with('success', 'Item budget berhasil diperbarui.');
    }

    /**
     * Remove the specified budget item from storage.
     */
    public function destroy(WeddingProject $project, BudgetItem $budgetItem): RedirectResponse
    {
        if ($budgetItem->payment_proof) {
            Storage::disk('public')->delete($budgetItem->payment_proof);
        }
        
        $budgetItem->delete();

        return redirect()->route('wo.projects.show', $project)->with('success', 'Item budget berhasil dihapus.');
    }

    /**
     * Export budget items to PDF (Printable view)
     */
    public function exportPdf(WeddingProject $project): \Illuminate\View\View
    {
        $project->load(['client', 'venue']);
        $budgetItems = $project->budgetItems()->with('vendor')->get();
        $allocatedBudget = $budgetItems->sum('estimated_cost');
        $actualCost = $budgetItems->sum('actual_cost');
        $remainingTarget = $project->total_budget - $allocatedBudget;

        return view('wo.projects.budget-pdf', compact('project', 'budgetItems', 'allocatedBudget', 'actualCost', 'remainingTarget'));
    }

    /**
     * Export budget items to Excel (CSV format)
     */
    public function exportExcel(WeddingProject $project)
    {
        $budgetItems = $project->budgetItems()->with('vendor')->get();
        $filename = "budget-report-" . $project->id . "-" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Category', 'Vendor', 'Description', 'Estimated Cost', 'Actual Cost', 'Payment Status'];

        $callback = function() use($budgetItems, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($budgetItems as $item) {
                fputcsv($file, [
                    $item->category,
                    $item->vendor->name ?? '-',
                    $item->description ?? '-',
                    $item->estimated_cost,
                    $item->actual_cost,
                    $item->payment_status
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
