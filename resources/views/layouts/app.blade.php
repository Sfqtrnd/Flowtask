<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FlowTask')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Inter', sans-serif;
            background-attachment: fixed;
        }

        /* Role-based background styles */
        .mahasiswa-bg {
            background: radial-gradient(circle at top left, white, transparent 30%),
                radial-gradient(circle at top right, white, transparent 30%),
                linear-gradient(135deg, #fcdede, #f0e0ff);
            background-attachment: fixed;
        }

        .asdos-bg {
            background:
                radial-gradient(circle at top left, #ffffff, transparent 30%),
                radial-gradient(circle at top right, #f5f5ff, transparent 30%),
                linear-gradient(135deg, #e4f1fb, #f1e6ff);
            background-attachment: fixed;
        }

        /* Default background */
        body:not(.mahasiswa-bg):not(.asdos-bg) {
            background: radial-gradient(circle at top left, white, transparent 30%),
                radial-gradient(circle at top right, white, transparent 30%),
                linear-gradient(135deg, #fcdede, #f0e0ff);
            background-attachment: fixed;
        }

        /* Glass effect styles */
        .sidebar-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
            z-index: 998;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border-right: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Icon and interaction styles */
        .sidebar-icon {
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            color: #64748b;
            transition: all 0.2s;
        }

        .sidebar-icon:hover,
        .sidebar-icon.active {
            background-color: #f1f5f9;
            color: #334155;
        }

        /* Dropdown styles */
        .dropdown-container {
            position: relative;
        }

        .dropdown-container:focus-within .dropdown-menu {
            display: block;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            left: 100%;
            bottom: 0;
            width: 12rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            border: 1px solid #e5e7eb;
            z-index: 999;
        }

        /* Header styles to ensure it stays on top */
        header {
            position: sticky;
            top: 0;
            z-index: 1000 !important;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Content container should have lower z-index */
        .content-container {
            z-index: 1;
        }

        /* Card styles need lower z-index */
        .sidebar-glass {
            z-index: 5;
        }

        @yield('additional-styles')
    </style>
</head>

<body
    class="@if(Auth::user()->role === 'mahasiswa') mahasiswa-bg @elseif(Auth::user()->role === 'asdos') asdos-bg @endif">
    <div>
        <!-- Top Navbar -->
        <nav class="fixed top-0 w-full z-50 px-4 py-3 ml-16 glass-effect">
            <div class="flex justify-between items-center">
                <div class="text-xl font-bold text-indigo-700 ml-4">FLOWTASK</div>
                <div class="relative mr-16">
                    <input type="text" placeholder="Search..." 
                        class="bg-white bg-opacity-30 border border-gray-300 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-indigo-400 w-64">
                    <i class="bi bi-search absolute left-3 top-2.5 text-gray-500"></i>
                </div>
            </div>
        </nav>

        <!-- Left sidebar -->
        <div class="w-16 sidebar-glass flex flex-col items-center py-6 fixed top-0 left-0 h-full">
            <!-- User avatar -->
            <div class="mb-8">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff&size=100"
                        alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full border-2 border-white">
                </div>
            </div>

            <!-- Navigation icons -->
            <div class="flex flex-col space-y-6">
                <a href="/mahasiswa/dashboard"
                    class="sidebar-icon {{ request()->is('mahasiswa/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house text-lg"></i>
                </a>
                <a href="#" class="sidebar-icon">
                    <i class="bi bi-bell text-lg"></i>
                </a>
                <a href="" class="sidebar-icon {{ request()->is('mahasiswa/schedule') ? 'active' : '' }}">
                    <i class="bi bi-calendar text-lg"></i>
                </a>
            </div>

            <!-- Settings and logout -->
            <div class="mt-auto flex flex-col space-y-4">
                <div class="sidebar-icon dropdown-container" tabindex="0">
                    <i class="bi bi-gear text-lg"></i>
                    <!-- Settings dropdown menu -->
                    <div class="dropdown-menu">
                        <a href="{{ url('/mahasiswa/profile') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="bi bi-person-circle mr-2"></i>
                            Pengaturan Profil
                        </a>
                        <a href="{{ url('/mahasiswa/change-password') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="bi bi-key-fill mr-2"></i>
                            Ganti Password
                        </a>
                        <a href="{{ url('/mahasiswa/guide') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="bi bi-question-circle-fill mr-2"></i>
                            Panduan Penggunaan
                        </a>
                    </div>
                </div>
                <form action="{{ url('/logout') }}" method="POST" class="w-full flex justify-center">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-gray-500 hover:text-gray-700">
                        <i class="bi bi-box-arrow-right text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
        <!-- Main content area -->
        <div class="flex-1 ml-16 overflow-y-auto pt-16"> <!-- Added padding-top for navbar -->
            @yield('content')
        </div>
    </div>

    @yield('modals')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>

</html>