@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Statistik Card -->
        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-clock text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Menunggu</h3>
                    <p class="text-3xl font-bold text-blue-600">
                        {{ Auth::user()->aspirasis()->where('status', 'menunggu')->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
            <div class="flex items-center">
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-cogs text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Diproses</h3>
                    <p class="text-3xl font-bold text-yellow-600">
                        {{ Auth::user()->aspirasis()->where('status', 'diproses')->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-green-50 p-6 rounded-lg border border-green-200">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Selesai</h3>
                    <p class="text-3xl font-bold text-green-600">
                        {{ Auth::user()->aspirasis()->where('status', 'selesai')->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Aspirasi Terbaru -->
    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4">Aspirasi Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="py-3 px-4 border-b text-left">Judul</th>
                        <th class="py-3 px-4 border-b text-left">Kategori</th>
                        <th class="py-3 px-4 border-b text-left">Status</th>
                        <th class="py-3 px-4 border-b text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(Auth::user()->aspirasis()->latest()->take(5)->get() as $aspirasi)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 border-b">
                                <a href="{{ route('siswa.aspirasi.show', $aspirasi) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $aspirasi->judul }}
                                </a>
                            </td>
                            <td class="py-3 px-4 border-b">{{ $aspirasi->kategori->nama_kategori }}</td>
                            <td class="py-3 px-4 border-b">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-semibold bg-{{ $aspirasi->status_color }}-100 text-{{ $aspirasi->status_color }}-800">
                                    {{ ucfirst($aspirasi->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 border-b">{{ $aspirasi->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 px-4 text-center text-gray-500">
                                Belum ada aspirasi. <a href="{{ route('siswa.aspirasi.create') }}"
                                    class="text-blue-600 hover:underline">Buat aspirasi pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
