{{-- resources/views/mahasiswa/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa - FlowTask')

@section('additional-styles')
    {{-- Hapus semua CSS kustom lama – digantikan dengan utilitas Tailwind --}}
@endsection

@section('content')
<div class="px-6 py-4 space-y-8">
    <!-- Selamat Datang -->
    <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800">Selamat datang, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600 mt-1">Semangat menyelesaikan tugas tepat waktu hari ini!</p>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total Tugas Pribadi -->
        <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-5 flex items-center">
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mr-4 text-yellow-600">
                <i class="bi bi-journal-bookmark text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tugas Pribadi</p>
                <h3 class="text-2xl font-bold">{{ $totalPersonalTasks ?? 12 }}</h3>
            </div>
        </div>

        <!-- Tugas Pribadi Selesai -->
        <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-5 flex items-center">
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4 text-green-600">
                <i class="bi bi-check2-circle text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Pribadi Selesai</p>
                <h3 class="text-2xl font-bold">{{ $completedPersonalTasks ?? 8 }}</h3>
            </div>
        </div>

        <!-- Tugas Praktikum Dikirim -->
        <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-5 flex items-center">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4 text-blue-600">
                <i class="bi bi-cloud-arrow-up-fill text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Praktikum Dikirim</p>
                <h3 class="text-2xl font-bold">{{ $totalSubmissions ?? 5 }}</h3>
            </div>
        </div>

        <!-- Tugas Praktikum Diterima -->
        <div class="bg-white bg-opacity-60 backdrop-blur-lg border border-white/20 rounded-2xl shadow-lg p-5 flex items-center">
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4 text-green-600">
                <i class="bi bi-award-fill text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Praktikum Diterima</p>
                <h3 class="text-2xl font-bold">{{ $acceptedSubmissions ?? 3 }}</h3>
            </div>
        </div>
    </div>

    <!-- Tugas Pribadi Terbaru -->
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Tugas Pribadi Terbaru</h2>
        <div class="space-y-4">
            @forelse($recentPersonalTasks ?? [
                ['judul' => 'Membuat laporan PBL', 'deadline' => '2025-06-07', 'status' => false],
                ['judul' => 'Membaca bab 3 buku Algoritma', 'deadline' => null, 'status' => true],
                ['judul' => 'Menyiapkan presentasi praktikum', 'deadline' => '2025-06-10', 'status' => false],
            ] as $task)
                <div class="bg-white bg-opacity-60 backdrop-blur-md border border-white/20 rounded-xl flex items-center px-6 py-4 hover:bg-white/70 transition-shadow shadow">
                    <input type="checkbox"
                        class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-400 mr-4"
                        {{ $task['status'] ? 'checked' : '' }}>
                    <div class="flex-1">
                        <p class="font-medium text-gray-700 truncate">{{ $task['judul'] }}</p>
                        <p class="text-sm {{ $task['deadline'] && strtotime($task['deadline']) < time() ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                            {{ $task['deadline'] ? date('d M, Y', strtotime($task['deadline'])) : 'Tanpa deadline' }}
                        </p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $task['status'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $task['status'] ? 'Selesai' : 'Belum Selesai' }}
                    </span>
                    <div class="flex gap-2 ml-4">
                        <a href="#" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="#" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    <p>Belum ada tugas pribadi.</p>
                    <a href="#" class="mt-2 inline-block text-indigo-600 hover:text-indigo-800">
                        <i class="bi bi-plus-circle mr-1"></i> Tambah Tugas Pribadi
                    </a>
                </div>
            @endforelse
        </div>
        <div class="mt-4 text-right">
            <a href="{{ url('/mahasiswa/personal-tasks') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                Lihat Semua →
            </a>
        </div>
    </div>

    <!-- Deadline Praktikum Terdekat -->
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Deadline Praktikum Terdekat</h2>
        <div class="space-y-4">
            @forelse($upcomingDeadlines ?? [
                ['modul' => 'Modul 5: Laravel Dasar', 'deadline' => '2025-06-06', 'status' => 'Menunggu Kirim'],
                ['modul' => 'Modul 6: Blade Templating', 'deadline' => '2025-06-08', 'status' => 'Dikirim'],
                ['modul' => 'Modul 7: Eloquent ORM', 'deadline' => '2025-06-10', 'status' => 'Belum'],
            ] as $item)
                <div class="bg-white bg-opacity-60 backdrop-blur-md border border-white/20 rounded-xl flex items-center px-6 py-4 hover:bg-white/70 transition-shadow shadow">
                    <div class="flex-1">
                        <p class="font-medium text-gray-700">{{ $item['modul'] }}</p>
                        <p class="text-sm {{ strtotime($item['deadline']) < time() ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                            {{ date('d M, Y', strtotime($item['deadline'])) }}
                        </p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $item['status'] === 'Diterima' ? 'bg-green-100 text-green-800' : ($item['status'] === 'Ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ $item['status'] }}
                    </span>
                    <a href="{{ url('/mahasiswa/submissions/upload/'.$loop->index) }}"
                       class="ml-4 px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg">
                        Unggah
                    </a>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    <p>Tidak ada deadline praktikum terdekat.</p>
                </div>
            @endforelse
        </div>
        <div class="mt-4 text-right">
            <a href="{{ url('/mahasiswa/submissions/history') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                Lihat Semua →
            </a>
        </div>
    </div>

    <!-- Notifikasi Penilaian -->
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Notifikasi Penilaian</h2>
        <div class="space-y-4">
            @forelse($notifications ?? [
                ['judul' => 'Modul 3: Blade Templating', 'status' => 'Diterima', 'tanggal' => '2025-05-30'],
                ['judul' => 'Modul 4: Middleware', 'status' => 'Revisi', 'tanggal' => '2025-05-28'],
                ['judul' => 'Modul 2: Routing', 'status' => 'Ditolak', 'tanggal' => '2025-05-25'],
            ] as $note)
                <div class="bg-white bg-opacity-60 backdrop-blur-md border border-white/20 rounded-xl flex items-center px-6 py-4 hover:bg-white/70 transition-shadow shadow">
                    <div class="flex-1">
                        <p class="font-medium text-gray-700">{{ $note['judul'] }}</p>
                        <p class="text-sm text-gray-500">{{ date('d M, Y', strtotime($note['tanggal'])) }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $note['status'] === 'Diterima' ? 'bg-green-100 text-green-800' : ($note['status'] === 'Ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ $note['status'] }}
                    </span>
                    <a href="{{ url('/mahasiswa/submissions/detail/'.$loop->index) }}" 
                       class="ml-4 px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg">
                        Lihat
                    </a>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    <p>Tidak ada notifikasi baru.</p>
                </div>
            @endforelse
        </div>
        <div class="mt-4 text-right">
            <a href="{{ url('/mahasiswa/notifications') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                Lihat Semua →
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // (Tidak ada skrip collapse yang diperlukan karena kita menampilkan semua konten secara langsung)
</script>
@endsection
