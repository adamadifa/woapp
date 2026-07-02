<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\RundownItem;
use App\Models\WeddingProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RundownController extends Controller
{
    /**
     * Store a newly created rundown item.
     */
    public function store(Request $request, WeddingProject $project): RedirectResponse
    {
        $request->validate([
            'time_start' => ['required', 'date_format:H:i'],
            'time_end' => ['required', 'date_format:H:i', 'after:time_start'],
            'activity' => ['required', 'string', 'max:255'],
            'pic' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $project->rundownItems()->create($request->all());

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'rundown'])
            ->with('success', 'Aktivitas rundown berhasil ditambahkan.');
    }

    /**
     * Update the specified rundown item.
     */
    public function update(Request $request, WeddingProject $project, RundownItem $rundown): RedirectResponse
    {
        $request->validate([
            'time_start' => ['required', 'date_format:H:i'],
            'time_end' => ['required', 'date_format:H:i', 'after:time_start'],
            'activity' => ['required', 'string', 'max:255'],
            'pic' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $rundown->update($request->all());

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'rundown'])
            ->with('success', 'Aktivitas rundown berhasil diperbarui.');
    }

    /**
     * Remove the specified rundown item.
     */
    public function destroy(WeddingProject $project, RundownItem $rundown): RedirectResponse
    {
        $rundown->delete();

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'rundown'])
            ->with('success', 'Aktivitas rundown berhasil dihapus.');
    }

    /**
     * Generate template rundown items.
     */
    public function generateTemplate(WeddingProject $project): RedirectResponse
    {
        // Clear existing rundown
        $project->rundownItems()->delete();

        // Standard default rundown template items
        $templateItems = [
            [
                'time_start' => '08:00',
                'time_end' => '09:30',
                'activity' => 'Makeup & Persiapan Mempelai',
                'pic' => 'Koordinator MUA',
                'notes' => 'Mempelai wanita & pria dirias di kamar hotel/ruang rias venue. Tim dokumentasi standby.',
                'order' => 1
            ],
            [
                'time_start' => '09:30',
                'time_end' => '10:00',
                'activity' => 'Sesi Foto & Video Detail (Pre-Wedding Day)',
                'pic' => 'Koordinator Dokumentasi',
                'notes' => 'Foto gaun, cincin, flatlay aksesoris, dan portrait mempelai.',
                'order' => 2
            ],
            [
                'time_start' => '10:00',
                'time_end' => '11:00',
                'activity' => 'Upacara Akad Nikah / Pemberkatan',
                'pic' => 'Koordinator Akad / Sakral',
                'notes' => 'Prosesi ijab kabul/pemberkatan sakral. Keluarga, saksi, wali, dan penghulu siap di meja akad.',
                'order' => 3
            ],
            [
                'time_start' => '11:00',
                'time_end' => '11:30',
                'activity' => 'Sesi Foto Bersama Keluarga Besar',
                'pic' => 'MC & Runner',
                'notes' => 'Foto bergantian per kelompok keluarga inti dan keluarga besar.',
                'order' => 4
            ],
            [
                'time_start' => '11:30',
                'time_end' => '13:00',
                'activity' => 'Istirahat, Makan Siang & Touch Up Resepsi',
                'pic' => 'Koordinator MUA & Catering',
                'notes' => 'Mempelai makan siang, ganti baju resepsi & touch up makeup. Pembagian makan siang kru & panitia.',
                'order' => 5
            ],
            [
                'time_start' => '13:00',
                'time_end' => '15:00',
                'activity' => 'Resepsi Pernikahan (Grand Entrance & Sesi Salaman)',
                'pic' => 'Koordinator Resepsi / WO Team',
                'notes' => 'Keluarga dan mempelai kirab masuk. Catering stand-by, live music dimulai, dan tamu bersalaman.',
                'order' => 6
            ],
            [
                'time_start' => '15:00',
                'time_end' => '15:30',
                'activity' => 'Lempar Bouquet & Foto Bersama Rekan/Teman',
                'pic' => 'MC / Entertainment Coordinator',
                'notes' => 'Games lempar bunga, disusul foto bersama teman-teman kerja dan sahabat mempelai.',
                'order' => 7
            ],
            [
                'time_start' => '15:30',
                'time_end' => '16:00',
                'activity' => 'Penutupan Acara & Clear Area',
                'pic' => 'WO Team / Venue Coordinator',
                'notes' => 'Resepsi selesai. MC menutup acara. Serah terima sisa katering & kado ke perwakilan keluarga.',
                'order' => 8
            ]
        ];

        foreach ($templateItems as $item) {
            $project->rundownItems()->create($item);
        }

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'rundown'])
            ->with('success', 'Template rundown standar berhasil diterapkan.');
    }

    /**
     * Print-friendly rundown view.
     */
    public function print(WeddingProject $project): View
    {
        $project->load(['client', 'venue']);
        $rundownItems = $project->rundownItems()->orderBy('time_start')->get();

        return view('wo.projects.rundown.print', compact('project', 'rundownItems'));
    }
}
