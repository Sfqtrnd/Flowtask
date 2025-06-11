@extends('layouts.app')

@section('title', 'Edit Tugas Pribadi - FlowTask')

@section('content')
<div class="px-6 py-4 max-w-lg mx-auto">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Tugas Pribadi</h2>

  @if($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
      <ul class="list-disc list-inside">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('mahasiswa.personal-tasks.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-4">
      <label for="judul" class="block text-gray-700 font-medium mb-2">Judul Tugas</label>
      <input type="text" id="judul" name="judul" value="{{ old('judul',$task->judul) }}"
             class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
    </div>
    <div class="mb-4">
      <label for="deskripsi" class="block text-gray-700 font-medium mb-2">Deskripsi (opsional)</label>
      <textarea id="deskripsi" name="deskripsi" rows="4"
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('deskripsi',$task->deskripsi) }}</textarea>
    </div>
    <div class="mb-4">
      <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
      <select id="status" name="status"
              class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
        <option value="Belum Mulai" {{ old('status',$task->status)=='Belum Mulai'? 'selected':'' }}>Belum Mulai</option>
        <option value="Sedang Berjalan" {{ old('status',$task->status)=='Sedang Berjalan'? 'selected':'' }}>Sedang Berjalan</option>
        <option value="Selesai" {{ old('status',$task->status)=='Selesai'? 'selected':'' }}>Selesai</option>
      </select>
    </div>
    <div class="flex justify-end">
      <a href="{{ route('mahasiswa.personal-tasks.index') }}"
         class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg mr-2">Batal</a>
      <button type="submit"
              class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">Perbarui</button>
    </div>
  </form>
</div>
@endsection
