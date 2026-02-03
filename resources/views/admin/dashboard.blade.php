@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Header dengan Breadcrumb -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
                <p class="text-gray-600 mt-2">Selamat datang kembali, <span
                        class="font-semibold text-blue-600">{{ Auth::user()->name }}</span>!</p>
                <div class="flex items-center mt-2 text-sm text-gray-500">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>

            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('admin.statistik.index') }}"
                    class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-chart-line mr-2"></i> Analytics
                </a>
                <a href="{{ route('admin.export.data') }}"
                    class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-file-export mr-2"></i> Export Data
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats dengan Gradient -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Aspirasi -->
        <div
            class="bg-gradient-to-br from-blue-50 to-white border border-blue-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 mb-1">Total Aspirasi</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $totalAspirasi }}</h3>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-xl shadow-md">
                    <i class="fas fa-inbox text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-500">Semua waktu</span>
            </div>
        </div>

        <!-- Menunggu -->
        <div
            class="bg-gradient-to-br from-yellow-50 to-white border border-yellow-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-yellow-600 mb-1">Menunggu</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $aspirasiMenunggu }}</h3>
                </div>
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 p-4 rounded-xl shadow-md">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Perlu tindakan</span>
                    @if ($totalAspirasi > 0)
                        <span class="font-semibold text-yellow-700">
                            {{ number_format(($aspirasiMenunggu / $totalAspirasi) * 100, 1) }}%
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Diproses -->
        <div
            class="bg-gradient-to-br from-indigo-50 to-white border border-indigo-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-indigo-600 mb-1">Diproses</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $aspirasiDiproses }}</h3>
                </div>
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-4 rounded-xl shadow-md">
                    <i class="fas fa-cogs text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Dalam penanganan</span>
                    @if ($totalAspirasi > 0)
                        <span class="font-semibold text-indigo-700">
                            {{ number_format(($aspirasiDiproses / $totalAspirasi) * 100, 1) }}%
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Selesai -->
        <div
            class="bg-gradient-to-br from-green-50 to-white border border-green-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600 mb-1">Selesai</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $aspirasiSelesai }}</h3>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-4 rounded-xl shadow-md">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Telah diselesaikan</span>
                    @if ($totalAspirasi > 0)
                        <span class="font-semibold text-green-700">
                            {{ number_format(($aspirasiSelesai / $totalAspirasi) * 100, 1) }}%
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Cards -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-bolt text-yellow-500 mr-2"></i> Fast Menu
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Analytics Card -->
            <a href="{{ route('admin.statistik.index') }}"
                class="group bg-gradient-to-br from-blue-50 via-white to-blue-50 border border-blue-200 rounded-2xl p-6 shadow-lg hover:shadow-2xl hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start">
                    <div
                        class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chart-pie text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600">Detail Analytics</h3>
                        <p class="text-sm text-gray-600 mt-2">Analisis data mendalam dengan grafik interaktif dan filter
                            periode</p>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <span class="text-sm font-medium text-blue-600">Lihat Analytics</span>
                    <div class="w-10 h-1 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"></div>
                </div>
            </a>

            <!-- Export Card -->
            <a href="{{ route('admin.export.data') }}?type=aspirasi&format=csv"
                class="group bg-gradient-to-br from-green-50 via-white to-green-50 border border-green-200 rounded-2xl p-6 shadow-lg hover:shadow-2xl hover:border-green-300 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start">
                    <div
                        class="bg-gradient-to-br from-green-500 to-green-600 p-4 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-csv text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-green-600">Export Data</h3>
                        <p class="text-sm text-gray-600 mt-2">Export data dalam format CSV, Excel, atau PDF dengan filter
                            custom</p>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <span class="text-sm font-medium text-green-600">Expor Now →</span>
                    <div class="w-10 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full"></div>
                </div>
            </a>

            <!-- Manage Card -->
            <a href="{{ route('admin.aspirasi.index') }}"
                class="group bg-gradient-to-br from-purple-50 via-white to-purple-50 border border-purple-200 rounded-2xl p-6 shadow-lg hover:shadow-2xl hover:border-purple-300 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start">
                    <div
                        class="bg-gradient-to-br from-purple-500 to-purple-600 p-4 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-inbox text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-600">Kelola Aspirasi</h3>
                        <p class="text-sm text-gray-600 mt-2">Kelola semua aspirasi siswa dengan filter lengkap dan aksi
                            cepat</p>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <span class="text-sm font-medium text-purple-600">Manage Now →</span>
                    <div class="w-10 h-1 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full"></div>
                </div>
            </a>
        </div>
    </div>

    <!-- Main Content dengan Tab -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Kiri: Kategori Distribution dengan Chart -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i> Distribusi Berdasarkan Kategori
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-5">
                    @foreach ($kategoriStats as $kategori)
                        @php
                            $percentage = $totalAspirasi > 0 ? ($kategori->aspirasis_count / $totalAspirasi) * 100 : 0;
                            $colorClasses = [
                                'bg-gradient-to-r from-blue-500 to-blue-600',
                                'bg-gradient-to-r from-green-500 to-green-600',
                                'bg-gradient-to-r from-purple-500 to-purple-600',
                                'bg-gradient-to-r from-yellow-500 to-yellow-600',
                                'bg-gradient-to-r from-red-500 to-red-600',
                                'bg-gradient-to-r from-indigo-500 to-indigo-600',
                                'bg-gradient-to-r from-pink-500 to-pink-600',
                            ];
                            $colorIndex = $loop->index % count($colorClasses);
                        @endphp
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="{{ $colorClasses[$colorIndex] }} w-3 h-3 rounded-full mr-3"></div>
                                    <span class="font-medium text-gray-800">{{ $kategori->nama_kategori }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-gray-900">{{ $kategori->aspirasis_count }}</span>
                                    <span class="text-sm text-gray-500 ml-2">({{ number_format($percentage, 1) }}%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                <div class="{{ $colorClasses[$colorIndex] }} h-2.5 rounded-full transition-all duration-1000 ease-out"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Legend -->
                @if ($kategoriStats->count() > 0)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Kategori Aspirasi</h4>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach ($kategoriStats as $kategori)
                                <div class="flex items-center text-sm">
                                    @php
                                        $colorClasses = [
                                            'bg-blue-500',
                                            'bg-green-500',
                                            'bg-purple-500',
                                            'bg-yellow-500',
                                            'bg-red-500',
                                            'bg-indigo-500',
                                            'bg-pink-500',
                                        ];
                                        $colorIndex = $loop->index % count($colorClasses);
                                    @endphp
                                    <span class="w-2 h-2 {{ $colorClasses[$colorIndex] }} rounded-full mr-2"></span>
                                    <span class="text-gray-600 truncate">{{ $kategori->nama_kategori }}</span>
                                    <span class="ml-auto font-medium">{{ $kategori->aspirasis_count }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Kanan: Recent Activities -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <i class="fas fa-history mr-2"></i> Aktivitas Terakhir
                    </h3>
                    <a href="{{ route('admin.aspirasi.index') }}"
                        class="text-indigo-100 hover:text-white text-sm font-medium">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    @forelse($aspirasiTerbaru as $aspirasi)
                        <div class="flex items-start pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 rounded-xl flex items-center justify-center 
                                @if ($aspirasi->status == 'selesai') bg-gradient-to-br from-green-100 to-green-50 text-green-600
                                @elseif($aspirasi->status == 'diproses') bg-gradient-to-br from-blue-100 to-blue-50 text-blue-600
                                @elseif($aspirasi->status == 'menunggu') bg-gradient-to-br from-yellow-100 to-yellow-50 text-yellow-600
                                @else bg-gradient-to-br from-gray-100 to-gray-50 text-gray-600 @endif">
                                    @if ($aspirasi->is_anonim)
                                        <i class="fas fa-user-secret text-lg"></i>
                                    @else
                                        @php
                                            $initials = implode(
                                                '',
                                                array_map(
                                                    fn($n) => strtoupper(substr($n, 0, 1)),
                                                    explode(' ', $aspirasi->user->name ?? 'A'),
                                                ),
                                            );
                                            $initials = substr($initials, 0, 2);
                                        @endphp
                                        <span class="font-bold">{{ $initials }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="ml-4 flex-1">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="font-bold text-gray-900 hover:text-blue-600 transition-colors">
                                            <a href="{{ route('admin.aspirasi.show', $aspirasi) }}">
                                                {{ Str::limit($aspirasi->judul, 40) }}
                                            </a>
                                        </h4>
                                        <div class="flex items-center mt-1 text-sm text-gray-500">
                                            <span class="flex items-center">
                                                <i class="fas fa-user mr-1"></i>
                                                {{ $aspirasi->nama_siswa }}
                                            </span>
                                            <span class="mx-2">•</span>
                                            <span class="flex items-center">
                                                <i class="fas fa-tag mr-1"></i>
                                                {{ $aspirasi->kategori->nama_kategori }}
                                            </span>
                                        </div>
                                    </div>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold 
                                    @if ($aspirasi->status == 'selesai') bg-green-100 text-green-800
                                    @elseif($aspirasi->status == 'diproses') bg-blue-100 text-blue-800
                                    @elseif($aspirasi->status == 'menunggu') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($aspirasi->status) }}
                                    </span>
                                </div>

                                <p class="mt-3 text-sm text-gray-600">
                                    {{ Str::limit(strip_tags($aspirasi->deskripsi), 80) }}
                                </p>

                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-xs text-gray-500 flex items-center">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $aspirasi->created_at->diffForHumans() }}
                                    </span>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.aspirasi.show', $aspirasi) }}"
                                            class="text-xs px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg font-medium transition-colors">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <div
                                class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center">
                                <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-700">Tidak ada aktivitas.</h4>
                            <p class="text-gray-500 mt-2">Tidak ada aspirasi baru-baru ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <!-- Monthly Trend -->
        <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-2xl p-6 shadow-lg">
            <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-chart-line text-blue-500 mr-2"></i> Bulan
            </h4>
            @if ($bulanStats->count() > 0)
                <div class="flex items-end h-32 space-x-2">
                    @foreach ($bulanStats->take(6) as $stat)
                        @php
                            $maxValue = $bulanStats->max('total');
                            $height = $maxValue > 0 ? ($stat->total / $maxValue) * 80 : 10;
                            $monthNames = [
                                'Jan',
                                'Feb',
                                'Mar',
                                'Apr',
                                'May',
                                'Jun',
                                'Jul',
                                'Aug',
                                'Sep',
                                'Oct',
                                'Nov',
                                'Dec',
                            ];
                        @endphp
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full flex justify-center">
                                <div class="w-8 bg-gradient-to-t from-blue-400 to-blue-500 rounded-t-lg transition-all duration-500 hover:opacity-90"
                                    style="height: {{ $height }}px"
                                    title="{{ $stat->total }} aspirations in {{ $monthNames[$stat->bulan - 1] ?? $stat->bulan }}">
                                </div>
                            </div>
                            <div class="text-xs text-gray-500 mt-2">{{ $monthNames[$stat->bulan - 1] ?? $stat->bulan }}
                            </div>
                            <div class="text-xs font-bold text-gray-700">{{ $stat->total }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <p class="text-gray-500">Tidak ada data masuk bulan ini</p>
                </div>
            @endif
        </div>

        <!-- Top Students -->
        <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-2xl p-6 shadow-lg">
            <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-crown text-yellow-500 mr-2"></i> Pengirim Teratas
            </h4>
            @if ($topSiswa->count() > 0)
                <div class="space-y-4">
                    @foreach ($topSiswa->take(5) as $index => $siswa)
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 flex items-center justify-center rounded-lg 
                        @if ($index == 0) bg-gradient-to-br from-yellow-500 to-yellow-600 text-white
                        @elseif($index == 1) bg-gradient-to-br from-gray-400 to-gray-500 text-white
                        @elseif($index == 2) bg-gradient-to-br from-yellow-700 to-yellow-800 text-white
                        @else bg-gray-100 text-gray-600 @endif font-bold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="font-medium text-gray-900 truncate">{{ $siswa->name }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ $siswa->email }}</div>
                            </div>
                            <div class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg font-bold">
                                {{ $siswa->aspirasis_count }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <p class="text-gray-500">Tidak ada data aspirasi masuk</p>
                </div>
            @endif
        </div>

        <!-- Daily Stats -->
        <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-2xl p-6 shadow-lg">
            <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-calendar-day text-green-500 mr-2"></i> Total Aspirasi
            </h4>
            @php
                $today = \Carbon\Carbon::today();
                $tomorrow = \Carbon\Carbon::tomorrow();
                $todayCount = \App\Models\Aspirasi::whereBetween('created_at', [$today, $tomorrow])->count();
                $todayCompleted = \App\Models\Aspirasi::whereBetween('updated_at', [$today, $tomorrow])
                    ->where('status', 'selesai')
                    ->count();
            @endphp
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-plus text-white"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Aspirasi Hari Ini</div>
                            <div class="text-xl font-bold text-gray-900">{{ $todayCount }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500">Aspirasi</div>
                        <div class="text-xs font-medium text-blue-600">
                            @if ($todayCount > 0)
                                +{{ $todayCount }}
                            @else
                                0
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-green-100 rounded-xl">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Aspirasi Selesai</div>
                            <div class="text-xl font-bold text-gray-900">{{ $todayCompleted }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500">Terselesaikan</div>
                        <div class="text-xs font-medium text-green-600">
                            @if ($todayCompleted > 0)
                                +{{ $todayCompleted }}
                            @else
                                0
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-8 text-center text-sm text-gray-500">
        <p>Last updated: {{ now()->format('H:i:s') }} • System is running smoothly</p>
        <div class="flex items-center justify-center mt-2 space-x-4">
            <span class="flex items-center">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                All systems operational
            </span>
            <span>•</span>
            <span>Dashboard Aspirasi Siswa</span>
        </div>
    </div>

    @push('styles')
        <style>
            .animate-progress {
                animation: progressAnimation 1s ease-out;
            }

            @keyframes progressAnimation {
                from {
                    width: 0;
                }

                to {
                    width: var(--progress-width);
                }
            }

            .gradient-border {
                border: 2px solid transparent;
                background: linear-gradient(white, white) padding-box,
                    linear-gradient(45deg, #3b82f6, #8b5cf6) border-box;
            }

            .hover-lift {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .hover-lift:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Animate progress bars on load
            document.addEventListener('DOMContentLoaded', function() {
                const progressBars = document.querySelectorAll('[style*="width:"]');
                progressBars.forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0';
                    setTimeout(() => {
                        bar.style.transition = 'width 1s ease-out';
                        bar.style.width = width;
                    }, 300);
                });

                // Add hover effects to cards
                const cards = document.querySelectorAll('.bg-gradient-to-br');
                cards.forEach(card => {
                    card.addEventListener('mouseenter', () => {
                        card.classList.add('shadow-2xl');
                    });
                    card.addEventListener('mouseleave', () => {
                        card.classList.remove('shadow-2xl');
                    });
                });
            });
        </script>
    @endpush
@endsection
