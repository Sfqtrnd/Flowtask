@extends('layouts.app')

@section('title', 'Daftar Modul - FlowTask')

@section('content')
<div class="px-6 py-4">
  <!-- Header & tombol tambah modul -->
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Modul: {{ $kelas->nama_kelas }}</h2>
    <a href="{{ route('asdos.modul.create', $kelas->id) }}"
       class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow">
      <i class="bi bi-plus-lg mr-2"></i> Tambah Modul
    </a>
  </div>

  @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  @if($moduls->count())
    <div class="overflow-x-auto bg-white bg-opacity-60 backdrop-blur-md rounded-xl shadow overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">#</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nama Modul</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Deadline</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Deskripsi</th>
            <th class="px-6 py-3 text-right text-sm font-medium text-gray-600">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @foreach($moduls as $idx => $modul)
          <tr class="hover:bg-white/80 transition-colors">
            <td class="px-6 py-4 text-sm text-gray-700">{{ $moduls->firstItem() + $idx }}</td>
            <td class="px-6 py-4 text-sm text-gray-700">{{ $modul->nama_modul }}</td>
            <td class="px-6 py-4 text-sm {{ \Carbon\Carbon::parse($modul->deadline)->isPast() ? 'text-red-600 font-medium' : 'text-gray-700' }}">
  {{ \Carbon\Carbon::parse($modul->deadline)->format('d M, Y') }}
</td>
            <td class="px-6 py-4 text-sm text-gray-700 truncate" title="{{ $modul->deskripsi_modul }}">
              {{ Str::limit($modul->deskripsi_modul, 50) ?: '-' }}
            </td>
            <td class="px-6 py-4 text-right space-x-2">
              <a href="{{ route('asdos.modul.edit', [$kelas->id, $modul->id]) }}"
                 class="inline-flex items-center px-3 py-1 text-sm bg-yellow-100 hover:bg-yellow-200 text-yellow-800 rounded-lg">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('asdos.modul.destroy', [$kelas->id, $modul->id]) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Hapus modul ini?')"
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

    <div class="mt-4">
      {{ $moduls->links() }}
    </div>
  @else
    <div class="p-6 text-center text-gray-500">
      <p>Belum ada modul untuk kelas ini.</p>
      <a href="{{ route('asdos.modul.create', $kelas->id) }}"
         class="mt-4 inline-block px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
        <i class="bi bi-plus-circle mr-1"></i> Tambah Modul
      </a>
    </div>
  @endif
</div>
@endsection
