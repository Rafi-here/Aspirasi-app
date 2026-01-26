@extends('layouts.admin')

@section('title', 'Detail Aspirasi')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header Info -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <div class="flex justify-between items-start mb-6">
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
                    <div class="text-sm text-gray-500 mt-1">{{ $aspirasi->user->email }}</div>
                </div>
            </div>

            <!-- Info Siswa -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-700 mb-2">Informasi Siswa</h4>
                    <div class="space-y-2">
                        <div class="flex">
                            <span class="w-32 text-gray-600">Nama:</span>
                            <span class="font-medium">{{ $aspirasi->nama_siswa }}</span>
                            @if ($aspirasi->is_anonim)
                                <span class="ml-2 text-xs bg-gray-200 px-2 py-1 rounded">Anonim</span>
                            @endif
                        </div>
                        <div class="flex">
                            <span class="w-32 text-gray-600">Email:</span>
                            <span>{{ $aspirasi->user->email }}</span>
                        </div>
                    </div>
                </div>

                <!-- Update Status Form -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-700 mb-2">Update Status</h4>
                    <form action="{{ route('admin.aspirasi.updateStatus', $aspirasi) }}" method="POST"
                        class="flex items-end">
                        @csrf
                        @method('PUT')
                        <div class="flex-1 mr-2">
                            <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                @foreach ($statusOptions as $status)
                                    <option value="{{ $status }}"
                                        {{ $aspirasi->status == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Update
                        </button>
                    </form>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-700 mb-2">Deskripsi Aspirasi</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    {!! nl2br(e($aspirasi->deskripsi)) !!}
                </div>
            </div>

            @if ($aspirasi->lokasi)
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-700 mb-2">Lokasi</h4>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        {{ $aspirasi->lokasi }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Dua Kolom: Progress dan Feedback -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Kolom Kiri: Progress dan Tambah Progress -->
            <div class="space-y-6">
                <!-- Progress Timeline -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-bold mb-4">Progress Penanganan</h3>

                    <!-- Form Tambah Progress -->
                    <form action="{{ route('admin.aspirasi.addProgress', $aspirasi) }}" method="POST" class="mb-6">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tambah Progress</label>
                            <textarea name="deskripsi" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2"
                                placeholder="Deskripsi progress penanganan..." required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe</label>
                            <select name="tipe" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                <option value="update">Update Status</option>
                                <option value="penanganan">Penanganan</option>
                                <option value="selesai">Penyelesaian</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                            <i class="fas fa-plus mr-2"></i> Tambah Progress
                        </button>
                    </form>

                    <!-- List Progress -->
                    @if ($aspirasi->progress->count() > 0)
                        <div class="space-y-4">
                            @foreach ($aspirasi->progress as $progress)
                                <div class="border-l-4 border-blue-500 pl-4 pb-4 relative">
                                    <div class="absolute -left-2 top-0 w-4 h-4 bg-blue-500 rounded-full"></div>
                                    <div class="flex justify-between">
                                        <h4 class="font-semibold">
                                            @if ($progress->tipe == 'update')
                                                <i class="fas fa-sync-alt text-blue-500 mr-2"></i>Update Status
                                            @elseif($progress->tipe == 'penanganan')
                                                <i class="fas fa-tools text-green-500 mr-2"></i>Penanganan
                                            @else
                                                <i class="fas fa-flag-checkered text-purple-500 mr-2"></i>Penyelesaian
                                            @endif
                                        </h4>
                                        <span class="text-sm text-gray-500">{{ $progress->waktu_format }}</span>
                                    </div>
                                    <div class="mt-2 text-gray-700">{{ $progress->deskripsi }}</div>
                                    <div class="mt-2 text-sm text-gray-500">
                                        Oleh: {{ $progress->user->name ?? 'System' }}
                                    </div>
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
            </div>

            <!-- Kolom Kanan: Feedback -->
            <div class="space-y-6">
                <!-- Form Umpan Balik -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-bold mb-4">Kirim Umpan Balik</h3>
                    <form action="{{ route('admin.aspirasi.addFeedback', $aspirasi) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <textarea name="pesan" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2"
                                placeholder="Tulis umpan balik untuk siswa..." required></textarea>
                        </div>
                        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Umpan Balik
                        </button>
                    </form>
                </div>

                <!-- List Umpan Balik -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-bold mb-4">Umpan Balik Terkirim</h3>

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
                            <p>Belum ada umpan balik</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
