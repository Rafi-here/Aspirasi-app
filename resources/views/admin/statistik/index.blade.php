@extends('layouts.admin')

@section('title', 'Statistik & Laporan')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Statistik & Laporan</h2>
            <p class="text-gray-600 dark:text-gray-400">Analisis data aspirasi siswa</p>
        </div>

        <!-- Filter Periode -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Filter Periode</h3>
            <form action="{{ route('admin.statistik.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Periode</label>
                    <select name="periode"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                        onchange="this.form.submit()">
                        <option value="minggu_ini" {{ $periode == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="bulan_ini" {{ $periode == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="tahun_ini" {{ $periode == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                        <option value="semua" {{ $periode == 'semua' ? 'selected' : '' }}>Semua Data</option>
                        <option value="custom" {{ $periode == 'custom' ? 'selected' : '' }}>Custom Range</option>
                    </select>
                </div>

                @if ($periode == 'custom')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sampai
                            Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg w-full transition-colors">
                            Terapkan Filter
                        </button>
                    </div>
                @endif
            </form>
        </div>

        <!-- Statistik Utama -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Aspirasi -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-full">
                        <i class="fas fa-inbox text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Aspirasi</h3>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalAspirasi }}</p>
                    </div>
                </div>
            </div>

            <!-- Status Cards -->
            @foreach ($statusStats as $stat)
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <div class="flex items-center">
                        @php
                            $colors = [
                                'menunggu' => [
                                    'bg' => 'yellow-100 dark:bg-yellow-900/30',
                                    'text' => 'yellow-600 dark:text-yellow-400',
                                    'icon' => 'fas fa-clock',
                                ],
                                'diproses' => [
                                    'bg' => 'blue-100 dark:bg-blue-900/30',
                                    'text' => 'blue-600 dark:text-blue-400',
                                    'icon' => 'fas fa-cogs',
                                ],
                                'selesai' => [
                                    'bg' => 'green-100 dark:bg-green-900/30',
                                    'text' => 'green-600 dark:text-green-400',
                                    'icon' => 'fas fa-check-circle',
                                ],
                                'ditolak' => [
                                    'bg' => 'red-100 dark:bg-red-900/30',
                                    'text' => 'red-600 dark:text-red-400',
                                    'icon' => 'fas fa-times-circle',
                                ],
                            ];
                            $color = $colors[$stat->status] ?? [
                                'bg' => 'gray-100 dark:bg-gray-700',
                                'text' => 'gray-600 dark:text-gray-400',
                                'icon' => 'fas fa-question',
                            ];
                        @endphp
                        <div class="{{ $color['bg'] }} p-3 rounded-full">
                            <i class="{{ $color['icon'] }} {{ $color['text'] }} text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ ucfirst($stat->status) }}
                            </h3>
                            <p class="text-3xl font-bold {{ $color['text'] }}">{{ $stat->total }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Dua Kolom Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Statistik per Kategori -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Aspirasi per Kategori</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $kategoriStats->sum('aspirasis_count') }}
                        total</span>
                </div>
                <div class="space-y-4">
                    @foreach ($kategoriStats as $kategori)
                        <div>
                            <div class="flex justify-between mb-1">
                                <span
                                    class="font-medium text-gray-700 dark:text-gray-300">{{ $kategori->nama_kategori }}</span>
                                <span
                                    class="font-bold text-gray-900 dark:text-white">{{ $kategori->aspirasis_count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                @php
                                    $percentage =
                                        $totalAspirasi > 0 ? ($kategori->aspirasis_count / $totalAspirasi) * 100 : 0;
                                @endphp
                                <div class="bg-blue-600 dark:bg-blue-500 h-2 rounded-full transition-all duration-500"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="text-right text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ number_format($percentage, 1) }}%
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Chart Bulanan (Simple) -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Trend Bulanan</h3>
                <div class="h-64 flex items-end space-x-2">
                    @foreach ($bulanStats as $stat)
                        @php
                            $bulanNama = [
                                'Jan',
                                'Feb',
                                'Mar',
                                'Apr',
                                'Mei',
                                'Jun',
                                'Jul',
                                'Agu',
                                'Sep',
                                'Okt',
                                'Nov',
                                'Des',
                            ];
                            $max = $bulanStats->max('total');
                            $tinggi = $max > 0 ? ($stat->total / $max) * 200 : 5;
                        @endphp
                        <div class="flex-1 flex flex-col items-center">
                            <div class="relative group">
                                <div class="bg-blue-500 dark:bg-blue-600 w-8 rounded-t-lg mb-2 transition-all duration-300 group-hover:bg-blue-600 dark:group-hover:bg-blue-500"
                                    style="height: {{ $tinggi }}px"></div>
                                <div
                                    class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-gray-700 text-white dark:text-gray-200 text-xs font-semibold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                    {{ $stat->total }} aspirasi
                                    <div
                                        class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1 w-0 h-0 border-l-4 border-r-4 border-t-4 border-l-transparent border-r-transparent border-t-gray-900 dark:border-t-gray-700">
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                {{ $bulanNama[$stat->bulan - 1] ?? $stat->bulan }}</div>
                            <div class="text-xs font-bold text-gray-900 dark:text-white">{{ $stat->total }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
                    Data per bulan ({{ $bulanStats->min('tahun') ?? date('Y') }})
                </div>
            </div>
        </div>

        <!-- Top Siswa -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Top 10 Siswa dengan Aspirasi Terbanyak</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                #</th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Nama Siswa</th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Email</th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Total Aspirasi</th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Menunggu</th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Diproses</th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Selesai</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($topSiswa as $index => $siswa)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        @if ($loop->first)
                                            <span
                                                class="w-8 h-8 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                                                <i class="fas fa-crown text-yellow-600 dark:text-yellow-400"></i>
                                            </span>
                                        @else
                                            <span
                                                class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                <span
                                                    class="font-medium text-gray-600 dark:text-gray-300">{{ $index + 1 }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4 font-medium text-gray-900 dark:text-white">{{ $siswa->name }}</td>
                                <td class="py-3 px-4 text-gray-600 dark:text-gray-400">{{ $siswa->email }}</td>
                                <td class="py-3 px-4">
                                    <span
                                        class="font-bold text-blue-600 dark:text-blue-400">{{ $siswa->aspirasis_count }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    {{ $siswa->aspirasis()->where('status', 'menunggu')->count() }}
                                </td>
                                <td class="py-3 px-4">
                                    {{ $siswa->aspirasis()->where('status', 'diproses')->count() }}
                                </td>
                                <td class="py-3 px-4">
                                    {{ $siswa->aspirasis()->where('status', 'selesai')->count() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Waktu Rata-rata Penyelesaian -->
        @if ($avgCompletion && $avgCompletion->avg_hours)
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mt-6">
                <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Analisis Waktu Penyelesaian</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                            {{ number_format($avgCompletion->avg_hours, 1) }}
                        </div>
                        <div class="text-gray-600 dark:text-gray-400 mt-2">Jam (Rata-rata)</div>
                        <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Waktu dari pengajuan hingga selesai</p>
                    </div>

                    @php
                        $avgDays = $avgCompletion->avg_hours / 24;
                        $fastThreshold = 24; // 1 hari
                        $mediumThreshold = 72; // 3 hari
                    @endphp

                    <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                            @if ($avgCompletion->avg_hours <= $fastThreshold)
                                <i class="fas fa-bolt"></i> Cepat
                            @elseif($avgCompletion->avg_hours <= $mediumThreshold)
                                <i class="fas fa-clock"></i> Sedang
                            @else
                                <i class="fas fa-hourglass-half"></i> Lambat
                            @endif
                        </div>
                        <div class="text-gray-600 dark:text-gray-400 mt-2">Kategori</div>
                        <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">
                            @if ($avgCompletion->avg_hours <= $fastThreshold)
                                Penyelesaian kurang dari 1 hari
                            @elseif($avgCompletion->avg_hours <= $mediumThreshold)
                                Penyelesaian 1-3 hari
                            @else
                                Penyelesaian lebih dari 3 hari
                            @endif
                        </p>
                    </div>

                    <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                            {{ number_format($avgDays, 1) }}
                        </div>
                        <div class="text-gray-600 dark:text-gray-400 mt-2">Hari (Rata-rata)</div>
                        <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Konversi ke hari</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Ekspor Data -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Ekspor Data</h3>
            <form action="{{ route('admin.export.data') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jenis Data</label>
                    <select name="type"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="aspirasi">Data Aspirasi</option>
                        <option value="users">Data Siswa</option>
                        <option value="progress">Data Progress</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Format Ekspor</label>
                    <select name="format"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="csv">CSV</option>
                        <option value="excel">Excel</option>
                        <option value="pdf">PDF</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg w-full transition-colors">
                        <i class="fas fa-download mr-2"></i> Ekspor Data
                    </button>
                </div>

                <!-- Filter Tambahan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dari Tanggal
                        (Opsional)</label>
                    <input type="date" name="start_date"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sampai Tanggal
                        (Opsional)</label>
                    <input type="date" name="end_date"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status
                        (Opsional)</label>
                    <select name="status"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </form>

            <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <p><i class="fas fa-info-circle text-blue-500 mr-2"></i> Data akan diekspor berdasarkan filter yang dipilih
                </p>
            </div>
        </div>

        <!-- Ringkasan -->
        <div class="mt-6 text-sm text-gray-500 dark:text-gray-400">
            <p><strong>Periode:</strong>
                @if ($startDate && $endDate)
                    {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}
                @else
                    Semua periode
                @endif
            </p>
            <p><strong>Waktu Generate:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>

    <style>
        .transition-all {
            transition: all 0.3s ease;
        }

        .group:hover .group-hover\:opacity-100 {
            opacity: 1;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit form when date range is complete
            const startDateInput = document.querySelector('form input[name="start_date"]');
            const endDateInput = document.querySelector('form input[name="end_date"]');

            if (startDateInput && endDateInput) {
                [startDateInput, endDateInput].forEach(input => {
                    input.addEventListener('change', function() {
                        if (startDateInput.value && endDateInput.value) {
                            // Add a small delay for better UX
                            setTimeout(() => {
                                this.form.submit();
                            }, 500);
                        }
                    });
                });
            }

            // Chart bar hover effects
            const chartBars = document.querySelectorAll('.relative.group');
            chartBars.forEach(bar => {
                bar.addEventListener('mouseenter', function() {
                    const tooltip = this.querySelector('.group-hover\\:opacity-100');
                    if (tooltip) {
                        tooltip.style.opacity = '1';
                    }
                });

                bar.addEventListener('mouseleave', function() {
                    const tooltip = this.querySelector('.group-hover\\:opacity-100');
                    if (tooltip) {
                        tooltip.style.opacity = '0';
                    }
                });
            });
        });
    </script>
@endsection
