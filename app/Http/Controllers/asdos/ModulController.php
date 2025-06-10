<?php
// app/Http/Controllers/Asdos/ModulController.php

namespace App\Http\Controllers\Asdos;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModulController extends Controller
{
    /**
     * Tampilkan daftar modul untuk kelas tertentu.
     */
    public function index($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        if ($kelas->asdos_id !== Auth::id()) {
            abort(403);
        }

        $moduls = Modul::where('kelas_id', $kelas->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('asdos.modul.index', compact('kelas', 'moduls'));
    }

    /**
     * Tampilkan form tambah modul ke kelas tertentu.
     */
    public function create($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        if ($kelas->asdos_id !== Auth::id()) {
            abort(403);
        }

        return view('asdos.modul.create', compact('kelas'));
    }

    /**
     * Proses simpan modul baru.
     */
    public function store(Request $request, $kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        if ($kelas->asdos_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'nama_modul'     => 'required|string|max:255',
            'deskripsi_modul'=> 'nullable|string',
            'deadline'       => 'required|date',
        ]);

        Modul::create([
            'kelas_id'      => $kelas->id,
            'nama_modul'    => $data['nama_modul'],
            'deskripsi_modul'=> $data['deskripsi_modul'] ?? null,
            'deadline'      => $data['deadline'],
        ]);

        return redirect()->route('asdos.modul.index', $kelas->id)
                         ->with('success', 'Modul berhasil dibuat.');
    }

    /**
     * Tampilkan form edit modul.
     */
    public function edit($kelasId, $modulId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        if ($kelas->asdos_id !== Auth::id()) {
            abort(403);
        }

        $modul = Modul::findOrFail($modulId);
        if ($modul->kelas_id !== $kelas->id) {
            abort(404);
        }

        return view('asdos.modul.edit', compact('kelas', 'modul'));
    }

    /**
     * Proses update data modul.
     */
    public function update(Request $request, $kelasId, $modulId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        if ($kelas->asdos_id !== Auth::id()) {
            abort(403);
        }

        $modul = Modul::findOrFail($modulId);
        if ($modul->kelas_id !== $kelas->id) {
            abort(404);
        }

        $data = $request->validate([
            'nama_modul'     => 'required|string|max:255',
            'deskripsi_modul'=> 'nullable|string',
            'deadline'       => 'required|date',
        ]);

        $modul->update([
            'nama_modul'    => $data['nama_modul'],
            'deskripsi_modul'=> $data['deskripsi_modul'] ?? null,
            'deadline'      => $data['deadline'],
        ]);

        return redirect()->route('asdos.modul.index', $kelas->id)
                         ->with('success', 'Modul berhasil diperbarui.');
    }

    /**
     * Proses hapus modul.
     */
    public function destroy($kelasId, $modulId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        if ($kelas->asdos_id !== Auth::id()) {
            abort(403);
        }

        $modul = Modul::findOrFail($modulId);
        if ($modul->kelas_id !== $kelas->id) {
            abort(404);
        }

        $modul->delete();
        return redirect()->route('asdos.modul.index', $kelas->id)
                         ->with('success', 'Modul berhasil dihapus.');
    }
}
