<?php
// app/Http/Controllers/Mahasiswa/SubmissionController.php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    /**
     * Tampilkan daftar semua modul praktikum (opsional: bisa dibatasi ke kelas tertentu).
     */
    public function indexModules()
    {
        // Jika Anda ingin membatasi berdasarkan pendaftaran kelas, tambahkan relasi enroll. 
        // Untuk sekarang, tampilkan semua modul:
        $moduls = Modul::orderBy('deadline', 'asc')->paginate(10);
        return view('mahasiswa.submissions.index', compact('moduls'));
    }

    /**
     * Tampilkan form upload untuk modul tertentu.
     */
    public function showUploadForm($modulId)
    {
        $modul = Modul::findOrFail($modulId);
        return view('mahasiswa.submissions.upload', compact('modul'));
    }

    /**
     * Proses simpan submission baru.
     */
    public function store(Request $request, $modulId)
    {
        $modul = Modul::findOrFail($modulId);

        $data = $request->validate([
            'judul_tugas'    => 'required|string|max:255',
            'deskripsi_tugas'=> 'nullable|string',
            'file'           => 'required|file|max:10240', // max 10MB
        ]);

        // Simpan file ke storage/app/public/submissions
        $path = $request->file('file')->store('submissions', 'public');

        Submission::create([
            'modul_id'          => $modul->id,
            'mahasiswa_id'      => Auth::id(),
            'judul_tugas'       => $data['judul_tugas'],
            'deskripsi_tugas'   => $data['deskripsi_tugas'] ?? null,
            'file_path'         => $path,
            'status_pengumpulan'=> 'Menunggu Nilai',
        ]);

        return redirect()->route('mahasiswa.submissions.history')
                         ->with('success', 'Tugas praktikum berhasil diunggah.');
    }

    /**
     * Tampilkan riwayat pengumpulan tugas praktikum mahasiswa.
     */
    public function history()
    {
        $submissions = Submission::where('mahasiswa_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('mahasiswa.submissions.history', compact('submissions'));
    }

    /**
     * Tampilkan detail submission (beserta komentar asdos).
     */
    public function detail($id)
    {
        $submission = Submission::findOrFail($id);
        if ($submission->mahasiswa_id !== Auth::id()) {
            abort(403);
        }

        return view('mahasiswa.submissions.detail', compact('submission'));
    }

    /**
     * (Opsional) Proses hapus submission jika diizinkan.
     */
    public function destroy($id)
    {
        $submission = Submission::findOrFail($id);
        if ($submission->mahasiswa_id !== Auth::id()) {
            abort(403);
        }

        // Hapus file fisik jika ada
        if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
            Storage::disk('public')->delete($submission->file_path);
        }

        $submission->delete();
        return redirect()->route('mahasiswa.submissions.history')
                         ->with('success', 'Tugas praktikum berhasil dihapus.');
    }
}
