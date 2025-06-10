<?php
// app/Http/Controllers/Asdos/SubmissionReviewController.php

namespace App\Http\Controllers\Asdos;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Modul;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionReviewController extends Controller
{
    /**
     * Tampilkan semua submission yang statusnya 'Menunggu Nilai' 
     * untuk semua modul di kelas milik asdos.
     */
    public function waiting()
    {
        $asdosId = Auth::id();

        // Ambil semua submission yang perlu direview
        $submissions = Submission::where('status_pengumpulan', 'Menunggu Nilai')
            ->whereIn('modul_id', function ($q) use ($asdosId) {
                $q->select('id')
                  ->from('modul')
                  ->whereIn('kelas_id', function ($qq) use ($asdosId) {
                      $qq->select('id')
                         ->from('kelas')
                         ->where('asdos_id', $asdosId);
                  });
            })
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('asdos.submissions.index', compact('submissions'));
    }

    /**
     * Tampilkan semua submission yang sudah diberi review 
     * (status != 'Menunggu Nilai').
     */
    public function history()
    {
        $asdosId = Auth::id();

        $submissions = Submission::where('status_pengumpulan', '!=', 'Menunggu Nilai')
            ->whereIn('modul_id', function ($q) use ($asdosId) {
                $q->select('id')
                  ->from('modul')
                  ->whereIn('kelas_id', function ($qq) use ($asdosId) {
                      $qq->select('id')
                         ->from('kelas')
                         ->where('asdos_id', $asdosId);
                  });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('asdos.submissions.history', compact('submissions'));
    }

    /**
     * Tampilkan form review untuk satu submission tertentu.
     */
    public function reviewForm($id)
    {
        $submission = Submission::findOrFail($id);
        // Pastikan submission memang milik kelas asdos ini
        if (!$this->isOwnedByAsdos($submission)) {
            abort(403);
        }
        return view('asdos.submissions.review', compact('submission'));
    }

    /**
     * Proses update status dan komentar untuk satu submission.
     */
    public function review(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);
        if (!$this->isOwnedByAsdos($submission)) {
            abort(403);
        }

        $data = $request->validate([
            'status_pengumpulan' => 'required|in:Diterima,Revisi,Ditolak',
            'komentar_asdos'     => 'nullable|string',
        ]);

        $submission->update([
            'status_pengumpulan' => $data['status_pengumpulan'],
            'komentar_asdos'     => $data['komentar_asdos'] ?? null,
        ]);

        return redirect()->route('asdos.submissions.waiting')
                         ->with('success', 'Review tugas berhasil disimpan.');
    }

    /**
     * Proses hapus submission yang tidak valid.
     */
    public function destroy($id)
    {
        $submission = Submission::findOrFail($id);
        if (!$this->isOwnedByAsdos($submission)) {
            abort(403);
        }

        // Hapus file fisik jika ada
        if ($submission->file_path && \Storage::disk('public')->exists($submission->file_path)) {
            \Storage::disk('public')->delete($submission->file_path);
        }

        $submission->delete();
        return redirect()->back()->with('success', 'Submission berhasil dihapus.');
    }

    /**
     * Helper: Periksa apakah $submission milik asdos yang sedang login.
     */
    private function isOwnedByAsdos(Submission $submission): bool
    {
        $asdosId = Auth::id();
        $modul = Modul::find($submission->modul_id);
        if (!$modul) {
            return false;
        }
        $kelas = Kelas::find($modul->kelas_id);
        if (!$kelas) {
            return false;
        }
        return ($kelas->asdos_id === $asdosId);
    }
}
