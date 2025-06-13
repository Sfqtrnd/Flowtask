@extends('layouts.app')

@section('title', 'Unggah Tugas Praktikum - FlowTask')

@section('content')
<div class="px-6 py-4 max-w-lg mx-auto">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Unggah Tugas: {{ $modul->nama_modul }}</h2>

  @if($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
      <ul class="list-disc list-inside">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('mahasiswa.submissions.store', $modul->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-4">
      <label for="judul_tugas" class="block text-gray-700 font-medium mb-2">Judul Tugas</label>
      <input type="text" id="judul_tugas" name="judul_tugas" value="{{ old('judul_tugas') }}"
             class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
    </div>

    <div class="mb-4">
      <label for="deskripsi_tugas" class="block text-gray-700 font-medium mb-2">Deskripsi (opsional)</label>
      <textarea id="deskripsi_tugas" name="deskripsi_tugas" rows="4"
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('deskripsi_tugas') }}</textarea>
    </div>

    <div class="mb-4">
      <label for="file" class="block text-gray-700 font-medium mb-2">Pilih File</label>
      <input type="file" id="file" name="file" 
             class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
      <p class="text-xs text-gray-400 mt-1">Maks 10MB</p>
    </div>

    <div class="flex justify-end">
      <a href="{{ route('mahasiswa.submissions.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg mr-2">Batal</a>
      <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">Unggah</button>
    </div>
  </form>
</div>
@endsection
