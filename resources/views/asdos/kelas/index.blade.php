{{-- resources/views/asdos/kelas/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Kelas - FlowTask')

@section('content')
<div class="px-6 py-4">
  <!-- Header & tombol tambah kelas -->
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Daftar Kelas Praktikum</h2>
    <a href="{{ route('asdos.kelas.create') }}"
       class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow">
      <i class="bi bi-plus-lg mr-2"></i> Tambah Kelas
    </a>
  </div>

  @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  @if($kelasList->count())
    <div class="overflow-x-auto bg-white bg-opacity-60 backdrop-blur-md rounded-xl shadow overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">#</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nama Kelas</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Semester</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Jumlah Modul</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Jumlah Mahasiswa</th>
            <th class="px-6 py-3 text-right text-sm font-medium text-gray-600">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @foreach($kelasList as $idx => $kelas)
            <tr class="hover:bg-white/80 transition-colors">
              <td class="px-6 py-4 text-sm text-gray-700">{{ $kelasList->firstItem() + $idx }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ $kelas->nama_kelas }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ $kelas->semester }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ $kelas->modul->count() }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">
                {{ \App\Models\Submission::whereIn('modul_id', $kelas->modul->pluck('id'))->distinct('mahasiswa_id')->count() }}
              </td>
              <td class="px-6 py-4 text-right space-x-2">
                <a href="{{ route('asdos.modul.index', $kelas->id) }}"
                   class="inline-flex items-center px-3 py-1 text-sm bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-lg">
                  Modul
                </a>
                <a href="{{ route('asdos.kelas.edit', $kelas->id) }}"
                   class="inline-flex items-center px-3 py-1 text-sm bg-yellow-100 hover:bg-yellow-200 text-yellow-800 rounded-lg">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('asdos.kelas.destroy', $kelas->id) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          onclick="return confirm('Yakin ingin menghapus kelas ini?')"
                          class="inline-flex items-center px-3 py-1 text-sm bg-red-100 hover:bg-red-200 text-red-800 rounded-lg">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
      {{ $kelasList->links() }}
    </div>
  @else
    <div class="p-6 text-center text-gray-500">
      <p>Belum ada kelas praktikum.</p>
    </div>
  @endif
</div>
@endsection
