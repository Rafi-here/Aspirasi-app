<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalAspirasi = Aspirasi::count();
        $aspirasiMenunggu = Aspirasi::where('status', 'menunggu')->count();
        $aspirasiDiproses = Aspirasi::where('status', 'diproses')->count();
        $aspirasiSelesai = Aspirasi::where('status', 'selesai')->count();

        // Statistik per kategori
        $kategoriStats = Kategori::withCount(['aspirasis' => function ($query) {
            $query->where('status', '!=', 'ditolak');
        }])->get();

        // Aspirasi terbaru
        $aspirasiTerbaru = Aspirasi::with(['user', 'kategori'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Statistik per bulan (untuk chart)
        $bulanStats = Aspirasi::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        return view('admin.dashboard', compact(
            'totalAspirasi',
            'aspirasiMenunggu',
            'aspirasiDiproses',
            'aspirasiSelesai',
            'kategoriStats',
            'aspirasiTerbaru',
            'bulanStats'
        ));
    }
}
