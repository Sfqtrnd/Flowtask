<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Modul;
use App\Models\Submission;
use App\Models\PersonalTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  /**
   * Tampilkan dashboard sesuai role user.
   */
  public function index()
  {
    $user = Auth::user();

    if ($user->role === 'mahasiswa') {
      // Statistik Mahasiswa
      $totalPersonalTasks = PersonalTask::where('mahasiswa_id', $user->id)->count();
      $completedPersonalTasks = PersonalTask::where('mahasiswa_id', $user->id)
        ->where('status', 'Selesai')
        ->count();
      $totalSubmissions = Submission::where('mahasiswa_id', $user->id)->count();
      $acceptedSubmissions = Submission::where('mahasiswa_id', $user->id)
        ->where('status_pengumpulan', 'Diterima')
        ->count();

      // Data Tugas Pribadi Terbaru (limit 3)
      $recentPersonalTasks = PersonalTask::where('mahasiswa_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get(['id', 'judul as title', 'deskripsi', 'status', 'created_at', 'updated_at']);

      // Data Deadline Praktikum Terdekat (limit 3)
      $upcomingDeadlines = Submission::join('moduls', 'submissions.modul_id', '=', 'moduls.id')
        ->where('submissions.mahasiswa_id', $user->id)
        ->select([
          'moduls.nama_modul as modul',  
          'submissions.updated_at as tanggal_kirim',
          'submissions.status_pengumpulan as status'
        ])
        ->orderBy('moduls.deadline', 'asc')
        ->take(3)
        ->get()
        ->map(function ($row) {
          return [
            'modul' => $row->modul,
            'deadline' => $row->modul_deadline ?? null,
            'status' => $row->status,
            'tgl' => date('Y-m-d', strtotime($row->tanggal_kirim)),
          ];
        });

      // Data Notifikasi Penilaian (limit 3)
      $notifications = Submission::where('mahasiswa_id', $user->id)
        ->whereIn('status_pengumpulan', ['Diterima', 'Revisi', 'Ditolak'])
        ->orderBy('updated_at', 'desc')
        ->take(3)
        ->get(['id', 'status_pengumpulan as status', 'updated_at as tanggal', 'modul_id'])
        ->map(function ($row) {
          return [
            'judul' => Modul::find($row->modul_id)->nama_modul ?? '-',
            'status' => $row->status,
            'tanggal' => date('Y-m-d', strtotime($row->tanggal)),
            'id' => $row->id,
          ];
        });
        $submissions = Submission::where('mahasiswa_id', Auth::id())
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      return view('mahasiswa.dashboard', compact(
        'totalPersonalTasks',
        'completedPersonalTasks',
        'totalSubmissions',
        'acceptedSubmissions',
        'recentPersonalTasks',
        'upcomingDeadlines',
        'notifications',
        'submissions'
      ));
    }

    // Jika role = asdos
    if ($user->role === 'asdos') {
      // Jumlah kelas yang dibuat asdos
      $kelasCount = Kelas::where('asdos_id', $user->id)->count();

      // Jumlah modul di semua kelas milik asdos
      $moduleCount = Modul::whereIn('kelas_id', function ($query) use ($user) {
        $query->select('id')
          ->from('kelas')
          ->where('asdos_id', $user->id);
      })->count();

      // Total pengumpulan (submission) di semua modul yang dibuat asdos
      $submissionCount = Submission::whereIn('modul_id', function ($query) use ($user) {
        $query->select('id')
          ->from('moduls')
          ->whereIn('kelas_id', function ($q) use ($user) {
            $q->select('id')
              ->from('kelas')
              ->where('asdos_id', $user->id);
          });
      })->count();

      // Total tunggu review
      $pendingCount = Submission::whereIn('modul_id', function ($query) use ($user) {
        $query->select('id')
          ->from('moduls')
          ->whereIn('kelas_id', function ($q) use ($user) {
            $q->select('id')
              ->from('kelas')
              ->where('asdos_id', $user->id);
          });
      })
        ->where('status_pengumpulan', 'Menunggu Nilai')
        ->count();

      // Daftar 3 kelas terbaru (nama, jumlah mahasiswa, jumlah modul)
      $recentClasses = Kelas::where('asdos_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get()
        ->map(function ($row) {
          return [
            'id' => $row->id,
            'nama_kelas' => $row->nama_kelas,
            'mahasiswa' => Submission::whereIn('modul_id', function ($q) use ($row) {
              $q->select('id')
                ->from('moduls')
                ->where('kelas_id', $row->id);
            })->distinct('mahasiswa_id')->count(),
            'modul' => Modul::where('kelas_id', $row->id)->count(),
          ];
        });

      // Daftar 3 pengumpulan terbaru
      $recentSubmissions = Submission::whereIn('modul_id', function ($query) use ($user) {
        $query->select('id')
          ->from('moduls')
          ->whereIn('kelas_id', function ($q) use ($user) {
            $q->select('id')
              ->from('kelas')
              ->where('asdos_id', $user->id);
          });
      })
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get()
        ->map(function ($row) {
          return [
            'id' => $row->id,
            'mahasiswa' => User::find($row->mahasiswa_id)->name ?? '-',
            'modul' => Modul::find($row->modul_id)->nama_modul ?? '-',
            'tgl' => date('d M, Y', strtotime($row->created_at)),
          ];
        });

      return view('asdos.dashboard', compact(
        'kelasCount',
        'moduleCount',
        'submissionCount',
        'pendingCount',
        'recentClasses',
        'recentSubmissions'
      ));
    }

    // Jika role lain (tidak diharapkan), logout
    Auth::logout();
    return redirect('/login');
  }
}
