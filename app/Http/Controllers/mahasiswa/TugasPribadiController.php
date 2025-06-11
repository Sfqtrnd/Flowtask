<?php
// app/Http/Controllers/Mahasiswa/TugasPribadiController.php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PersonalTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasPribadiController extends Controller
{
    /**
     * Tampilkan daftar semua tugas pribadi milik mahasiswa yang login.
     */
    public function index()
    {
        $userId = Auth::id();
        $tasks = PersonalTask::where('mahasiswa_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('mahasiswa.tugas-pribadi.index', compact('tasks'));
    }

    /**
     * Tampilkan form untuk membuat tugas pribadi baru.
     */
    public function create()
    {
        return view('mahasiswa.tugas-pribadi.create');
    }

    /**
     * Proses simpan tugas pribadi baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status'    => 'required|in:Belum Mulai,Sedang Berjalan,Selesai',
        ]);

        PersonalTask::create([
            'mahasiswa_id' => Auth::id(),
            'judul'        => $data['judul'],
            'deskripsi'    => $data['deskripsi'] ?? null,
            'status'       => $data['status'],
        ]);

        return redirect()->route('mahasiswa.personal-tasks.index')
                         ->with('success', 'Tugas pribadi berhasil dibuat.');
    }

    /**
     * Tampilkan form untuk mengedit tugas pribadi.
     */
    public function edit($id)
    {
        $task = PersonalTask::findOrFail($id);

        // Pastikan hanya pemilik (mahasiswa) yang bisa edit
        if ($task->mahasiswa_id !== Auth::id()) {
            abort(403);
        }

        return view('mahasiswa.tugas-pribadi.edit', compact('task'));
    }

    /**
     * Proses update tugas pribadi.
     */
    public function update(Request $request, $id)
    {
        $task = PersonalTask::findOrFail($id);
        if ($task->mahasiswa_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status'    => 'required|in:Belum Mulai,Sedang Berjalan,Selesai',
        ]);

        $task->update([
            'judul'     => $data['judul'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'status'    => $data['status'],
        ]);

        return redirect()->route('mahasiswa.personal-tasks.index')
                         ->with('success', 'Tugas pribadi berhasil diperbarui.');
    }

    /**
     * Proses hapus tugas pribadi.
     */
    public function destroy($id)
    {
        $task = PersonalTask::findOrFail($id);
        if ($task->mahasiswa_id !== Auth::id()) {
            abort(403);
        }

        $task->delete();
        return redirect()->route('mahasiswa.personal-tasks.index')
                         ->with('success', 'Tugas pribadi berhasil dihapus.');
    }
}
