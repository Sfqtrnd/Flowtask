<?php
// app/Http/Controllers/Mahasiswa/SubmissionController.php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
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
    $userId = Auth::id();
    $classes = Kelas::with('modul')->paginate(5);

    // Get all modules
    $moduls = Modul::orderBy('deadline', 'asc')->paginate(10);

    // For each module, check if user has already submitted
    $submissions = Submission::where('mahasiswa_id', $userId)
      ->select('id', 'modul_id')
      ->get()
      ->keyBy('modul_id')
      ->toArray();

    return view('mahasiswa.submissions.index', compact('moduls', 'submissions', 'classes'));
  }

  /**
   * Tampilkan form upload untuk modul tertentu.
   */
  public function showUploadForm($modulId)
  {
    $modul = Modul::findOrFail($modulId);

    // Check if user already has a submission for this module
    $existingSubmission = Submission::where('mahasiswa_id', Auth::id())
      ->where('modul_id', $modulId)
      ->first();

    if ($existingSubmission) {
      // Redirect to the submission detail
      return redirect()->route('mahasiswa.submissions.detail', $existingSubmission->id);
    }

    return view('mahasiswa.submissions.upload', compact('modul'));
  }

  /**
   * Proses simpan submission baru.
   */
  public function store(Request $request, $modulId)
  {
    $modul = Modul::findOrFail($modulId);

    $data = $request->validate([
      'judul_tugas' => 'required|string|max:255',
      'deskripsi_tugas' => 'nullable|string',
      'file' => 'required|file|max:10240', // max 10MB
    ]);

    // Laporan_{nama_kelas}_{nama_modul}_{name user}_{timestamp}.pdf
    $file         = $request->file('file');
    $extension    = $file->getClientOriginalExtension();
    $timestamp    = now()->format('Ymd_His');
    $filename     = "Laporan_{$modul->kelas->nama_kelas}_{$modul->nama_modul}_" . Auth::user()->name . "_{$timestamp}.{$extension}";

    // Simpan file ke storage/app/public/submissions
    $path = $file->storeAs('submissions', $filename, 'public'); 

    Submission::create([
      'modul_id' => $modul->id,
      'mahasiswa_id' => Auth::id(),
      'judul_tugas' => $data['judul_tugas'],
      'deskripsi_tugas' => $data['deskripsi_tugas'] ?? null,
      'file_path' => $path,
      'status_pengumpulan' => 'Menunggu Nilai',
    ]);

    return redirect()->route('mahasiswa.submissions.index')
      ->with('success', 'Tugas praktikum berhasil diunggah.');
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
    return redirect()->route('mahasiswa.submissions.index')
      ->with('success', 'Tugas praktikum berhasil dihapus.');
  }
}
