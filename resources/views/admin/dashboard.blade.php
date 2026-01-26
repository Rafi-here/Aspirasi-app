@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-inbox text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Total Aspirasi</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalAspirasi }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Menunggu</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $aspirasiMenunggu }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-cogs text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Diproses</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $aspirasiDiproses }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Selesai</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $aspirasiSelesai }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dua Kolom Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Statistik per Kategori -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold mb-4">Aspirasi per Kategori</h3>
            <div class="space-y-4">
                @foreach ($kategoriStats as $kategori)
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="font-medium">{{ $kategori->nama_kategori }}</span>
                            <span class="font-bold">{{ $kategori->aspirasis_count }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full"
                                style="width: {{ $totalAspirasi > 0 ? ($kategori->aspirasis_count / $totalAspirasi) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Aspirasi Terbaru -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold mb-4">Aspirasi Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 text-left">Siswa</th>
                            <th class="py-2 text-left">Judul</th>
                            <th class="py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aspirasiTerbaru as $aspirasi)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3">
                                    <div class="font-medium">{{ $aspirasi->nama_siswa }}</div>
                                    <div class="text-sm text-gray-500">{{ $aspirasi->created_at->format('d/m H:i') }}</div>
                                </td>
                                <td class="py-3">
                                    <a href="{{ route('admin.aspirasi.show', $aspirasi) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ Str::limit($aspirasi->judul, 30) }}
                                    </a>
                                </td>
                                <td class="py-3">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-semibold bg-{{ $aspirasi->status_color }}-100 text-{{ $aspirasi->status_color }}-800">
                                        {{ ucfirst($aspirasi->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('admin.aspirasi.index') }}" class="text-blue-600 hover:underline">
                    Lihat semua aspirasi →
                </a>
            </div>
        </div>
    </div>
@endsection
