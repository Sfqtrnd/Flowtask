{{-- resources/views/asdos/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Asisten Dosen - FlowTask')

@section('additional-styles')
    {{-- Tambahan style khusus jika diperlukan --}}
@endsection

@section('content')
<div class="px-6 py-4 space-y-8">
    <!-- Selamat Datang -->
    <div>
        <h1 class="text-2xl font-semibold text-gray-800">Selamat Datang, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600">Semester Aktif: {{ $currentSemester ?? 'Genap 2025' }}</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Jumlah Kelas -->
        <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-4 flex items-center">
            <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mr-4 text-indigo-600">
                <i class="bi bi-journal-bookmark text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Kelas Dibuat</p>
                <h3 class="text-2xl font-bold">{{ $kelasCount ?? 5 }}</h3>
            </div>
        </div>

        <!-- Total Modul -->
        <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-4 flex items-center">
            <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mr-4 text-indigo-600">
                <i class="bi bi-folder2-open text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Modul Tersedia</p>
                <h3 class="text-2xl font-bold">{{ $moduleCount ?? 12 }}</h3>
            </div>
        </div>

        <!-- Total Pengumpulan -->
        <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-4 flex items-center">
            <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mr-4 text-indigo-600">
                <i class="bi bi-cloud-arrow-up text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Pengumpulan</p>
                <h3 class="text-2xl font-bold">{{ $submissionCount ?? 38 }}</h3>
            </div>
        </div>

        <!-- Tugas Belum Dinilai -->
        <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-4 flex items-center">
            <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center mr-4 text-amber-600">
                <i class="bi bi-hourglass-split text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Menunggu Review</p>
                <h3 class="text-2xl font-bold">{{ $pendingCount ?? 8 }}</h3>
            </div>
        </div>
    </div>

    <!-- Daftar Kelas Singkat -->
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Kelas Terbaru</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($recentClasses ?? [
                ['nama_kelas' => 'Praktikum Struktur Data', 'mahasiswa' => 30, 'modul' => 4],
                ['nama_kelas' => 'Praktikum Basis Data', 'mahasiswa' => 28, 'modul' => 5],
                ['nama_kelas' => 'Praktikum Web Lanjut', 'mahasiswa' => 32, 'modul' => 6],
            ] as $kelas)
                <div class="bg-white bg-opacity-70 backdrop-blur-md border border-white/30 rounded-xl p-4 hover:bg-white/80 transition shadow">
                    <h3 class="text-lg font-medium text-gray-700">{{ $kelas['nama_kelas'] }}</h3>
                    <p class="text-sm text-gray-500 mt-2">Mahasiswa: {{ $kelas['mahasiswa'] }} orang</p>
                    <p class="text-sm text-gray-500">Modul: {{ $kelas['modul'] }}</p>
                    <a href="{{ url('/asdos/kelas/'.$loop->index) }}" 
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
            @foreach($recentSubmissions ?? [
                ['mahasiswa' => 'Budi Santoso', 'modul' => 'Modul 1: Pengenalan Web', 'tgl' => '15 Apr 2023'],
                ['mahasiswa' => 'Andi Wijaya', 'modul' => 'Modul 2: HTML & CSS', 'tgl' => '16 Apr 2023'],
                ['mahasiswa' => 'Eka Putri', 'modul' => 'Modul 3: JavaScript Dasar', 'tgl' => '17 Apr 2023'],
            ] as $sub)
                <div class="bg-white bg-opacity-70 backdrop-blur-md border border-white/30 rounded-xl p-4 flex justify-between items-center hover:bg-white/80 transition shadow">
                    <div>
                        <p class="text-gray-700 font-medium">{{ $sub['mahasiswa'] }}</p>
                        <p class="text-sm text-gray-500">{{ $sub['modul'] }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $sub['tgl'] }}</p>
                    </div>
                    <a href="{{ url('/asdos/submissions/review/'.$loop->index) }}" 
                       class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg">
                        Nilai Sekarang
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    
</div>

@endsection