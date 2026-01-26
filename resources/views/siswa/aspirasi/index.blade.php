@extends('layouts.siswa')

@section('title', 'Daftar Aspirasi')
@section('breadcrumb')
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('siswa.dashboard') }}" class="text-blue-600 hover:text-blue-700">Dashboard</a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">Aspirasi Saya</span>
                </div>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold">Semua Aspirasi</h3>
        <a href="{{ route('siswa.aspirasi.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-plus mr-2"></i> Aspirasi Baru
        </a>
    </div>

    <!-- Filter Status -->
    <div class="mb-6">
        <div class="flex space-x-2">
            <a href="{{ route('siswa.aspirasi.index') }}"
                class="px-4 py-2 rounded-lg {{ request('status') ? 'bg-gray-200' : 'bg-blue-600 text-white' }}">
                Semua
            </a>
            <a href="{{ route('siswa.aspirasi.index', ['status' => 'menunggu']) }}"
                class="px-4 py-2 rounded-lg {{ request('status') == 'menunggu' ? 'bg-yellow-600 text-white' : 'bg-gray-200' }}">
                Menunggu
            </a>
            <a href="{{ route('siswa.aspirasi.index', ['status' => 'diproses']) }}"
                class="px-4 py-2 rounded-lg {{ request('status') == 'diproses' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Diproses
            </a>
            <a href="{{ route('siswa.aspirasi.index', ['status' => 'selesai']) }}"
                class="px-4 py-2 rounded-lg {{ request('status') == 'selesai' ? 'bg-green-600 text-white' : 'bg-gray-200' }}">
                Selesai
            </a>
        </div>
    </div>

    <!-- Tabel Aspirasi -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-50">
                    <th class="py-3 px-4 border-b text-left">Judul</th>
                    <th class="py-3 px-4 border-b text-left">Kategori</th>
                    <th class="py-3 px-4 border-b text-left">Status</th>
                    <th class="py-3 px-4 border-b text-left">Tanggal</th>
                    <th class="py-3 px-4 border-b text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aspirasis as $aspirasi)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 border-b">
                            <div class="font-medium">{{ $aspirasi->judul }}</div>
                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($aspirasi->deskripsi, 50) }}
                            </div>
                        </td>
                        <td class="py-3 px-4 border-b">{{ $aspirasi->kategori->nama_kategori }}</td>
                        <td class="py-3 px-4 border-b">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-semibold bg-{{ $aspirasi->status_color }}-100 text-{{ $aspirasi->status_color }}-800">
                                {{ ucfirst($aspirasi->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 border-b">{{ $aspirasi->created_at->format('d/m/Y') }}</td>
                        <td class="py-3 px-4 border-b">
                            <a href="{{ route('siswa.aspirasi.show', $aspirasi) }}"
                                class="text-blue-600 hover:text-blue-800 mr-3">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">
                            Belum ada aspirasi. <a href="{{ route('siswa.aspirasi.create') }}"
                                class="text-blue-600 hover:underline">Buat aspirasi pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $aspirasis->links() }}
    </div>
@endsection
