@extends('layouts.admin')

@section('title', 'Kelola Aspirasi')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Kelola Aspirasi</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $aspirasis->total() }} aspirasi ditemukan</p>
            </div>
            <a href="{{ route('admin.export.data') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                <i class="fas fa-download"></i>
                <span class="hidden sm:inline">Ekspor Data</span>
            </a>
        </div>

        <!-- Filter Form -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mb-6">
            <form action="{{ route('admin.aspirasi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Filter Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Filter Kategori -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                    <select name="kategori"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Filter Siswa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Siswa</label>
                    <input type="text" name="siswa" value="{{ request('siswa') }}" placeholder="Nama siswa..."
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Actions -->
                <div class="flex items-end gap-2">
                    <a href="{{ route('admin.aspirasi.index') }}"
                        class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-center">
                        Reset
                    </a>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Aspirasi -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                ID
                            </th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Siswa
                            </th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Judul
                            </th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($aspirasis as $aspirasi)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="py-3 px-4">
                                    <div class="text-sm font-mono text-gray-900 dark:text-white">
                                        #{{ str_pad($aspirasi->id, 6, '0', STR_PAD_LEFT) }}
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $aspirasi->nama_siswa }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $aspirasi->user->email ?? '-' }}</div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ Str::limit($aspirasi->judul, 40) }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ Str::limit($aspirasi->deskripsi, 50) }}</div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                                        {{ $aspirasi->kategori->nama_kategori }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-semibold bg-{{ $aspirasi->status_color }}-100 dark:bg-{{ $aspirasi->status_color }}-900/30 text-{{ $aspirasi->status_color }}-800 dark:text-{{ $aspirasi->status_color }}-400">
                                        {{ ucfirst($aspirasi->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $aspirasi->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $aspirasi->created_at->format('H:i') }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.aspirasi.show', $aspirasi) }}"
                                        class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                        <span>Detail</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                        <i class="fas fa-inbox text-3xl mb-2"></i>
                                        <p class="text-lg font-medium">Tidak ada aspirasi ditemukan</p>
                                        <p class="text-sm mt-1">Coba ubah filter pencarian Anda</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-gray-700 dark:text-gray-400 mb-2 sm:mb-0">
                        Menampilkan
                        <span class="font-medium">{{ $aspirasis->firstItem() ?? 0 }}</span>
                        sampai
                        <span class="font-medium">{{ $aspirasis->lastItem() ?? 0 }}</span>
                        dari
                        <span class="font-medium">{{ $aspirasis->total() }}</span>
                        hasil
                    </div>
                    <div>
                        {{ $aspirasis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom pagination styles for dark mode */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }

        .page-link {
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #3b82f6;
            background-color: white;
            border: 1px solid #e5e7eb;
        }

        .page-link:hover {
            background-color: #f3f4f6;
            border-color: #d1d5db;
        }

        .dark .page-link {
            background-color: #374151;
            border-color: #4b5563;
            color: #d1d5db;
        }

        .dark .page-link:hover {
            background-color: #4b5563;
            border-color: #6b7280;
        }

        .dark .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }

        /* Transitions */
        .transition-colors {
            transition-property: background-color, border-color, color;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }
    </style>
@endsection
