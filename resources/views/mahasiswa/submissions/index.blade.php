{{-- resources/views/mahasiswa/submissions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Praktikum per Kelas – FlowTask')

@section('content')
<div class="px-6 py-4 space-y-8">
  <h2 class="text-2xl font-semibold text-gray-800">Daftar Praktikum per Kelas</h2>

  @forelse($classes as $kelas)
    <section class="space-y-4">
      <h3 class="text-xl font-medium text-indigo-700">{{ $kelas->nama_kelas }} ({{ $kelas->modul->count() }} Modul)</h3>
      @if($kelas->modul->isEmpty())
        <p class="text-gray-500 ml-4">Belum ada modul untuk kelas ini.</p>
      @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          @foreach($kelas->modul as $modul)
            <div class="bg-white bg-opacity-60 backdrop-blur-md rounded-2xl shadow p-6 hover:bg-white/70 transition">
              <h4 class="text-lg font-semibold text-gray-800">{{ $modul->nama_modul }}</h4>
              <p class="text-sm text-gray-600 mt-1">{{ $modul->deskripsi_modul ?: '—' }}</p>
              <p class="text-xs mt-2">
                Deadline:
                <span class="{{ $modul->deadline->isPast() ? 'text-red-600 font-medium' : 'text-gray-600' }}">
                  {{ $modul->deadline->format('d M, Y') }}
                </span>
              </p>
              <div class="mt-4 text-right">
                @if(isset($submissions[$modul->id]))
                  <a href="{{ route('mahasiswa.submissions.detail', $submissions[$modul->id]['id']) }}"
                     class="inline-flex items-center px-3 py-1 text-sm bg-indigo-100 hover:bg-indigo-200 text-indigo-800 rounded-lg">
                    <i class="bi bi-eye mr-1"></i> Lihat Tugas
                  </a>
                @else
                  <a href="{{ route('mahasiswa.submissions.upload', $modul->id) }}"
                     class="inline-flex items-center px-3 py-1 text-sm bg-green-100 hover:bg-green-200 text-green-800 rounded-lg">
                    <i class="bi bi-cloud-upload mr-1"></i> Upload
                  </a>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </section>
  @empty
    <div class="p-6 text-center text-gray-500">
      <p>Anda belum terdaftar di kelas manapun.</p>
    </div>
  @endforelse

  <div class="mt-6">
    {{-- Jika pakai pagination pada kelas --}}
    @if(method_exists($classes, 'links'))
      {{ $classes->links() }}
    @endif
  </div>
</div>
@endsection
