@extends('layouts.app')

@section('title', 'Riwayat Review - FlowTask')

@section('content')
<div class="px-6 py-4">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Riwayat Review</h2>

  @if($submissions->count())
    <div class="overflow-x-auto bg-white bg-opacity-60 backdrop-blur-md rounded-xl shadow overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Mahasiswa</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Modul</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Tanggal Review</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Status</th>
            <th class="px-4 py-3 text-right text-sm font-medium text-gray-600">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @foreach($submissions as $submission)
          <tr class="hover:bg-white/80 transition-colors">
            <td class="px-4 py-3 text-gray-700">{{ $submission->mahasiswa->name }}</td>
            <td class="px-4 py-3 text-gray-700">{{ $submission->modul->nama_modul }}</td>
            <td class="px-4 py-3 text-gray-700">{{ $submission->updated_at->format('d M, Y') }}</td>
            <td class="px-4 py-3">
              @if($submission->status_pengumpulan === 'Diterima')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-200 text-green-800">
                  Diterima
                </span>
              @elseif($submission->status_pengumpulan === 'Ditolak')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-200 text-red-800">
                  Ditolak
                </span>
              @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-200 text-purple-800">
                  Revisi
                </span>
              @endif
            </td>
            <td class="px-4 py-3 text-right">
              <a href="{{ route('asdos.submissions.reviewForm', $submission->id) }}"
                 class="inline-flex items-center px-3 py-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 text-sm rounded-lg">
                Review
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
      <p>Belum ada riwayat review.</p>
    </div>
  @endif
</div>
@endsection
