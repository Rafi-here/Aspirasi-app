<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa - @yield('title') | Aspirasi Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Glass effect */
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        /* Floating animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        /* Notification badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 18px;
            height: 18px;
            background: linear-gradient(135deg, #f56565, #ed8936);
            color: white;
            font-size: 10px;
            font-weight: bold;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        /* Active tab indicator */
        .active-tab {
            position: relative;
            color: #3b82f6;
        }

        .active-tab::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #6366f1);
            border-radius: 3px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                width: 0;
            }

            to {
                width: 40px;
            }
        }

        /* Mobile menu animation */
        .mobile-menu-enter {
            opacity: 0;
            transform: translateY(-10px);
        }

        .mobile-menu-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.3s, transform 0.3s;
        }

        .mobile-menu-exit {
            opacity: 1;
            transform: translateY(0);
        }

        .mobile-menu-exit-active {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s, transform 0.3s;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="glass-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo and Brand -->
                <div class="flex items-center">
                    <a href="{{ route('siswa.dashboard') }}" class="flex items-center space-x-3 group">
                        <div
                            class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-md group-hover:rotate-6 transition">
                            <span class="text-white font-extrabold text-sm tracking-wider">AS</span>
                        </div>
                        <div>
                            <h1
                                class="text-xl font-bold bg-blue-600 bg-clip-text text-transparent">
                                Aspirasi<span class="font-extrabold">Siswa</span>
                            </h1>
                            <p class="text-xs text-gray-500">Student Portal</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <!-- Navigation Items -->
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('siswa.dashboard') }}"
                            class="relative px-3 py-2 text-sm font-medium transition-all duration-300 {{ request()->routeIs('siswa.dashboard') ? 'active-tab font-semibold' : 'text-gray-600 hover:text-blue-600 hover:scale-105' }}">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            Dashboard
                        </a>

                        <a href="{{ route('siswa.aspirasi.index') }}"
                            class="relative px-3 py-2 text-sm font-medium transition-all duration-300 {{ request()->routeIs('siswa.aspirasi.*') ? 'active-tab font-semibold' : 'text-gray-600 hover:text-blue-600 hover:scale-105' }}">
                            <i class="fas fa-inbox mr-2"></i>
                            Aspirasi Saya
                            @php
                                $pendingCount = Auth::user()->aspirasis()->where('status', 'menunggu')->count();
                            @endphp
                            @if ($pendingCount > 0)
                                <span class="notification-badge">{{ $pendingCount > 9 ? '9+' : $pendingCount }}</span>
                            @endif
                        </a>

                        <a href="{{ route('siswa.aspirasi.create') }}"
                            class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 hover:-translate-y-0.5">
                            <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center">
                                <i class="fas fa-plus text-white text-xs"></i>
                            </div>
                            <span>Buat Aspirasi</span>
                        </a>
                    </div>

                    <!-- User Profile & Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative">
                            <button id="notification-btn"
                                class="relative p-2.5 rounded-full bg-blue-50 hover:bg-blue-100 text-blue-600 transition-colors duration-300 hover:scale-110">
                                <i class="fas fa-bell text-lg"></i>
                                <span
                                    class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                            </button>

                            <!-- Notification Dropdown -->
                            <div id="notification-dropdown"
                                class="hidden absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-2xl border border-gray-200 z-50">
                                <div class="p-4 border-b border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-bold text-gray-900">Notifikasi</h3>
                                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-600 rounded-full">3
                                            baru</span>
                                    </div>
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    <!-- Notification Items -->
                                    <a href="#" class="block p-4 hover:bg-blue-50 border-b border-gray-100">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                                    <i class="fas fa-check text-green-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-medium text-gray-900">Aspirasi diterima</p>
                                                <p class="text-xs text-gray-500 mt-1">2 jam yang lalu</p>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- Add more notifications -->
                                </div>
                                <div class="p-4 border-t border-gray-100">
                                    <a href="#"
                                        class="text-sm font-medium text-blue-600 hover:text-blue-700 block text-center">
                                        Lihat semua notifikasi
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- User Profile -->
                        <div class="relative">
                            <button id="user-menu-btn"
                                class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-100 transition-all duration-300 group">
                                <div class="relative">
                                    <div
                                        class="w-10 h-10 rounded-full p-0.5 bg-gradient-to-br from-blue-400 to-purple-500">
                                        <img src="https://api.dicebear.com/7.x/personas/png?seed={{ Auth::user()->email }}"
                                            alt="User Avatar" class="w-full h-full rounded-full object-cover bg-white">
                                    </div>

                                    <div
                                        class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white">
                                    </div>
                                </div>
                                <div class="hidden lg:block text-left">
                                    <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500">Siswa</div>
                                </div>
                                <i
                                    class="fas fa-chevron-down text-gray-400 text-xs group-hover:text-blue-500 transition-colors"></i>
                            </button>

                            <!-- User Menu Dropdown -->
                            <div id="user-menu-dropdown"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-gray-200 z-50">
                                <div class="p-4 border-b border-gray-100">
                                    <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
                                </div>
                                <div class="py-2">
                                    <a href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                        <i class="fas fa-user-circle mr-3 text-gray-400"></i> Profil
                                    </a>
                                    <a href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                        <i class="fas fa-cog mr-3 text-gray-400"></i> Pengaturan
                                    </a>
                                    <div class="border-t border-gray-100 my-2"></div>
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                            <i class="fas fa-sign-out-alt mr-3"></i> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-btn"
                        class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 shadow-lg">
            <div class="px-4 pt-2 pb-3 space-y-1">
                <a href="{{ route('siswa.dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('siswa.dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-tachometer-alt w-6 text-center mr-3"></i>
                    Dashboard
                </a>

                <a href="{{ route('siswa.aspirasi.index') }}"
                    class="flex items-center justify-between px-4 py-3 rounded-lg {{ request()->routeIs('siswa.aspirasi.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="flex items-center">
                        <i class="fas fa-inbox w-6 text-center mr-3"></i>
                        Aspirasi Saya
                    </div>
                    @if ($pendingCount > 0)
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('siswa.aspirasi.create') }}"
                    class="flex items-center px-4 py-3 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium">
                    <div class="w-6 text-center mr-3">
                        <i class="fas fa-plus"></i>
                    </div>
                    Buat Aspirasi
                </a>

                <div class="pt-4 border-t border-gray-200">
                    <div class="px-4 py-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 p-0.5">
                                <div class="w-full h-full rounded-full bg-white flex items-center justify-center">
                                    <span class="font-bold text-blue-600 text-sm">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-user-circle w-6 text-center mr-3 text-gray-400"></i>
                        Profil
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-cog w-6 text-center mr-3 text-gray-400"></i>
                        Pengaturan
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt w-6 text-center mr-3"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Session Messages -->
            @if (session('success'))
                <div class="mb-6 animate-fade-in">
                    <div
                        class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-4">
                                <i class="fas fa-check text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-bold">Berhasil!</h4>
                                <p class="text-sm opacity-90">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 animate-fade-in">
                    <div
                        class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-bold">Terjadi Kesalahan</h4>
                                <p class="text-sm opacity-90">{{ session('error') }}</p>
                            </div>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Page Header -->
            <div class="mb-6">
                @yield('breadcrumb')
                <h1 class="text-3xl font-bold text-gray-900 mt-2">@yield('title')</h1>
            </div>

            <!-- Page Content -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="p-6">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                    <div class="mb-4 md:mb-0">
                        <p>&copy; {{ date('Y') }} Aspirasi Siswa. Hak cipta dilindungi.</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            <span class="font-medium text-green-600">Online</span>
                        </span>
                        <span class="hidden md:inline">•</span>
                        <span>Terakhir login:
                            {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'Baru saja' }}</span>
                    </div>
                </div>
            </footer>
        </div>
    </main>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            // Notification dropdown
            const notificationBtn = document.getElementById('notification-btn');
            const notificationDropdown = document.getElementById('notification-dropdown');

            notificationBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');
            });

            // User menu dropdown
            const userMenuBtn = document.getElementById('user-menu-btn');
            const userMenuDropdown = document.getElementById('user-menu-dropdown');

            userMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userMenuDropdown.classList.toggle('hidden');
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', (e) => {
                if (!notificationBtn.contains(e.target) && !notificationDropdown.contains(e.target)) {
                    notificationDropdown.classList.add('hidden');
                }
                if (!userMenuBtn.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                    userMenuDropdown.classList.add('hidden');
                }
                if (!mobileMenuBtn.contains(e.target) && !mobileMenu.contains(e.target) && !mobileMenuBtn
                    .contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });

            // Add active tab animation
            const activeTab = document.querySelector('.active-tab');
            if (activeTab) {
                setTimeout(() => {
                    activeTab.style.opacity = '1';
                }, 100);
            }

            // Toast notification function
            window.showToast = function(message, type = 'success') {
                const container = document.createElement('div');
                container.className = 'fixed top-20 right-4 z-50';

                const colors = {
                    success: 'from-green-500 to-emerald-500',
                    error: 'from-red-500 to-pink-500',
                    warning: 'from-yellow-500 to-orange-500',
                    info: 'from-blue-500 to-cyan-500'
                };

                const icons = {
                    success: 'fa-check-circle',
                    error: 'fa-exclamation-circle',
                    warning: 'fa-exclamation-triangle',
                    info: 'fa-info-circle'
                };

                const toast = document.createElement('div');
                toast.className =
                    `bg-gradient-to-r ${colors[type]} text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center justify-between mb-2 animate-fade-in`;
                toast.innerHTML = `
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-4">
                            <i class="fas ${icons[type]} text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold capitalize">${type}!</h4>
                            <p class="text-sm opacity-90">${message}</p>
                        </div>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white ml-4">
                        <i class="fas fa-times"></i>
                    </button>
                `;

                container.appendChild(toast);
                document.body.appendChild(container);

                setTimeout(() => {
                    if (container.parentNode) {
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateX(100%)';
                        toast.style.transition = 'all 0.3s ease';
                        setTimeout(() => {
                            if (container.parentNode) {
                                container.remove();
                            }
                        }, 300);
                    }
                }, 5000);
            };

            // Add CSS animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(-10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .animate-fade-in {
                    animation: fadeIn 0.3s ease-out;
                }
            `;
            document.head.appendChild(style);
        });
    </script>

    @stack('scripts')
</body>

</html>
