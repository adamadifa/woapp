<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TeamController extends Controller
{
    /**
     * Display a listing of the team members.
     */
    public function index(): View
    {
        // TenantScope automatically scopes User queries by Auth::user()->tenant_id
        $team = User::where('role', 'wo')->orderBy('created_at', 'asc')->paginate(10);
        return view('wo.team.index', compact('team'));
    }

    /**
     * Store a newly created team member.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'sub_role' => ['required', 'in:admin,coordinator,assistant'],
        ]);

        $wo = auth()->user()->woProfile;
        $plan = \App\Models\Plan::where('slug', $wo->subscription_plan)->first();
        $maxTeamMembers = $plan ? $plan->max_team_members : 3;
        $teamCount = User::where('tenant_id', auth()->user()->tenant_id)->where('role', 'wo')->count();
        
        if ($maxTeamMembers !== -1 && $teamCount >= $maxTeamMembers) {
            return redirect()->back()->with('error', "Batas anggota tim untuk paket " . strtoupper($wo->subscription_plan) . " telah tercapai (Maks. {$maxTeamMembers}). Silakan upgrade paket langganan Anda.");
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'wo',
            'sub_role' => $request->sub_role,
            'tenant_id' => auth()->user()->tenant_id,
            'is_active' => true,
        ]);

        return redirect()->route('wo.team.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    /**
     * Update the specified team member.
     */
    public function update(Request $request, User $team): RedirectResponse
    {
        // Safety: don't let team members change own roles if they want, but let's allow general updates
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($team->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'sub_role' => ['required', 'in:admin,coordinator,assistant'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'sub_role' => $request->sub_role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $team->update($data);

        return redirect()->route('wo.team.index')->with('success', 'Data anggota tim berhasil diperbarui.');
    }

    /**
     * Remove the specified team member from storage.
     */
    public function destroy(User $team): RedirectResponse
    {
        // Don't allow deleting yourself
        if ($team->id === auth()->id()) {
            return redirect()->route('wo.team.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $team->delete();

        return redirect()->route('wo.team.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}
