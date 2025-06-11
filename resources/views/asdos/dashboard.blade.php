@extends('layouts.app')

@section('title', 'Dashboard Asdos - FlowTask')

@section('content')
<div class="px-6 py-4 space-y-8">
  <!-- Greeting -->
  <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-6">
    <h1 class="text-2xl font-semibold text-gray-800">Selamat datang, {{ Auth::user()->name }}</h1>
  </div>

  <!-- Statistik Ringkas -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <!-- Kelas -->
    <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-5 flex items-center">
      <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mr-4 text-indigo-600">
        <i class="bi bi-book text-xl"></i>
      </div>
      <div>
        <p class="text-sm text-gray-500">Kelas Dibuat</p>
        <h3 class="text-2xl font-bold">{{ $kelasCount }}</h3>
      </div>
    </div>

    <!-- Modul -->
    <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-5 flex items-center">
      <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mr-4 text-indigo-600">
        <i class="bi bi-folder2-open text-xl"></i>
      </div>
      <div>
        <p class="text-sm text-gray-500">Modul Tersedia</p>
        <h3 class="text-2xl font-bold">{{ $moduleCount }}</h3>
      </div>
    </div>

    <!-- Pengumpulan -->
    <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-5 flex items-center">
      <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mr-4 text-indigo-600">
        <i class="bi bi-cloud-arrow-up text-xl"></i>
      </div>
      <div>
        <p class="text-sm text-gray-500">Total Pengumpulan</p>
        <h3 class="text-2xl font-bold">{{ $submissionCount }}</h3>
      </div>
    </div>

    <!-- Menunggu Review -->
    <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-5 flex items-center">
      <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mr-4 text-indigo-600">
        <i class="bi bi-hourglass-split text-xl"></i>
      </div>
      <div>
        <p class="text-sm text-gray-500">Menunggu Review</p>
        <h3 class="text-2xl font-bold">{{ $pendingCount }}</h3>
      </div>
    </div>
  </div>

  <!-- Kelas Terbaru -->
  <div>
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Kelas Terbaru</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach($recentClasses as $kelas)
        <div class="bg-white bg-opacity-70 backdrop-blur-md border border-white/30 rounded-xl p-4 hover:bg-white/80 transition shadow">
          <h3 class="text-lg font-medium text-gray-700">{{ $kelas['nama_kelas'] }}</h3>
          <p class="text-sm text-gray-500 mt-2">Mahasiswa: {{ $kelas['mahasiswa'] }}</p>
          <p class="text-sm text-gray-500">Modul: {{ $kelas['modul'] }}</p>
          <a href="{{ route('asdos.kelas.index') }}"
             class="inline-block mt-4 px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg">
            Kelola Kelas
          </a>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Pengumpulan Terbaru -->
  <div>
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Pengumpulan Terbaru</h2>
    <div class="space-y-4">
      @foreach($recentSubmissions as $sub)
        <div class="bg-white bg-opacity-70 backdrop-blur-md border border-white/30 rounded-xl p-4 flex justify-between items-center hover:bg-white/80 transition shadow">
          <div>
            <p class="font-medium text-gray-700">{{ $sub['mahasiswa'] }}</p>
            <p class="text-sm text-gray-500">{{ $sub['modul'] }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $sub['tgl'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
