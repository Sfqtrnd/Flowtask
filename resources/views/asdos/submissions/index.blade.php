@extends('layouts.app')

@section('title', 'Pengumpulan Menunggu Review - FlowTask')

@section('content')
<div class="px-6 py-4">
  <div class="mb-4 flex justify-between items-center">
    <h2 class="text-2xl font-semibold text-gray-800">Tugas untuk Direview</h2>
    <a href="{{ route('asdos.submissions.history') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow">
      <i class="bi bi-clock-history mr-2"></i> Riwayat Pengumpulan
    </a>
  </div>

  @if($submissions->count())
    <div class="overflow-x-auto bg-white bg-opacity-60 backdrop-blur-md rounded-xl shadow overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Mahasiswa</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Modul</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Tanggal Kirim</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Status</th>
            <th class="px-4 py-3 text-right text-sm font-medium text-gray-600">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @foreach($submissions as $submission)
          <tr class="hover:bg-white/80 transition-colors">
            <td class="px-4 py-3 text-gray-700">{{ $submission->mahasiswa->name }}</td>
            <td class="px-4 py-3 text-gray-700">{{ $submission->modul->nama_modul }}</td>
            <td class="px-4 py-3 text-gray-700">{{ $submission->created_at->format('d M, Y') }}</td>
            <td class="px-4 py-3">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-200 text-amber-700">
                {{ $submission->status_pengumpulan }}
              </span>
            </td>
            <td class="px-4 py-3 text-right">
              <a href="{{ route('asdos.submissions.reviewForm', $submission->id) }}"
                 class="inline-flex items-center px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg">
                <i class="bi bi-eye mr-1"></i> Review
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $submissions->links() }}
    </div>
  @else
    <div class="p-6 text-center text-gray-500">
      <p>Semua tugas sudah direview.</p>
    </div>
  @endif
</div>
@endsection
