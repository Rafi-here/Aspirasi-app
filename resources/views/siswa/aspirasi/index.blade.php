@extends('layouts.siswa')

@section('title', 'Daftar Aspirasi')
@section('breadcrumb')
    <nav class="flex py-3 px-2 rounded-lg bg-white shadow-sm border border-gray-200 mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('siswa.dashboard') }}"
                    class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                    <i class="fas fa-home mr-2 text-blue-500"></i>
                    Dashboard
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                    <span class="ml-1 font-medium text-gray-800">Aspirasi Saya</span>
                </div>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">Aspirasi Saya</h1>
                    <p class="mt-2 opacity-90">Kelola dan pantau semua aspirasi yang telah kamu ajukan</p>
                    <div class="mt-4 flex items-center gap-2 text-sm">
                        <span class="bg-white/20 px-3 py-1 rounded-full">
                            <i class="fas fa-inbox mr-1"></i>
                            {{ $aspirasis->total() }} total aspirasi
                        </span>
                        @if (request('status'))
                            <span class="bg-white/20 px-3 py-1 rounded-full">
                                <i class="fas fa-filter mr-1"></i>
                                Filter: {{ ucfirst(request('status')) }}
                            </span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('siswa.aspirasi.create') }}"
                    class="mt-4 md:mt-0 inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-all duration-300 hover:scale-105 shadow-lg">
                    <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-plus text-blue-600 text-sm"></i>
                    </div>
                    <span>Ajukan Aspirasi Baru</span>
                </a>
            </div>
        </div>

        <!-- Status Filter Tabs -->
        <div class="bg-white rounded-2xl shadow-lg p-4 border border-gray-200">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('siswa.aspirasi.index') }}"
                    class="group flex items-center gap-2 px-4 py-3 rounded-xl transition-all duration-300 hover:scale-105 {{ !request('status') ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                    <i class="fas fa-layer-group {{ !request('status') ? 'text-white' : 'text-gray-500' }}"></i>
                    <span class="font-medium">Semua</span>
                    <span
                        class="ml-2 bg-white/20 px-2 py-0.5 rounded-full text-xs font-bold {{ !request('status') ? 'bg-white/30' : 'bg-gray-300 text-gray-700' }}">
                        {{ Auth::user()->aspirasis()->count() }}
                    </span>
                </a>

                @php
                    $statusFilters = [
                        'menunggu' => [
                            'color' => 'yellow',
                            'icon' => 'fas fa-clock',
                            'count' => Auth::user()->aspirasis()->where('status', 'menunggu')->count(),
                        ],
                        'diproses' => [
                            'color' => 'blue',
                            'icon' => 'fas fa-cogs',
                            'count' => Auth::user()->aspirasis()->where('status', 'diproses')->count(),
                        ],
                        'selesai' => [
                            'color' => 'green',
                            'icon' => 'fas fa-check-circle',
                            'count' => Auth::user()->aspirasis()->where('status', 'selesai')->count(),
                        ],
                        'ditolak' => [
                            'color' => 'red',
                            'icon' => 'fas fa-times-circle',
                            'count' => Auth::user()->aspirasis()->where('status', 'ditolak')->count(),
                        ],
                    ];
                @endphp

                @foreach ($statusFilters as $status => $filter)
                    <a href="{{ route('siswa.aspirasi.index', ['status' => $status]) }}"
                        class="group flex items-center gap-2 px-4 py-3 rounded-xl transition-all duration-300 hover:scale-105 {{ request('status') == $status ? 'bg-' . $filter['color'] . '-600 text-white shadow-lg' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                        <i
                            class="{{ $filter['icon'] }} {{ request('status') == $status ? 'text-white' : 'text-' . $filter['color'] . '-500' }}"></i>
                        <span class="font-medium">{{ ucfirst($status) }}</span>
                        <span
                            class="ml-2 px-2 py-0.5 rounded-full text-xs font-bold {{ request('status') == $status ? 'bg-white/30' : 'bg-gray-300 text-gray-700' }}">
                            {{ $filter['count'] }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Search and Sort -->
        <div class="bg-white rounded-2xl shadow-lg p-4 border border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" placeholder="Cari aspirasi..."
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        id="searchInput">
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <select
                            class="appearance-none px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white pr-10">
                            <option>Terbaru</option>
                            <option>Terlama</option>
                            <option>A-Z Judul</option>
                            <option>Z-A Judul</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-sort text-gray-400"></i>
                        </div>
                    </div>
                    <button
                        class="px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors shadow-sm">
                        <i class="fas fa-filter"></i>
                        <span class="hidden md:inline ml-2">Filter Lanjut</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Aspirasi List -->
        <div class="space-y-4">
            @forelse($aspirasis as $aspirasi)
                <div
                    class="group bg-white rounded-2xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-md">
                                        <i class="fas fa-lightbulb text-white text-lg"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h3
                                                class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                                {{ $aspirasi->judul }}
                                            </h3>
                                            <span
                                                class="hidden md:inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $aspirasi->status_color }}-100 text-{{ $aspirasi->status_color }}-800 border border-{{ $aspirasi->status_color }}-200">
                                                <i
                                                    class="fas {{ $aspirasi->status == 'selesai' ? 'fa-check-circle' : ($aspirasi->status == 'diproses' ? 'fa-cogs' : 'fa-clock') }} mr-1.5"></i>
                                                {{ ucfirst($aspirasi->status) }}
                                            </span>
                                        </div>

                                        <p class="text-gray-600 mt-2 line-clamp-2">
                                            {{ $aspirasi->deskripsi }}
                                        </p>

                                        <div class="flex flex-wrap items-center gap-4 mt-4">
                                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                                <i class="fas fa-tag text-blue-500"></i>
                                                <span
                                                    class="font-medium text-gray-700">{{ $aspirasi->kategori->nama_kategori }}</span>
                                            </div>

                                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                                <i class="fas fa-calendar-alt text-blue-500"></i>
                                                <span
                                                    class="font-medium text-gray-700">{{ $aspirasi->created_at->format('d F Y') }}</span>
                                            </div>

                                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                                <i class="fas fa-clock text-blue-500"></i>
                                                <span
                                                    class="font-medium text-gray-700">{{ $aspirasi->created_at->format('H:i') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="md:hidden">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $aspirasi->status_color }}-100 text-{{ $aspirasi->status_color }}-800 border border-{{ $aspirasi->status_color }}-200">
                                        {{ ucfirst($aspirasi->status) }}
                                    </span>
                                </div>
                                <a href="{{ route('siswa.aspirasi.show', $aspirasi) }}"
                                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all duration-300 hover:scale-105 shadow-sm">
                                    <i class="fas fa-eye"></i>
                                    <span>Detail</span>
                                </a>
                            </div>
                        </div>

                        <!-- Progress Bar for Diproses Status -->
                        @if ($aspirasi->status == 'diproses')
                            <div class="mt-6">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Progress Penanganan</span>
                                    <span class="text-sm font-bold text-blue-600">60%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full transition-all duration-500"
                                        style="width: 60%"></div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Response Indicator (for selesai status) -->
                    @if ($aspirasi->status == 'selesai' && $aspirasi->updated_at)
                        <div class="px-6 py-3 bg-green-50 border-t border-green-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-check text-green-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-green-700">Sudah ditanggapi</span>
                                </div>
                                <span class="text-sm text-green-600">
                                    {{ $aspirasi->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div
                            class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center mb-6">
                            <i class="fas fa-inbox text-blue-400 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum ada aspirasi</h3>
                        <p class="text-gray-600 mb-8">
                            @if (request('status'))
                                Tidak ada aspirasi dengan status "{{ ucfirst(request('status')) }}" yang ditemukan.
                            @else
                                Mulai ajukan aspirasi pertamamu untuk meningkatkan lingkungan sekolah.
                            @endif
                        </p>
                        <a href="{{ route('siswa.aspirasi.create') }}"
                            class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl transition-all duration-300 hover:scale-105 shadow-lg">
                            <i class="fas fa-plus"></i>
                            <span>Ajukan Aspirasi Pertama</span>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($aspirasis->hasPages())
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="text-sm text-gray-600">
                        Menampilkan
                        <span class="font-bold text-gray-800">{{ $aspirasis->firstItem() ?? 0 }}</span>
                        sampai
                        <span class="font-bold text-gray-800">{{ $aspirasis->lastItem() ?? 0 }}</span>
                        dari
                        <span class="font-bold text-gray-800">{{ $aspirasis->total() }}</span>
                        aspirasi
                    </div>
                    <div class="flex items-center justify-center">
                        <nav class="flex items-center space-x-1">
                            {{ $aspirasis->onEachSide(1)->links('vendor.pagination.custom-siswa') }}
                        </nav>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Custom CSS for better typography -->
    <style>
        /* Improved typography */
        .text-gray-900 {
            color: #111827 !important;
        }

        .text-gray-800 {
            color: #1f2937 !important;
        }

        .text-gray-700 {
            color: #374151 !important;
        }

        .text-gray-600 {
            color: #4b5563 !important;
        }

        .text-gray-500 {
            color: #6b7280 !important;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .group:hover .group-hover\:text-blue-600 {
            color: #2563eb !important;
        }

        /* Card hover effects */
        .group:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        }

        /* Line clamp for description */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom pagination styles */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 4px;
        }

        .page-item.active .page-link {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
            transform: scale(1.05);
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            color: #4b5563;
            font-weight: 500;
            transition: all 0.2s;
        }

        .page-link:hover {
            background-color: #f3f4f6;
            border-color: #d1d5db;
            transform: translateY(-1px);
        }

        /* Gradient backgrounds */
        .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
        }
    </style>

    <!-- JavaScript for interactivity -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function(e) {
                    if (e.key === 'Enter') {
                        const searchTerm = this.value.trim();
                        if (searchTerm) {
                            window.location.href = '{{ route('siswa.aspirasi.index') }}?search=' +
                                encodeURIComponent(searchTerm);
                        }
                    }
                });
            }

            // Add animation to cards on load
            const cards = document.querySelectorAll('.group');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Add click effect to cards
            cards.forEach(card => {
                card.addEventListener('click', function(e) {
                    // Only if not clicking on links or buttons
                    if (!e.target.closest('a') && !e.target.closest('button')) {
                        const detailLink = this.querySelector('a[href*="/aspirasi/"]');
                        if (detailLink) {
                            detailLink.click();
                        }
                    }
                });
            });

            // Status filter animation
            const filterButtons = document.querySelectorAll('a[href*="status="]');
            filterButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!this.classList.contains('bg-blue-600') &&
                        !this.classList.contains('bg-yellow-600') &&
                        !this.classList.contains('bg-green-600') &&
                        !this.classList.contains('bg-red-600')) {
                        this.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 150);
                    }
                });
            });
        });
    </script>

    <!-- Custom Pagination View (if needed) -->
    @if ($aspirasis->hasPages() && !View::exists('vendor.pagination.custom-siswa'))
        @push('scripts')
            <style>
                /* Additional pagination styles */
                .page-item:first-child .page-link,
                .page-item:last-child .page-link {
                    border-radius: 10px;
                }

                .page-item.disabled .page-link {
                    opacity: 0.5;
                    cursor: not-allowed;
                }

                .page-item:not(.disabled):hover .page-link {
                    background-color: #f3f4f6;
                    transform: translateY(-1px);
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                }
            </style>
        @endpush
    @endif
@endsection
