<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AspirasiController extends Controller
{
    // Menampilkan daftar aspirasi siswa
    public function index(Request $request)
    {
        $query = Aspirasi::where('user_id', Auth::id())
            ->with(['kategori', 'progress', 'umpanBaliks']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $aspirasis = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('siswa.aspirasi.index', compact('aspirasis'));
    }
    // Menampilkan form buat aspirasi baru
    public function create()
    {
        $kategoris = Kategori::all();
        return view('siswa.aspirasi.create', compact('kategoris'));
    }

    // Menyimpan aspirasi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'required|string',
            'is_anonim' => 'boolean',
            'lokasi' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'menunggu';
        $validated['is_anonim'] = $request->has('is_anonim');

        Aspirasi::create($validated);

        return redirect()->route('siswa.aspirasi.index')
            ->with('success', 'Aspirasi berhasil dikirim!');
    }

    // Menampilkan detail aspirasi
    public function show(Aspirasi $aspirasi)
    {
        // Pastikan hanya pemilik yang bisa melihat
        if ($aspirasi->user_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke aspirasi ini.');
        }

        $aspirasi->load(['kategori', 'progress.user', 'umpanBaliks.user']);

        return view('siswa.aspirasi.show', compact('aspirasi'));
    }
}
