@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa - FlowTask')

@section('content')
<div class="px-6 py-4 space-y-8">
  <!-- Greeting -->
  <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-6">
    <h1 class="text-2xl font-semibold text-gray-800">Selamat datang, {{ Auth::user()->name }}</h1>
    <p class="text-gray-600 mt-1">Semangat menyelesaikan tugas tepat waktu hari ini!</p>
  </div>

  <!-- Statistik Ringkas -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <!-- Tugas Pribadi -->
    <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-5 flex items-center">
      <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mr-4 text-yellow-600">
        <i class="bi bi-journal-bookmark text-xl"></i>
      </div>
      <div>
        <p class="text-sm text-gray-500">Tugas Pribadi</p>
        <h3 class="text-2xl font-bold">{{ $totalPersonalTasks }}</h3>
      </div>
    </div>

    <!-- Pribadi Selesai -->
    <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-5 flex items-center">
      <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4 text-green-600">
        <i class="bi bi-check2-circle text-xl"></i>
      </div>
      <div>
        <p class="text-sm text-gray-500">Pribadi Selesai</p>
        <h3 class="text-2xl font-bold">{{ $completedPersonalTasks }}</h3>
      </div>
    </div>

    <!-- Praktikum Dikirim -->
    <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-5 flex items-center">
      <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4 text-blue-600">
        <i class="bi bi-cloud-arrow-up-fill text-xl"></i>
      </div>
      <div>
        <p class="text-sm text-gray-500">Praktikum Dikirim</p>
        <h3 class="text-2xl font-bold">{{ $totalSubmissions }}</h3>
      </div>
    </div>

    <!-- Praktikum Diterima -->
    <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-5 flex items-center">
      <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4 text-green-600">
        <i class="bi bi-award-fill text-xl"></i>
      </div>
      <div>
        <p class="text-sm text-gray-500">Praktikum Diterima</p>
        <h3 class="text-2xl font-bold">{{ $acceptedSubmissions }}</h3>
      </div>
    </div>
  </div>

  <!-- Tugas Pribadi Terbaru -->
  <div>
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Tugas Pribadi Terbaru</h2>
    <div class="space-y-4">
      @forelse($recentPersonalTasks as $task)
        <div class="bg-white bg-opacity-60 backdrop-blur-md border border-white/20 rounded-xl flex items-center px-6 py-4 hover:bg-white/70 transition-shadow shadow">
          <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-400 mr-4"
                 {{ $task->status==='Selesai'? 'checked':'' }} disabled>
          <div class="flex-1">
            <p class="font-medium text-gray-700 truncate">{{ $task->title }}</p>
          </div>
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $task->status==='Selesai'?'bg-green-100 text-green-800':'bg-yellow-100 text-yellow-800' }}">
            {{ $task->status }}
          </span>
          <a href="{{ route('mahasiswa.personal-tasks.edit',$task->id) }}"
             class="p-2 ml-4 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full">
            <i class="bi bi-pencil"></i>
          </a>
        </div>
      @empty
        <p class="text-gray-500">Belum ada tugas pribadi.</p>
      @endforelse
    </div>
    <div class="mt-4 text-right">
      <a href="{{ route('mahasiswa.personal-tasks.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
        Lihat Semua →
      </a>
    </div>
  </div>
  <div>
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Riwayat Pengumpulan</h2>

  @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  @if($submissions->count())
    <div class="overflow-x-auto bg-white bg-opacity-60 backdrop-blur-md rounded-xl shadow overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Modul</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Judul Tugas</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Tanggal Unggah</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Status</th>
            <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @foreach($submissions as $submission)
            <tr class="hover:bg-white/90 transition">
              <td class="px-4 py-3 text-gray-700">{{ $submission->modul->nama_modul }}</td>
              <td class="px-4 py-3 text-gray-700">{{ $submission->judul_tugas }}</td>
              <td class="px-4 py-3 text-gray-700">{{ $submission->created_at->format('d M, Y') }}</td>
              <td class="px-4 py-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                  {{ $submission->status_pengumpulan=='Diterima'?'bg-green-100 text-green-800':
                     ($submission->status_pengumpulan=='Ditolak'?'bg-red-100 text-red-800':'bg-yellow-100 text-yellow-800') }}">
                  {{ $submission->status_pengumpulan }}
                </span>
              </td>
              <td class="px-4 py-3 text-center">
                <a href="{{ route('mahasiswa.submissions.detail', $submission->id) }}"
                   class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg">
                  Detail
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-6">
      {{ $submissions->links() }}
    </div>
  @else
    <div class="p-6 text-center text-gray-500">
      <p>Belum ada pengumpulan.</p>
      <a href="{{ route('mahasiswa.submissions.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800">
        Kembali ke Daftar Modul
      </a>
    </div>
  @endif
</div>
</div>
@endsection
