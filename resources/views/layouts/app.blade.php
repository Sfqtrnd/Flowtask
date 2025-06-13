{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title', 'FlowTask')</title>

  <!-- Tailwind & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body
  class="@if(Auth::user()->role === 'mahasiswa') bg-gradient-to-br from-white via-transparent to-purple-100 @else bg-gradient-to-br from-white via-transparent to-blue-100 @endif">

  <div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside
      class="w-20 fixed inset-y-0 left-0 flex flex-col items-center py-6 bg-white bg-opacity-10 backdrop-blur-lg border-r border-white/20 z-20">
      {{-- Avatar --}}
      <div class="mb-8">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff&size=100"
          alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full border-2 border-white">
      </div>

      {{-- Nav Icons --}}
      <nav class="flex-1 flex flex-col space-y-6">
        @if(Auth::user()->role === 'mahasiswa')
      <x-sidebar-link href="{{ route('mahasiswa.dashboard') }}" icon="bi-house"
        active="{{ request()->routeIs('mahasiswa.dashboard') }}" />
      <x-sidebar-link href="{{ route('mahasiswa.personal-tasks.index') }}" icon="bi-journal-text"
        active="{{ request()->routeIs('mahasiswa.personal-tasks*') }}" />
      <x-sidebar-link href="{{ route('mahasiswa.submissions.index') }}" icon="bi-folder2-open"
        active="{{ request()->routeIs('mahasiswa.submissions*') }}" />
    @else
      <x-sidebar-link href="{{ route('asdos.dashboard') }}" icon="bi-house"
        active="{{ request()->routeIs('asdos.dashboard') }}" />
      <x-sidebar-link href="{{ route('asdos.kelas.index') }}" icon="bi-book"
        active="{{ request()->routeIs('asdos.kelas*') }}" />
      <x-sidebar-link href="{{ route('asdos.submissions.waiting') }}" icon="bi-cloud-arrow-up"
        active="{{ request()->routeIs('asdos.submissions*') }}" />
    @endif
      </nav>

      <div class="mt-auto mb-4 flex flex-col items-center space-y-4">
        <form action="{{ route('auth.logout') }}" method="POST">
          @csrf @method('DELETE')
          <button type="submit" class="w-full text-left px-4 py-2 text-gray-700">
            <i class="bi bi-box-arrow-right mr-1"></i>
          </button>
        </form>
      </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 ml-20 flex flex-col">
      {{-- Top Navbar --}}
      <header
        class="fixed top-0 left-20 right-0 bg-white bg-opacity-20 backdrop-blur-md border-b border-white/20 z-10 px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-indigo-700">FLOWTASK</h1>
      </header>

      {{-- Page Content --}}
      <main class="mt-20 p-6 overflow-auto">
        @yield('content')
      </main>
    </div>
    </div>
</body>

</html>
