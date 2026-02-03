@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')
    <div class="space-y-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">Selamat datang, {{ Auth::user()->name }}! 👋</h1>
                    <p class="mt-2 opacity-90">Kelola aspirasimu dan pantau perkembangan di sini</p>
                </div>
                <a href="{{ route('siswa.aspirasi.create') }}"
                    class="mt-4 md:mt-0 inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-all duration-300 hover:scale-105 shadow-lg">
                    <i class="fas fa-plus"></i>
                    <span>Ajukan Aspirasi Baru</span>
                </a>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $stats = [
                    [
                        'status' => 'menunggu',
                        'title' => 'Menunggu',
                        'color' => 'yellow',
                        'icon' => 'fas fa-clock',
                        'count' => Auth::user()->aspirasis()->where('status', 'menunggu')->count(),
                        'gradient' => 'from-yellow-400 to-amber-500',
                        'bg' => 'bg-gradient-to-br from-yellow-50 to-amber-50',
                        'border' => 'border border-yellow-200',
                        'text' => 'text-yellow-800',
                    ],
                    [
                        'status' => 'diproses',
                        'title' => 'Diproses',
                        'color' => 'blue',
                        'icon' => 'fas fa-cogs',
                        'count' => Auth::user()->aspirasis()->where('status', 'diproses')->count(),
                        'gradient' => 'from-blue-400 to-blue-500',
                        'bg' => 'bg-gradient-to-br from-blue-50 to-blue-100',
                        'border' => 'border border-blue-200',
                        'text' => 'text-blue-800',
                    ],
                    [
                        'status' => 'selesai',
                        'title' => 'Selesai',
                        'color' => 'green',
                        'icon' => 'fas fa-check-circle',
                        'count' => Auth::user()->aspirasis()->where('status', 'selesai')->count(),
                        'gradient' => 'from-green-400 to-emerald-500',
                        'bg' => 'bg-gradient-to-br from-green-50 to-emerald-50',
                        'border' => 'border border-green-200',
                        'text' => 'text-green-800',
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div
                    class="group relative overflow-hidden {{ $stat['bg'] }} {{ $stat['border'] }} rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-br {{ $stat['gradient'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                    </div>

                    <div class="relative flex items-center">
                        <div class="relative">
                            <div
                                class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $stat['gradient'] }} flex items-center justify-center shadow-lg">
                                <i class="{{ $stat['icon'] }} text-white text-2xl"></i>
                            </div>
                            @if ($stat['count'] > 0)
                                <div
                                    class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-white border-2 border-{{ $stat['color'] }}-500 flex items-center justify-center shadow-md">
                                    <span class="text-xs font-bold {{ $stat['text'] }}">{{ $stat['count'] }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="ml-6">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $stat['title'] }}</h3>
                            <p class="text-4xl font-bold text-gray-900 mt-2">{{ $stat['count'] }}</p>
                            <p class="text-sm text-gray-600 mt-1">aspirasi</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <a href="{{ route('siswa.aspirasi.index', ['status' => $stat['status']]) }}"
                            class="inline-flex items-center gap-1 {{ $stat['text'] }} hover:text-{{ $stat['color'] }}-600 font-medium">
                            <span>Lihat semua</span>
                            <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('siswa.aspirasi.create') }}"
                class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-4 rounded-xl flex items-center justify-center gap-3 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fas fa-plus text-lg"></i>
                </div>
                <span class="font-semibold">Aspirasi Baru</span>
            </a>

            <a href="{{ route('siswa.aspirasi.index') }}"
                class="group bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-4 rounded-xl flex items-center justify-center gap-3 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fas fa-list text-lg"></i>
                </div>
                <span class="font-semibold">Semua Aspirasi</span>
            </a>

            <a href="{{ route('siswa.aspirasi.index', ['status' => 'menunggu']) }}"
                class="group bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white p-4 rounded-xl flex items-center justify-center gap-3 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fas fa-clock text-lg"></i>
                </div>
                <span class="font-semibold">Menunggu</span>
            </a>

            <a href="{{ route('siswa.aspirasi.index', ['status' => 'selesai']) }}"
                class="group bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white p-4 rounded-xl flex items-center justify-center gap-3 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fas fa-check-circle text-lg"></i>
                </div>
                <span class="font-semibold">Selesai</span>
            </a>
        </div>

        <!-- Aspirasi Terbaru -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Aspirasi Terbaru</h3>
                        <p class="text-sm text-gray-600 mt-1">5 aspirasi terakhir yang kamu ajukan</p>
                    </div>
                    <a href="{{ route('siswa.aspirasi.index') }}"
                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                        <span>Lihat semua</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider bg-gray-100">
                                Judul Aspirasi
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider bg-gray-100">
                                Kategori
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider bg-gray-100">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider bg-gray-100">
                                Tanggal
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider bg-gray-100">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse(Auth::user()->aspirasis()->latest()->take(5)->get() as $aspirasi)
                            <tr class="hover:bg-blue-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <a href="{{ route('siswa.aspirasi.show', $aspirasi) }}"
                                            class="font-medium text-gray-900 hover:text-blue-600 transition-colors">
                                            {{ Str::limit($aspirasi->judul, 50) }}
                                        </a>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ Str::limit($aspirasi->deskripsi, 70) }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        <i class="fas fa-tag mr-1.5"></i>
                                        {{ $aspirasi->kategori->nama_kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'menunggu' => [
                                                'bg' => 'bg-yellow-100',
                                                'text' => 'text-yellow-800',
                                                'border' => 'border-yellow-200',
                                                'icon' => 'fas fa-clock',
                                            ],
                                            'diproses' => [
                                                'bg' => 'bg-blue-100',
                                                'text' => 'text-blue-800',
                                                'border' => 'border-blue-200',
                                                'icon' => 'fas fa-cogs',
                                            ],
                                            'selesai' => [
                                                'bg' => 'bg-green-100',
                                                'text' => 'text-green-800',
                                                'border' => 'border-green-200',
                                                'icon' => 'fas fa-check-circle',
                                            ],
                                            'ditolak' => [
                                                'bg' => 'bg-red-100',
                                                'text' => 'text-red-800',
                                                'border' => 'border-red-200',
                                                'icon' => 'fas fa-times-circle',
                                            ],
                                        ];
                                        $config = $statusConfig[$aspirasi->status] ?? [
                                            'bg' => 'bg-gray-100',
                                            'text' => 'text-gray-800',
                                            'border' => 'border-gray-200',
                                            'icon' => 'fas fa-question',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">
                                        <i class="{{ $config['icon'] }} mr-1.5"></i>
                                        {{ ucfirst($aspirasi->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $aspirasi->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $aspirasi->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('siswa.aspirasi.show', $aspirasi) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors shadow-sm">
                                        <i class="fas fa-eye"></i>
                                        <span>Detail</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <div
                                            class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                                            <i class="fas fa-inbox text-blue-400 text-2xl"></i>
                                        </div>
                                        <p class="text-lg font-medium text-gray-700 mb-2">Belum ada aspirasi</p>
                                        <p class="text-sm text-gray-600 mb-4">Mulai ajukan aspirasi pertamamu</p>
                                        <a href="{{ route('siswa.aspirasi.create') }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors shadow-sm">
                                            <i class="fas fa-plus"></i>
                                            <span>Ajukan Aspirasi</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tips & Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl border border-blue-200 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-lightbulb text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-3">Tips Mengajukan Aspirasi</h4>
                        <ul class="space-y-2">
                            <li class="flex items-start gap-2">
                                <div class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center mt-0.5">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="text-sm text-gray-700">Jelaskan dengan spesifik dan jelas apa yang ingin kamu
                                    sampaikan</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center mt-0.5">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="text-sm text-gray-700">Sertakan solusi atau saran yang kamu usulkan</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center mt-0.5">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="text-sm text-gray-700">Periksa kembali tulisanmu sebelum submit</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-2xl border border-green-200 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                        <i class="fas fa-chart-line text-green-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900 mb-3">Statistik Keseluruhan</h4>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ Auth::user()->aspirasis()->count() }}
                                </div>
                                <div class="text-xs text-gray-600 font-medium">Total Aspirasi</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">
                                    {{ Auth::user()->aspirasis()->where('status', 'selesai')->count() }}
                                </div>
                                <div class="text-xs text-gray-600 font-medium">Selesai</div>
                            </div>
                            <div class="text-center">
                                @php
                                    $total = Auth::user()->aspirasis()->count();
                                    $responded = Auth::user()
                                        ->aspirasis()
                                        ->whereIn('status', ['selesai', 'diproses'])
                                        ->count();
                                    $responseRate = $total > 0 ? round(($responded / $total) * 100, 0) : 0;
                                @endphp
                                <div class="text-2xl font-bold text-blue-600">
                                    {{ $responseRate }}%
                                </div>
                                <div class="text-xs text-gray-600 font-medium">Response Rate</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Enhanced typography for better readability */
        .text-gray-900 {
            color: #1f2937 !important;
        }

        .text-gray-800 {
            color: #374151 !important;
        }

        .text-gray-700 {
            color: #4b5563 !important;
        }

        .text-gray-600 {
            color: #6b7280 !important;
        }

        .text-gray-500 {
            color: #9ca3af !important;
        }

        /* Better contrast for cards */
        .bg-blue-50 {
            background-color: #eff6ff !important;
        }

        .bg-green-50 {
            background-color: #f0fdf4 !important;
        }

        .bg-yellow-50 {
            background-color: #fefce8 !important;
        }

        /* Enhanced shadows for depth */
        .shadow-lg {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        }

        .shadow-sm {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1),
                0 1px 2px 0 rgba(0, 0, 0, 0.06) !important;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .transition-colors {
            transition: color 0.2s, background-color 0.2s, border-color 0.2s !important;
        }

        /* Clear hover states */
        .hover\:bg-blue-50:hover {
            background-color: #eff6ff !important;
        }

        .hover\:bg-blue-700:hover {
            background-color: #1d4ed8 !important;
        }

        .hover\:text-blue-600:hover {
            color: #2563eb !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add subtle animation to cards
            const cards = document.querySelectorAll('.group');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(10px)';

                    setTimeout(() => {
                        card.style.transition = 'all 0.4s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                }, index * 100);
            });

            // Add subtle border animation on hover for table rows
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.borderLeft = '3px solid #3b82f6';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.borderLeft = 'none';
                });
            });
        });
    </script>
@endsection
