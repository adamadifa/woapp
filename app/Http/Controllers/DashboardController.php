<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redirect users to their respective dashboards based on role.
     */
    public function index(): RedirectResponse
    {
        $user = Auth::user();

        // Safety check if user is not active
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda dinonaktifkan oleh administrator.',
            ]);
        }

        switch ($user->role) {
            case 'super_admin':
                return redirect()->route('admin.dashboard');
            case 'wo':
                return redirect()->route('wo.dashboard');
            case 'client':
                return redirect()->route('client.dashboard');
            default:
                Auth::logout();
                return redirect()->route('login');
        }
    }
}
