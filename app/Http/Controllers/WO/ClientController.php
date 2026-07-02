<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use App\Models\WeddingPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index(): View
    {
        // Multitenantable scopes by wo_profile_id automatic
        $clients = Client::with(['user', 'package'])->orderBy('created_at', 'desc')->paginate(10);
        $packages = WeddingPackage::where('is_active', true)->orderBy('name')->get();

        return view('wo.clients.index', compact('clients', 'packages'));
    }

    /**
     * Store a newly created client.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'groom_name' => ['required', 'string', 'max:255'],
            'bride_name' => ['required', 'string', 'max:255'],
            'wedding_date' => ['required', 'date'],
            'phone' => ['nullable', 'string', 'max:50'],
            'package_id' => ['nullable', 'exists:wedding_packages,id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        // 1. Create client user account
        $user = User::create([
            'name' => $request->groom_name . ' & ' . $request->bride_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client',
            'tenant_id' => auth()->user()->tenant_id,
            'is_active' => true,
        ]);

        // 2. Create client record (wo_profile_id is filled by Multitenantable)
        Client::create([
            'user_id' => $user->id,
            'groom_name' => $request->groom_name,
            'bride_name' => $request->bride_name,
            'wedding_date' => $request->wedding_date,
            'phone' => $request->phone,
            'package_id' => $request->package_id,
        ]);

        return redirect()->route('wo.clients.index')->with('success', 'Klien dan akun login berhasil ditambahkan.');
    }

    /**
     * Update the specified client.
     */
    public function update(Request $request, Client $client): RedirectResponse
    {
        $request->validate([
            'groom_name' => ['required', 'string', 'max:255'],
            'bride_name' => ['required', 'string', 'max:255'],
            'wedding_date' => ['required', 'date'],
            'phone' => ['nullable', 'string', 'max:50'],
            'package_id' => ['nullable', 'exists:wedding_packages,id'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($client->user_id)],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        // 1. Update user credentials
        $userData = [
            'name' => $request->groom_name . ' & ' . $request->bride_name,
            'email' => $request->email,
        ];
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $client->user->update($userData);

        // 2. Update client details
        $client->update($request->only(['groom_name', 'bride_name', 'wedding_date', 'phone', 'package_id']));

        return redirect()->route('wo.clients.index')->with('success', 'Data klien berhasil diperbarui.');
    }

    /**
     * Remove the specified client.
     */
    public function destroy(Client $client): RedirectResponse
    {
        // User account will cascade delete thanks to DB schema cascade
        $client->delete();

        return redirect()->route('wo.clients.index')->with('success', 'Klien berhasil dihapus.');
    }
}
