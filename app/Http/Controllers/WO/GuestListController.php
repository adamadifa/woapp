<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\GuestList;
use App\Models\WeddingProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GuestListController extends Controller
{
    /**
     * Store a newly created guest in storage.
     */
    public function store(Request $request, WeddingProject $project): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'rsvp_status' => ['required', 'in:pending,confirmed,declined'],
            'guest_count' => ['required', 'integer', 'min:1'],
            'seat_number' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $project->guestList()->create($request->all());

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'guests'])
            ->with('success', 'Tamu undangan berhasil ditambahkan.');
    }

    /**
     * Update the specified guest in storage.
     */
    public function update(Request $request, WeddingProject $project, GuestList $guest): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'rsvp_status' => ['required', 'in:pending,confirmed,declined'],
            'guest_count' => ['required', 'integer', 'min:1'],
            'seat_number' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $guest->update($request->all());

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'guests'])
            ->with('success', 'Data tamu undangan berhasil diperbarui.');
    }

    /**
     * Remove the specified guest from storage.
     */
    public function destroy(WeddingProject $project, GuestList $guest): RedirectResponse
    {
        $guest->delete();

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'guests'])
            ->with('success', 'Tamu undangan berhasil dihapus.');
    }

    /**
     * Import guests from a CSV file.
     */
    public function importCsv(Request $request, WeddingProject $project): RedirectResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        if (($handle = fopen($path, 'r')) !== false) {
            // Read header row
            $header = fgetcsv($handle, 1000, ',');
            
            // If comma separator returned only one element, check if semicolon separator is used
            if ($header && count($header) == 1 && str_contains($header[0], ';')) {
                rewind($handle);
                $header = fgetcsv($handle, 1000, ';');
                $separator = ';';
            } else {
                $separator = ',';
            }

            // Clean header values
            $header = array_map(function($h) {
                return strtolower(trim(str_replace('"', '', $h)));
            }, $header);

            // Map columns
            $nameIdx = array_search('nama', $header);
            if ($nameIdx === false) $nameIdx = array_search('name', $header);
            
            $catIdx = array_search('kategori', $header);
            if ($catIdx === false) $catIdx = array_search('category', $header);
            
            $rsvpIdx = array_search('rsvp', $header);
            if ($rsvpIdx === false) $rsvpIdx = array_search('rsvp_status', $header);
            
            $countIdx = array_search('jumlah', $header);
            if ($countIdx === false) $countIdx = array_search('guest_count', $header);
            
            $seatIdx = array_search('kursi', $header);
            if ($seatIdx === false) $seatIdx = array_search('seat_number', $header);
            
            $notesIdx = array_search('catatan', $header);
            if ($notesIdx === false) $notesIdx = array_search('notes', $header);

            // If no headers matched, assume default indices: Name=0, Category=1, RSVP=2, Count=3, Seat=4, Notes=5
            if ($nameIdx === false) $nameIdx = 0;
            if ($catIdx === false) $catIdx = 1;
            if ($rsvpIdx === false) $rsvpIdx = 2;
            if ($countIdx === false) $countIdx = 3;
            if ($seatIdx === false) $seatIdx = 4;
            if ($notesIdx === false) $notesIdx = 5;

            $imported = 0;
            while (($row = fgetcsv($handle, 1000, $separator)) !== false) {
                // Ensure name column is filled
                $name = isset($row[$nameIdx]) ? trim($row[$nameIdx]) : '';
                if (empty($name)) continue;

                $category = isset($row[$catIdx]) ? trim($row[$catIdx]) : 'Umum';
                
                // Parse RSVP status
                $rsvp = 'pending';
                if (isset($row[$rsvpIdx])) {
                    $val = strtolower(trim($row[$rsvpIdx]));
                    if (in_array($val, ['confirmed', 'hadir', 'yes', 'y'])) {
                        $rsvp = 'confirmed';
                    } elseif (in_array($val, ['declined', 'tidak hadir', 'no', 'n'])) {
                        $rsvp = 'declined';
                    }
                }

                // Parse Guest count
                $count = isset($row[$countIdx]) ? (int) $row[$countIdx] : 1;
                if ($count < 1) $count = 1;

                $seat = isset($row[$seatIdx]) ? trim($row[$seatIdx]) : null;
                $notes = isset($row[$notesIdx]) ? trim($row[$notesIdx]) : null;

                $project->guestList()->create([
                    'name' => $name,
                    'category' => $category,
                    'rsvp_status' => $rsvp,
                    'guest_count' => $count,
                    'seat_number' => $seat,
                    'notes' => $notes,
                ]);

                $imported++;
            }
            fclose($handle);

            return redirect()->route('wo.projects.show', [$project, 'tab' => 'guests'])
                ->with('success', "$imported data tamu berhasil di-import.");
        }

        return redirect()->route('wo.projects.show', [$project, 'tab' => 'guests'])
            ->with('error', 'Gagal memproses file CSV.');
    }

    /**
     * Export guests to a CSV file.
     */
    public function exportCsv(WeddingProject $project): StreamedResponse
    {
        $guests = $project->guestList()->orderBy('name')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="daftar_tamu_' . strtolower(str_replace(' ', '_', $project->name)) . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($guests) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for proper Excel encoding
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, ['Nama', 'Kategori', 'RSVP Status', 'Jumlah Tamu', 'Nomor Kursi', 'Catatan']);

            foreach ($guests as $guest) {
                // Translate RSVP status for export readability
                $rsvp = match($guest->rsvp_status) {
                    'confirmed' => 'Hadir',
                    'declined' => 'Tidak Hadir',
                    default => 'Belum Konfirmasi'
                };

                fputcsv($file, [
                    $guest->name,
                    $guest->category,
                    $rsvp,
                    $guest->guest_count,
                    $guest->seat_number,
                    $guest->notes
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
