<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <!-- Sidebar + Content Layout -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 min-h-screen">
            <div class="p-4">
                <h1 class="text-white text-xl font-bold">Admin Panel</h1>
                <p class="text-gray-400 text-sm">Aspirasi Siswa</p>
            </div>

            <nav class="mt-6">
                <div class="px-4 py-2 text-gray-400 text-sm font-semibold uppercase">
                    Menu Utama
                </div>
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-3 text-gray-300 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.aspirasi.index') }}"
                    class="block px-4 py-3 text-gray-300 hover:bg-gray-700 {{ request()->routeIs('admin.aspirasi.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-inbox mr-3"></i> Kelola Aspirasi
                </a>

                <div class="px-4 py-2 text-gray-400 text-sm font-semibold uppercase mt-6">
                    Laporan
                </div>
                <a href="#" class="block px-4 py-3 text-gray-300 hover:bg-gray-700">
                    <i class="fas fa-chart-bar mr-3"></i> Statistik
                </a>
                <a href="#" class="block px-4 py-3 text-gray-300 hover:bg-gray-700">
                    <i class="fas fa-file-export mr-3"></i> Ekspor Data
                </a>

                <div class="px-4 py-2 text-gray-400 text-sm font-semibold uppercase mt-6">
                    Akun
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-3 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-sign-out-alt mr-3"></i> Logout
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Bar -->
            <div class="bg-white shadow">
                <div class="flex justify-between items-center px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">{{ Auth::user()->name }}</span>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Admin</span>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <main class="p-6">
                <!-- Session Messages -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
