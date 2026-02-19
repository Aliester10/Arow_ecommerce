<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function adminsIndex(Request $request)
    {
        $search = $request->query('q');

        $admins = User::query()
            ->where('role_user', 'admin')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_user', 'like', '%' . $search . '%')
                        ->orWhere('email_user', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.admins.index', compact('admins', 'search'));
    }

    public function adminsCreate()
    {
        return view('admin.users.admins.create');
    }

    public function adminsStore(Request $request)
    {
        $validated = $request->validate([
            'nama_user' => 'required|string|max:255',
            'email_user' => 'required|email|max:255|unique:users,email_user',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'nama_user' => $validated['nama_user'],
            'email_user' => $validated['email_user'],
            'password_user' => Hash::make($validated['password']),
            'role_user' => 'admin',
        ]);

        return redirect()->route('admin.users.admins.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function membersIndex(Request $request)
    {
        $search = $request->query('q');

        $members = User::query()
            ->where('role_user', 'user')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_user', 'like', '%' . $search . '%')
                        ->orWhere('email_user', 'like', '%' . $search . '%')
                        ->orWhere('nama_perusahaan', 'like', '%' . $search . '%')
                        ->orWhere('nomor_telepon', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.members.index', compact('members', 'search'));
    }

    public function membersCreate()
    {
        return view('admin.users.members.create');
    }

    public function membersStore(Request $request)
    {
        $validated = $request->validate([
            'nama_user' => 'required|string|max:255',
            'email_user' => 'required|email|max:255|unique:users,email_user',
            'password' => 'required|string|min:8|confirmed',
            'nama_perusahaan' => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
        ]);

        User::create([
            'nama_user' => $validated['nama_user'],
            'email_user' => $validated['email_user'],
            'password_user' => Hash::make($validated['password']),
            'role_user' => 'user',
            'nama_perusahaan' => $validated['nama_perusahaan'] ?? null,
            'nomor_telepon' => $validated['nomor_telepon'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
        ]);

        return redirect()->route('admin.users.members.index')->with('success', 'Member berhasil ditambahkan.');
    }
}
