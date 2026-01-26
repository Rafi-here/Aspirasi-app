<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Progress;
use App\Models\UmpanBalik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AspirasiController extends Controller
{
    // Menampilkan daftar aspirasi dengan filter
    public function index(Request $request)
    {
        $query = Aspirasi::with(['user', 'kategori']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', date('m', strtotime($request->bulan)))
                ->whereYear('created_at', date('Y', strtotime($request->bulan)));
        }

        // Filter berdasarkan siswa
        if ($request->filled('siswa')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->siswa . '%');
            });
        }

        // Urutkan
        $query->orderBy('created_at', 'desc');

        $aspirasis = $query->paginate(20);
        $kategoris = Kategori::all();

        return view('admin.aspirasi.index', compact('aspirasis', 'kategoris'));
    }

    // Menampilkan detail aspirasi
    public function show(Aspirasi $aspirasi)
    {
        $aspirasi->load(['user', 'kategori', 'progress.user', 'umpanBaliks.user']);
        $statusOptions = ['menunggu', 'diproses', 'selesai', 'ditolak'];

        return view('admin.aspirasi.show', compact('aspirasi', 'statusOptions'));
    }

    // Update status aspirasi
    public function updateStatus(Request $request, Aspirasi $aspirasi)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
        ]);

        $oldStatus = $aspirasi->status;
        $aspirasi->update(['status' => $request->status]);

        // Catat progress otomatis jika status berubah
        if ($oldStatus != $request->status) {
            $deskripsi = "Status berubah dari " . ucfirst($oldStatus) . " menjadi " . ucfirst($request->status);

            Progress::create([
                'aspirasi_id' => $aspirasi->id,
                'user_id' => Auth::id(),
                'deskripsi' => $deskripsi,
                'tipe' => 'update'
            ]);
        }

        return back()->with('success', 'Status aspirasi berhasil diperbarui.');
    }

    // Tambah progress
    public function addProgress(Request $request, Aspirasi $aspirasi)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'tipe' => 'required|in:update,penanganan,selesai',
        ]);

        Progress::create([
            'aspirasi_id' => $aspirasi->id,
            'user_id' => Auth::id(),
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe
        ]);

        return back()->with('success', 'Progress berhasil ditambahkan.');
    }

    // Tambah umpan balik
    public function addFeedback(Request $request, Aspirasi $aspirasi)
    {
        $request->validate([
            'pesan' => 'required|string',
        ]);

        UmpanBalik::create([
            'aspirasi_id' => $aspirasi->id,
            'user_id' => Auth::id(),
            'pesan' => $request->pesan
        ]);

        return back()->with('success', 'Umpan balik berhasil dikirim.');
    }
}
