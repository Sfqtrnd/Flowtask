<?php
// app/Http/Controllers/Asdos/KelasController.php

namespace App\Http\Controllers\Asdos;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    /**
     * Tampilkan daftar semua kelas yang dibuat asdos.
     */
    public function index()
    {
        $kelasList = Kelas::where('asdos_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('asdos.kelas.index', compact('kelasList'));
    }

    /**
     * Tampilkan form tambah kelas.
     */
    public function create()
    {
        return view('asdos.kelas.create');
    }

    /**
     * Proses simpan kelas baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'semester'   => 'required|string',
        ]);

        Kelas::create([
            'nama_kelas' => $data['nama_kelas'],
            'semester'   => $data['semester'],
            'asdos_id'   => Auth::id(),
        ]);

        return redirect()->route('asdos.kelas.index')
                         ->with('success', 'Kelas praktikum berhasil dibuat.');
    }

    /**
     * Tampilkan form edit kelas.
     */
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        if ($kelas->asdos_id !== Auth::id()) {
            abort(403);
        }
        return view('asdos.kelas.edit', compact('kelas'));
    }

    /**
     * Proses update data kelas.
     */
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        if ($kelas->asdos_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'semester'   => 'required|string',
        ]);

        $kelas->update([
            'nama_kelas' => $data['nama_kelas'],
            'semester'   => $data['semester'],
        ]);

        return redirect()->route('asdos.kelas.index')
                         ->with('success', 'Kelas praktikum berhasil diperbarui.');
    }

    /**
     * Proses hapus kelas.
     */
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        if ($kelas->asdos_id !== Auth::id()) {
            abort(403);
        }

        $kelas->delete();
        return redirect()->route('asdos.kelas.index')
                         ->with('success', 'Kelas praktikum berhasil dihapus.');
    }
}
