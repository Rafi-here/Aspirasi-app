<!DOCTYPE html>
<html lang="id" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title') | Aspirasi Siswa</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        secondary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        },
                        success: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444',
                        info: '#3b82f6',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                        'slide-out': 'slideOut 0.3s ease-in',
                        'pulse-slow': 'pulse 3s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            },
                        },
                        slideIn: {
                            '0%': {
                                transform: 'translateX(-100%)'
                            },
                            '100%': {
                                transform: 'translateX(0)'
                            },
                        },
                        slideOut: {
                            '0%': {
                                transform: 'translateX(0)'
                            },
                            '100%': {
                                transform: 'translateX(-100%)'
                            },
                        },
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .dark ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Smooth Transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen font-sans text-gray-800 dark:text-gray-200">

    <div class="flex min-h-screen">
        <!-- Sidebar - Desktop -->
        <div id="sidebar"
            class="hidden lg:flex flex-col w-64 bg-white dark:bg-gray-800 shadow-xl border-r border-gray-200 dark:border-gray-700 transition-all duration-300 ease-in-out">
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">

                    <button id="sidebar-toggle"
                        class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-chevron-left text-gray-600 dark:text-gray-400"></i>
                    </button>
                </div>
            </div>

            <!-- User Profile -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 p-0.5">
                            <div
                                class="w-full h-full rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                @php
                                    $initials = strtoupper(substr(Auth::user()->name, 0, 2));
                                @endphp
                                <span class="font-bold text-gray-800 dark:text-white">{{ $initials }}</span>
                            </div>
                        </div>
                        <div
                            class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-white dark:border-gray-800">
                        </div>
                    </div>
                    <div id="sidebar-user-info" class="flex-1">
                        <h3 class="font-semibold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">Administrator</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 overflow-y-auto">
                <div class="space-y-1">
                    <div
                        class="px-3 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        <i class="fas fa-th-large mr-2"></i>
                        <span class="sidebar-text">Menu</span>
                    </div>

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                              {{ request()->routeIs('admin.dashboard')
                                  ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 border-l-4 border-blue-500'
                                  : 'hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                        <div class="w-5 text-center">
                            <i
                                class="fas fa-tachometer-alt {{ request()->routeIs('admin.dashboard') ? 'text-blue-500' : 'text-gray-400 dark:text-gray-500' }}"></i>
                        </div>
                        <span class="sidebar-text font-medium flex-1">Dashboard</span>
                        @if (request()->routeIs('admin.dashboard'))
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.aspirasi.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                              {{ request()->routeIs('admin.aspirasi.*')
                                  ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 border-l-4 border-blue-500'
                                  : 'hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                        <div class="w-5 text-center relative">
                            <i
                                class="fas fa-inbox {{ request()->routeIs('admin.aspirasi.*') ? 'text-blue-500' : 'text-gray-400 dark:text-gray-500' }}"></i>
                            @php
                                $pendingCount = \App\Models\Aspirasi::where('status', 'menunggu')->count();
                            @endphp
                            @if ($pendingCount > 0)
                                <span
                                    class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                    {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                                </span>
                            @endif
                        </div>
                        <span class="sidebar-text font-medium flex-1">Aspirasi</span>
                        @if (request()->routeIs('admin.aspirasi.*'))
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                        @endif
                    </a>

                    <div
                        class="px-3 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mt-6">
                        <i class="fas fa-chart-line mr-2"></i>
                        <span class="sidebar-text">Laporan</span>
                    </div>

                    <a href="{{ route('admin.statistik.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                              {{ request()->routeIs('admin.statistik.*')
                                  ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 border-l-4 border-blue-500'
                                  : 'hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                        <div class="w-5 text-center">
                            <i
                                class="fas fa-chart-bar {{ request()->routeIs('admin.statistik.*') ? 'text-blue-500' : 'text-gray-400 dark:text-gray-500' }}"></i>
                        </div>
                        <span class="sidebar-text font-medium flex-1">Statistik</span>
                        @if (request()->routeIs('admin.statistik.*'))
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.export.data') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <div class="w-5 text-center">
                            <i class="fas fa-file-export text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <span class="sidebar-text font-medium flex-1">Ekspor Data</span>
                    </a>

                    <div
                        class="px-3 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mt-6">
                        <i class="fas fa-cog mr-2"></i>
                        <span class="sidebar-text">Akun</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-2 px-4 py-3 rounded-lg transition-all duration-200
               hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="sidebar-text font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="text-xs">
                        <div class="sidebar-text text-gray-500 dark:text-gray-400">Status</div>
                        <div class="flex items-center mt-1">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-green-600 dark:text-green-400">Online</span>
                        </div>
                    </div>
                    <button id="theme-toggle"
                        class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-moon text-gray-600 dark:text-gray-400"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

        <!-- Sidebar Mobile -->
        <div id="sidebar-mobile"
            class="lg:hidden fixed left-0 top-0 h-full w-64 bg-white dark:bg-gray-800 shadow-xl z-50 transform -translate-x-full transition-transform duration-300">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <button id="close-sidebar-mobile" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                        <i class="fas fa-times text-gray-600 dark:text-gray-400"></i>
                    </button>
                </div>
            </div>
            <!-- Navigation content same as desktop -->
            <div class="p-4">
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-tachometer-alt text-gray-400 w-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.aspirasi.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-inbox text-gray-400 w-5"></i>
                        <span>Aspirasi</span>
                    </a>
                    <a href="{{ route('admin.statistik.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-chart-bar text-gray-400 w-5"></i>
                        <span>Statistik</span>
                    </a>
                    <a href="{{ route('admin.export.data') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-file-export text-gray-400 w-5"></i>
                        <span>Ekspor Data</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-6">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Top Navigation Bar -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="px-4 sm:px-6 py-4">
                    <div class="flex items-center justify-between">
                        <!-- Left: Hamburger & Title -->
                        <div class="flex items-center space-x-4">
                            <button id="mobile-menu-toggle"
                                class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-bars text-gray-600 dark:text-gray-400"></i>
                            </button>

                            <!-- Collapsed sidebar toggle button -->
                            <button id="collapsed-sidebar-toggle"
                                class="hidden lg:flex p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-bars text-gray-600 dark:text-gray-400"></i>
                            </button>
                        </div>

                        <!-- Right: Actions -->
                        <div class="flex items-center space-x-3 sm:space-x-4">
                            <!-- Search (Hidden on mobile) -->
                            <div class="hidden sm:block relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text"
                                    class="pl-10 pr-4 py-2 w-48 lg:w-64 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Cari...">
                            </div>

                            <!-- Notifications -->
                            <div class="relative">
                                <button class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 relative">
                                    <i class="fas fa-bell text-gray-600 dark:text-gray-400"></i>
                                    @if ($pendingCount > 0)
                                        <span
                                            class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                                    @endif
                                </button>
                            </div>

                            <!-- User Menu -->
                            <div class="relative">
                                <button id="user-menu-button"
                                    class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">

                                    <img src="https://api.dicebear.com/7.x/adventurer/png?seed={{ Auth::user()->email }}"
                                        class="w-8 h-8 rounded-full object-cover" />

                                    <div class="hidden lg:block text-left">
                                        <div
                                            class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-[120px]">
                                            {{ Auth::user()->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Admin</div>
                                    </div>

                                    <i class="fas fa-chevron-down text-gray-400 text-xs hidden lg:block"></i>
                                </button>


                                <!-- Dropdown Menu -->
                                <div id="user-dropdown"
                                    class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50">
                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                            {{ Auth::user()->email }}</div>
                                    </div>
                                    <a href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-user mr-3 text-gray-400"></i> Profil
                                    </a>
                                    <a href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-cog mr-3 text-gray-400"></i> Pengaturan
                                    </a>
                                    <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                            <i class="fas fa-sign-out-alt mr-3"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-50 dark:bg-gray-900">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-4 animate-fade-in">
                        <div
                            class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800 dark:text-green-300">
                                        {{ session('success') }}</p>
                                </div>
                            </div>
                            <button type="button" class="ml-auto pl-3"
                                onclick="this.parentElement.parentElement.remove()">
                                <i class="fas fa-times text-green-500 hover:text-green-700"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 animate-fade-in">
                        <div
                            class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800 dark:text-red-300">
                                        {{ session('error') }}</p>
                                </div>
                            </div>
                            <button type="button" class="ml-auto pl-3"
                                onclick="this.parentElement.parentElement.remove()">
                                <i class="fas fa-times text-red-500 hover:text-red-700"></i>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                <div class="animate-fade-in">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-4 px-6">
                <div
                    class="flex flex-col sm:flex-row justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                    <div class="mb-3 sm:mb-0">
                        <p>&copy; {{ date('Y') }} Aspirasi Siswa. All rights reserved.</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="flex items-center text-sm">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse-slow"></span>
                            <span class="hidden sm:inline">Status:</span>
                            <span class="font-medium text-green-600 dark:text-green-400 ml-1">Online</span>
                        </span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const collapsedSidebarToggle = document.getElementById('collapsed-sidebar-toggle');
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const closeSidebarMobile = document.getElementById('close-sidebar-mobile');
            const sidebarMobile = document.getElementById('sidebar-mobile');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const sidebarLogoText = document.getElementById('sidebar-logo-text');
            const sidebarUserInfo = document.getElementById('sidebar-user-info');
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = themeToggle.querySelector('i');

            let isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

            // Initialize sidebar state
            function initializeSidebar() {
                if (isSidebarCollapsed) {
                    collapseSidebar();
                } else {
                    expandSidebar();
                }
            }

            function collapseSidebar() {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                sidebarTexts.forEach(text => text.classList.add('hidden'));
                if (sidebarLogoText) sidebarLogoText.classList.add('hidden');
                if (sidebarUserInfo) sidebarUserInfo.classList.add('hidden');
                sidebarToggle.querySelector('i').classList.remove('fa-chevron-left');
                sidebarToggle.querySelector('i').classList.add('fa-chevron-right');
                isSidebarCollapsed = true;
                localStorage.setItem('sidebarCollapsed', 'true');
            }

            function expandSidebar() {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                sidebarTexts.forEach(text => text.classList.remove('hidden'));
                if (sidebarLogoText) sidebarLogoText.classList.remove('hidden');
                if (sidebarUserInfo) sidebarUserInfo.classList.remove('hidden');
                sidebarToggle.querySelector('i').classList.remove('fa-chevron-right');
                sidebarToggle.querySelector('i').classList.add('fa-chevron-left');
                isSidebarCollapsed = false;
                localStorage.setItem('sidebarCollapsed', 'false');
            }

            // Toggle sidebar
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    if (isSidebarCollapsed) {
                        expandSidebar();
                    } else {
                        collapseSidebar();
                    }
                });
            }

            // Show collapsed sidebar
            if (collapsedSidebarToggle) {
                collapsedSidebarToggle.addEventListener('click', () => {
                    expandSidebar();
                });
            }

            // Mobile sidebar toggle
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', () => {
                    sidebarMobile.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.remove('hidden');
                });
            }

            if (closeSidebarMobile) {
                closeSidebarMobile.addEventListener('click', () => {
                    sidebarMobile.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', () => {
                    sidebarMobile.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                });
            }

            // Theme toggle
            if (themeToggle) {
                // Check saved theme or prefer-color-scheme
                const savedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                    document.documentElement.classList.add('dark');
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                }

                themeToggle.addEventListener('click', () => {
                    document.documentElement.classList.toggle('dark');

                    if (document.documentElement.classList.contains('dark')) {
                        localStorage.setItem('theme', 'dark');
                        themeIcon.classList.remove('fa-moon');
                        themeIcon.classList.add('fa-sun');
                    } else {
                        localStorage.setItem('theme', 'light');
                        themeIcon.classList.remove('fa-sun');
                        themeIcon.classList.add('fa-moon');
                    }
                });
            }

            // User dropdown
            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', (e) => {
                    if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }

            // Initialize
            initializeSidebar();

            // Check online status
            function updateOnlineStatus() {
                const statusElements = document.querySelectorAll('.text-green-600, .text-green-400');
                if (navigator.onLine) {
                    statusElements.forEach(el => {
                        el.textContent = 'Online';
                        el.className = el.className.replace(/text-(red|yellow)-\d+/,
                            'text-green-600 dark:text-green-400');
                    });
                } else {
                    statusElements.forEach(el => {
                        el.textContent = 'Offline';
                        el.className = el.className.replace(/text-(green|yellow)-\d+/,
                            'text-red-600 dark:text-red-400');
                    });
                }
            }

            window.addEventListener('online', updateOnlineStatus);
            window.addEventListener('offline', updateOnlineStatus);
            updateOnlineStatus();

            // Toast notification function
            window.showToast = function(message, type = 'success') {
                const container = document.createElement('div');
                container.className = 'fixed top-4 right-4 z-50';

                const toast = document.createElement('div');
                toast.className =
                    `animate-fade-in bg-${type === 'success' ? 'green' : 'red'}-50 dark:bg-${type === 'success' ? 'green' : 'red'}-900/30 border border-${type === 'success' ? 'green' : 'red'}-200 dark:border-${type === 'success' ? 'green' : 'red'}-800 rounded-lg p-4 mb-2 flex items-center`;

                const icon = document.createElement('i');
                icon.className =
                    `fas ${type === 'success' ? 'fa-check-circle text-green-500' : 'fa-exclamation-circle text-red-500'} mr-3`;

                const text = document.createElement('div');
                text.className = 'flex-1';
                text.textContent = message;

                const close = document.createElement('button');
                close.className = 'ml-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300';
                close.innerHTML = '<i class="fas fa-times"></i>';
                close.onclick = function() {
                    container.remove();
                };

                toast.appendChild(icon);
                toast.appendChild(text);
                toast.appendChild(close);
                container.appendChild(toast);
                document.body.appendChild(container);

                setTimeout(() => {
                    if (container.parentNode) {
                        container.remove();
                    }
                }, 5000);
            };
        });
    </script>

    @stack('scripts')
</body>

</html>
