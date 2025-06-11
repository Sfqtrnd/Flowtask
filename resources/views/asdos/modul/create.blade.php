@extends('layouts.app')

@section('title', 'Tambah Modul - FlowTask')

@section('content')
<div class="px-6 py-4 max-w-2xl mx-auto">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Modul untuk {{ $kelas->nama_kelas }}</h2>

  @if($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
      <ul class="list-disc list-inside">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('asdos.modul.store', $kelas->id) }}" method="POST">
    @csrf
    <div class="mb-4">
      <label for="nama_modul" class="block text-gray-700 font-medium mb-2">Nama Modul</label>
      <input type="text"
             id="nama_modul"
             name="nama_modul"
             value="{{ old('nama_modul') }}"
             class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
             required>
    </div>

    <div class="mb-4">
      <label for="deskripsi_modul" class="block text-gray-700 font-medium mb-2">Deskripsi (opsional)</label>
      <textarea id="deskripsi_modul"
                name="deskripsi_modul"
                rows="4"
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('deskripsi_modul') }}</textarea>
    </div>

    <div class="mb-4">
      <label for="deadline" class="block text-gray-700 font-medium mb-2">Deadline</label>
      <input type="date"
             id="deadline"
             name="deadline"
             value="{{ old('deadline') }}"
             class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
             required>
    </div>

    <div class="flex justify-end">
      <a href="{{ route('asdos.modul.index', $kelas->id) }}"
         class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg mr-2">
        Batal
      </a>
      <button type="submit"
              class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
        Simpan Modul
      </button>
    </div>
  </form>
</div>
@endsection
