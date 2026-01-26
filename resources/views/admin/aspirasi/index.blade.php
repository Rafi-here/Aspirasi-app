@extends('layouts.admin')

@section('title', 'Kelola Aspirasi')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold">Kelola Aspirasi</h3>
        <span class="text-gray-600">{{ $aspirasis->total() }} aspirasi ditemukan</span>
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <form action="{{ route('admin.aspirasi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Filter Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Filter Kategori -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="kategori" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Tanggal -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>

            <!-- Filter Siswa -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Siswa</label>
                <input type="text" name="siswa" value="{{ request('siswa') }}" placeholder="Nama siswa..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>

            <!-- Button Filter -->
            <div class="md:col-span-4">
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.aspirasi.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Reset
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Aspirasi -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Siswa</th>
                    <th class="py-3 px-4 text-left">Judul</th>
                    <th class="py-3 px-4 text-left">Kategori</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Tanggal</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($aspirasis as $aspirasi)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">#{{ str_pad($aspirasi->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-3 px-4">
                            <div class="font-medium">{{ $aspirasi->nama_siswa }}</div>
                            <div class="text-sm text-gray-500">{{ $aspirasi->user->email ?? '-' }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-medium">{{ Str::limit($aspirasi->judul, 40) }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($aspirasi->deskripsi, 50) }}</div>
                        </td>
                        <td class="py-3 px-4">{{ $aspirasi->kategori->nama_kategori }}</td>
                        <td class="py-3 px-4">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-semibold bg-{{ $aspirasi->status_color }}-100 text-{{ $aspirasi->status_color }}-800">
                                {{ ucfirst($aspirasi->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ $aspirasi->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.aspirasi.show', $aspirasi) }}"
                                class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-2"></i>
                            <p>Tidak ada aspirasi ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $aspirasis->links() }}
        </div>
    </div>
@endsection
