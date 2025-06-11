@extends('layouts.app')

@section('title', 'Edit Kelas Praktikum - FlowTask')

@section('content')
<div class="px-6 py-4 max-w-2xl mx-auto">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Kelas Praktikum</h2>

  @if($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
      <ul class="list-disc list-inside">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('asdos.kelas.update', $kelas->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-4">
      <label for="nama_kelas" class="block text-gray-700 font-medium mb-2">Nama Kelas</label>
      <input
        type="text"
        id="nama_kelas"
        name="nama_kelas"
        value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
        class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
        required
      >
    </div>

    <div class="mb-4">
      <label for="semester" class="block text-gray-700 font-medium mb-2">Semester</label>
      <input
        type="text"
        id="semester"
        name="semester"
        value="{{ old('semester', $kelas->semester) }}"
        class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
        placeholder="Contoh: Genap 2025"
        required
      >
    </div>

    <div class="flex justify-end">
      <a href="{{ route('asdos.kelas.index') }}"
         class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg mr-2">
        Batal
      </a>
      <button type="submit"
              class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
        Perbarui
      </button>
    </div>
  </form>
</div>
@endsection
