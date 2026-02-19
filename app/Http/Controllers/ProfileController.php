<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama_user' => ['required', 'string', 'max:255'],
            'email_user' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email_user')->ignore($user->id_user, 'id_user'),
            ],
            'nama_perusahaan' => ['nullable', 'string', 'max:255'],
            'nomor_telepon' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
        ]);

        $user->forceFill([
            'nama_user' => $validated['nama_user'],
            'email_user' => $validated['email_user'],
            'nama_perusahaan' => $validated['nama_perusahaan'] ?? null,
            'nomor_telepon' => $validated['nomor_telepon'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
        ])->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
