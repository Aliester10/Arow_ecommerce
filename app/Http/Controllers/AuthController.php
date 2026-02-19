<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email_user' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            if (Schema::hasColumn('users', 'last_login_at') && Schema::hasColumn('users', 'last_login_ip')) {
                Auth::user()->forceFill([
                    'last_login_at' => now(),
                    'last_login_ip' => $request->ip(),
                ])->save();
            }

            if (Auth::user()->role_user === 'admin') {
                return redirect()->intended('admin/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email_user',
            'password' => 'required|string|min:8|confirmed',
            'nama_perusahaan' => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
        ]);

        $user = User::create([
            'nama_user' => $validated['name'],
            'email_user' => $validated['email'],
            'password_user' => Hash::make($validated['password']),
            'role_user' => 'user',
            'nama_perusahaan' => $validated['nama_perusahaan'] ?? null,
            'nomor_telepon' => $validated['nomor_telepon'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
