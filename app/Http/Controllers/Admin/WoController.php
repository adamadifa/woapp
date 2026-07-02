<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WoProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WoController extends Controller
{
    /**
     * Display a listing of Wedding Organizers.
     */
    public function index(Request $request): View
    {
        $query = WoProfile::with('user');

        // Search by business name or user email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by subscription plan
        if ($request->filled('plan')) {
            $query->where('subscription_plan', $request->plan);
        }

        // Filter by active status
        if ($request->filled('status')) {
            $status = $request->status;
            $query->whereHas('user', function ($uq) use ($status) {
                $uq->where('is_active', $status === 'active');
            });
        }

        $wos = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.wo.index', compact('wos'));
    }

    /**
     * Display the specified Wedding Organizer details.
     */
    public function show(WoProfile $wo): View
    {
        $wo->load(['user', 'clients', 'projects']);
        
        $stats = [
            'total_clients' => $wo->clients->count(),
            'total_projects' => $wo->projects->count(),
            'active_projects' => $wo->projects->whereIn('status', ['planning', 'ongoing'])->count(),
        ];

        return view('admin.wo.show', compact('wo', 'stats'));
    }

    /**
     * Toggle the active status of the WO's user account (Suspend/Activate).
     */
    public function toggleStatus(WoProfile $wo): RedirectResponse
    {
        $user = $wo->user;

        if ($user) {
            $user->update([
                'is_active' => !$user->is_active
            ]);

            $statusText = $user->is_active ? 'diaktifkan kembali' : 'ditangguhkan (suspended)';
            return redirect()->back()->with('success', "Akun WO {$wo->business_name} berhasil {$statusText}.");
        }

        return redirect()->back()->with('error', 'Gagal mengubah status akun WO.');
    }

    /**
     * Delete the specified Wedding Organizer profile and user account.
     */
    public function destroy(WoProfile $wo): RedirectResponse
    {
        $user = $wo->user;

        \Illuminate\Support\Facades\DB::transaction(function () use ($wo, $user) {
            $wo->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('admin.wo.index')->with('success', 'Data Wedding Organizer berhasil dihapus.');
    }
}
