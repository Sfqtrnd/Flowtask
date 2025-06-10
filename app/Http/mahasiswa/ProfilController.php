<?php
// app/Http/Controllers/Mahasiswa/ProfilController.php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    /**
     * Tampilkan form edit profil.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('mahasiswa.profil.edit', compact('user'));
    }

    /**
     * Proses update profil (nama dan password).
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'nama'              => 'required|string|max:255',
            'password_lama'     => 'nullable|string',
            'password_baru'     => 'nullable|string|min:6|confirmed',
        ]);

        $user->nama = $data['nama'];

        if (!empty($data['password_lama']) && !empty($data['password_baru'])) {
            // Pastikan password_lama sesuai
            if (!Hash::check($data['password_lama'], $user->password)) {
                return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
            }
            $user->password = Hash::make($data['password_baru']);
        }

        $user->save();
        return redirect()->route('mahasiswa.profil.edit')
                         ->with('success', 'Profil berhasil diperbarui.');
    }
}
