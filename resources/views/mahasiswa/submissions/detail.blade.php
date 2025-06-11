{{-- resources/views/mahasiswa/submissions/detail.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Pengumpulan - FlowTask')

@section('content')
<div class="px-6 py-4 max-w-2xl mx-auto space-y-6">
  <h2 class="text-2xl font-semibold text-gray-800">Detail Pengumpulan</h2>

  <div class="bg-white bg-opacity-60 backdrop-blur-md rounded-xl shadow p-6 space-y-4">
    <p><strong>Modul:</strong> {{ $submission->modul->nama_modul }}</p>
    <p><strong>Judul Tugas:</strong> {{ $submission->judul_tugas }}</p>
    <p>
      <strong>File Tugas:</strong>
      <a href="{{ Storage::url($submission->file_path) }}" target="_blank"
         class="text-indigo-600 hover:underline inline-flex items-center">
         <i class="bi bi-download mr-1"></i> Unduh
      </a>
    </p>
    <p><strong>Tanggal Unggah:</strong> {{ $submission->created_at->format('d M, Y H:i') }}</p>
    <p>
      <strong>Status:</strong>
      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
        {{ $submission->status_pengumpulan == 'Diterima'  ? 'bg-green-100 text-green-800'
          : ($submission->status_pengumpulan == 'Ditolak'  ? 'bg-red-100 text-red-800'
          : 'bg-yellow-100 text-yellow-800') }}">
        {{ $submission->status_pengumpulan }}
      </span>
    </p>
    @if($submission->komentar_asdos)
      <div>
        <strong>Komentar Asdos:</strong>
        <p class="mt-2 text-gray-700">{{ $submission->komentar_asdos }}</p>
      </div>
    @endif
  </div>

  <div class="flex justify-end">
    <a href="{{ route('mahasiswa.submissions.index') }}"
       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg">
      Kembali
    </a>
  </div>
</div>
@endsection
