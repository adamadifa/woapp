<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\ProjectChecklist;
use App\Models\WeddingProject;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Store a newly created checklist item in storage.
     */
    public function store(Request $request, WeddingProject $project): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'due_date' => ['nullable', 'date'],
        ]);

        $project->checklists()->create([
            'name' => $request->name,
            'category' => $request->category,
            'due_date' => $request->due_date,
            'status' => 'todo',
        ]);

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'checklist'])
            ->with('success', 'Item checklist berhasil ditambahkan.');
    }

    /**
     * Update the specified checklist item in storage.
     */
    public function update(Request $request, WeddingProject $project, ProjectChecklist $checklist): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'due_date' => ['nullable', 'date'],
        ]);

        $checklist->update($request->only(['name', 'category', 'due_date']));

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'checklist'])
            ->with('success', 'Item checklist berhasil diperbarui.');
    }

    /**
     * Remove the specified checklist item from storage.
     */
    public function destroy(WeddingProject $project, ProjectChecklist $checklist): RedirectResponse
    {
        $checklist->delete();

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'checklist'])
            ->with('success', 'Item checklist berhasil dihapus.');
    }

    /**
     * Toggle the checklist status (todo/done).
     */
    public function toggleStatus(WeddingProject $project, ProjectChecklist $checklist): RedirectResponse
    {
        $newStatus = $checklist->status === 'done' ? 'todo' : 'done';
        $checklist->update(['status' => $newStatus]);

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'checklist'])
            ->with('success', 'Status checklist berhasil diperbarui.');
    }

    /**
     * Generate template checklist items for a project.
     */
    public function generateTemplate(WeddingProject $project): RedirectResponse
    {
        // Clear existing checklist items
        $project->checklists()->delete();

        // Calculate helper dates based on wedding date
        $weddingDate = Carbon::parse($project->wedding_date);

        // Predefined template checklists
        $template = [
            // Dokumen & Administrasi
            ['name' => 'Menyiapkan Fotokopi KTP & KK Mempelai & Orang Tua', 'category' => 'Dokumen', 'days_before' => 120],
            ['name' => 'Mengurus Surat Pengantar Pengantar Nikah (N1-N4) dari Kelurahan', 'category' => 'Dokumen', 'days_before' => 90],
            ['name' => 'Pendaftaran Resmi Pernikahan ke KUA / Catatan Sipil', 'category' => 'Dokumen', 'days_before' => 60],
            ['name' => 'Melakukan Pemeriksaan Kesehatan / Imunisasi Catin', 'category' => 'Dokumen', 'days_before' => 30],

            // Pembayaran & Keuangan
            ['name' => 'Membayar DP (Down Payment) Venue Pernikahan', 'category' => 'Pembayaran', 'days_before' => 180],
            ['name' => 'Membayar DP Vendor Utama (Catering, Dekorasi, MUA)', 'category' => 'Pembayaran', 'days_before' => 120],
            ['name' => 'Menyelesaikan Pelunasan Seluruh Vendor Mitra', 'category' => 'Pembayaran', 'days_before' => 14],
            ['name' => 'Menyiapkan Amplop Tips / Uang Cash Hari-H', 'category' => 'Pembayaran', 'days_before' => 3],

            // Persiapan Acara & Logistik
            ['name' => 'Melakukan Food Testing Menu Catering', 'category' => 'Persiapan', 'days_before' => 90],
            ['name' => 'Melakukan Fitting Busana Pengantin (Perdana)', 'category' => 'Persiapan', 'days_before' => 65],
            ['name' => 'Melakukan Fitting Busana Pengantin (Final)', 'category' => 'Persiapan', 'days_before' => 15],
            ['name' => 'Finalisasi Undangan Fisik & Digital', 'category' => 'Persiapan', 'days_before' => 60],
            ['name' => 'Konfirmasi Jumlah RSVP Final Tamu Undangan', 'category' => 'Persiapan', 'days_before' => 14],
            ['name' => 'Technical Meeting (TM) Bersama Seluruh Vendor & Venue', 'category' => 'Persiapan', 'days_before' => 7],
            ['name' => 'Gladi Resik (GR) Prosesi Akad/Pemberkatan & Resepsi', 'category' => 'Persiapan', 'days_before' => 1],
        ];

        foreach ($template as $item) {
            $dueDate = $weddingDate->copy()->subDays($item['days_before'])->format('Y-m-d');
            $project->checklists()->create([
                'name' => $item['name'],
                'category' => $item['category'],
                'due_date' => $dueDate,
                'status' => 'todo',
            ]);
        }

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'checklist'])
            ->with('success', 'Template checklist standar berhasil diterapkan.');
    }
}
