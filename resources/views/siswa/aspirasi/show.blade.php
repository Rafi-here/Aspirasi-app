@extends('layouts.siswa')

@section('title', 'Detail Aspirasi')
@section('breadcrumb')
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('siswa.dashboard') }}" class="text-blue-600 hover:text-blue-700">Dashboard</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('siswa.aspirasi.index') }}" class="text-blue-600 hover:text-blue-700">Aspirasi</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">Detail</span>
                </div>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header Info -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $aspirasi->judul }}</h2>
                    <div class="flex items-center mt-2 space-x-4">
                        <span
                            class="px-3 py-1 rounded-full text-sm font-semibold bg-{{ $aspirasi->status_color }}-100 text-{{ $aspirasi->status_color }}-800">
                            {{ ucfirst($aspirasi->status) }}
                        </span>
                        <span class="text-gray-600">
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ $aspirasi->created_at->format('d F Y, H:i') }}
                        </span>
                        <span class="text-gray-600">
                            <i class="fas fa-tag mr-1"></i>
                            {{ $aspirasi->kategori->nama_kategori }}
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-gray-600">ID: #{{ str_pad($aspirasi->id, 6, '0', STR_PAD_LEFT) }}</div>
                    <div class="text-sm text-gray-500 mt-1">{{ $aspirasi->nama_siswa }}</div>
                </div>
            </div>

            <div class="mt-6">
                <h4 class="font-semibold text-gray-700 mb-2">Deskripsi</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    {!! nl2br(e($aspirasi->deskripsi)) !!}
                </div>
            </div>

            @if ($aspirasi->lokasi)
                <div class="mt-4">
                    <h4 class="font-semibold text-gray-700 mb-2">Lokasi</h4>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        {{ $aspirasi->lokasi }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Progress Timeline -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h3 class="text-xl font-bold mb-4">Progress Penanganan</h3>

            @if ($aspirasi->progress->count() > 0)
                <div class="space-y-4">
                    @foreach ($aspirasi->progress as $progress)
                        <div class="border-l-4 border-blue-500 pl-4 pb-4 relative">
                            <div class="absolute -left-2 top-0 w-4 h-4 bg-blue-500 rounded-full"></div>
                            <div class="flex justify-between">
                                <h4 class="font-semibold">
                                    @if ($progress->tipe == 'update')
                                        <i class="fas fa-sync-alt text-blue-500 mr-2"></i>Update Progress
                                    @elseif($progress->tipe == 'penanganan')
                                        <i class="fas fa-tools text-green-500 mr-2"></i>Penanganan
                                    @else
                                        <i class="fas fa-flag-checkered text-purple-500 mr-2"></i>Penyelesaian
                                    @endif
                                </h4>
                                <span class="text-sm text-gray-500">{{ $progress->waktu_format }}</span>
                            </div>
                            <div class="mt-2 text-gray-700">{{ $progress->deskripsi }}</div>
                            @if ($progress->user)
                                <div class="mt-2 text-sm text-gray-500">
                                    Oleh: {{ $progress->user->name }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-clock text-4xl mb-3"></i>
                    <p>Belum ada progress penanganan</p>
                </div>
            @endif
        </div>

        <!-- Umpan Balik Admin -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold mb-4">Umpan Balik dari Admin</h3>

            @if ($aspirasi->umpanBaliks->count() > 0)
                <div class="space-y-4">
                    @foreach ($aspirasi->umpanBaliks as $feedback)
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex justify-between mb-2">
                                <div class="font-semibold flex items-center">
                                    <i class="fas fa-comment-dots text-yellow-500 mr-2"></i>
                                    Umpan Balik
                                </div>
                                <span class="text-sm text-gray-500">{{ $feedback->waktu_format }}</span>
                            </div>
                            <div class="text-gray-700">{{ $feedback->pesan }}</div>
                            <div class="mt-2 text-sm text-gray-500">
                                Dari: {{ $feedback->user->name }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="far fa-comments text-4xl mb-3"></i>
                    <p>Belum ada umpan balik dari admin</p>
                </div>
            @endif
        </div>
    </div>
@endsection
