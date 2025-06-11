@extends('layouts.app')

@section('title', 'Review Tugas - FlowTask')

@section('content')
<div class="px-6 py-4 max-w-2xl mx-auto">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Review: {{ $submission->modul->nama_modul }}</h2>

  <div class="bg-white bg-opacity-60 backdrop-blur-md border border-white/20 rounded-xl shadow p-4 mb-6">
    <p><strong>Mahasiswa:</strong> {{ $submission->mahasiswa->name }}</p>
    <p><strong>Judul:</strong> {{ $submission->judul_tugas }}</p>
    <p class="mt-2"><a href="{{ Storage::url($submission->file_path) }}"
         target="_blank" class="text-indigo-600 hover:underline">
         <i class="bi bi-download mr-1"></i> Unduh File
    </a></p>
  </div>

  <form action="{{ route('asdos.submissions.review', $submission->id) }}" method="POST">
    @csrf

    <div class="mb-4">
      <label for="status_pengumpulan" class="block text-gray-700 font-medium mb-2">Status Penilaian</label>
      <select id="status_pengumpulan" name="status_pengumpulan"
              class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
        <option value="Diterima"    {{ old('status_pengumpulan', $submission->status_pengumpulan) == 'Diterima' ? 'selected' : '' }}>Diterima</option>
        <option value="Revisi"      {{ old('status_pengumpulan', $submission->status_pengumpulan) == 'Revisi'   ? 'selected' : '' }}>Revisi</option>
        <option value="Ditolak"     {{ old('status_pengumpulan', $submission->status_pengumpulan) == 'Ditolak'  ? 'selected' : '' }}>Ditolak</option>
      </select>
    </div>

    <div class="mb-4">
      <label for="komentar_asdos" class="block text-gray-700 font-medium mb-2">Komentar Asdos (opsional)</label>
      <textarea id="komentar_asdos" name="komentar_asdos" rows="4"
        class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
      >{{ old('komentar_asdos', $submission->komentar_asdos) }}</textarea>
    </div>

    <div class="flex justify-end space-x-2">
      <a href="{{ route('asdos.submissions.waiting') }}"
         class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg">
        Batal
      </a>
      <button type="submit"
              class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
        Simpan Review
      </button>
    </div>
  </form>
</div>
@endsection
