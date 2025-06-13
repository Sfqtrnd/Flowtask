@extends('layouts.app')

@section('title', 'Daftar Tugas Pribadi - FlowTask')

@section('content')
<div class="px-6 py-4">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Daftar Tugas Pribadi</h2>
    <a href="{{ route('mahasiswa.personal-tasks.create') }}"
       class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow">
      <i class="bi bi-plus-lg mr-2"></i>Tambah Tugas
    </a>
  </div>

  @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  @if($tasks->count())
    <div class="space-y-4">
      @foreach($tasks as $task)
        <div class="bg-white bg-opacity-60 backdrop-blur-md rounded-xl shadow p-4 flex items-center hover:bg-white/70 transition">
          <input type="checkbox"
                 class="w-5 h-5 text-indigo-600 rounded mr-4"
                 {{ $task->status === 'Selesai' ? 'checked' : '' }}
                 disabled>
          <div class="flex-1">
            <p class="font-medium text-gray-700">{{ $task->judul }}</p>
          </div>
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $task->status === 'Selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
            {{ $task->status === 'Selesai' ? 'Selesai' : 'Belum Selesai' }}
          </span>
          <div class="flex gap-2 ml-4">
            <a href="{{ route('mahasiswa.personal-tasks.edit', $task->id) }}"
               class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full">
              <i class="bi bi-pencil"></i>
            </a>
            <form action="{{ route('mahasiswa.personal-tasks.destroy', $task->id) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" onclick="return confirm('Hapus tugas ini?')"
                      class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
    <div class="mt-6">
      {{ $tasks->links() }}
    </div>
  @else
    <div class="p-6 text-center text-gray-500">
      <p>Belum ada tugas pribadi.</p>
    </div>
  @endif
</div>
@endsection
