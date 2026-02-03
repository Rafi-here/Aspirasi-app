<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama (tetap sama)
        $totalAspirasi = Aspirasi::count();
        $aspirasiMenunggu = Aspirasi::where('status', 'menunggu')->count();
        $aspirasiDiproses = Aspirasi::where('status', 'diproses')->count();
        $aspirasiSelesai = Aspirasi::where('status', 'selesai')->count();
        $aspirasiDitolak = Aspirasi::where('status', 'ditolak')->count();

        // Statistik per kategori
        $kategoriStats = Kategori::withCount(['aspirasis' => function ($query) {
            $query->where('status', '!=', 'ditolak');
        }])->get();

        // Aspirasi terbaru
        $aspirasiTerbaru = Aspirasi::with(['user', 'kategori'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Statistik per bulan
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

        // Top siswa dengan aspirasi terbanyak
        $topSiswa = User::where('role', 'siswa')
            ->withCount(['aspirasis' => function ($query) {
                $query->where('status', '!=', 'ditolak');
            }])
            ->orderBy('aspirasis_count', 'desc')
            ->take(5)
            ->get();

        // Statistik per hari dalam 30 hari terakhir
        $hariStats = Aspirasi::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Data untuk today's overview
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $todayCount = Aspirasi::whereBetween('created_at', [$today, $tomorrow])->count();
        $todayCompleted = Aspirasi::whereBetween('updated_at', [$today, $tomorrow])
            ->where('status', 'selesai')->count();

        return view('admin.dashboard', compact(
            'totalAspirasi',
            'aspirasiMenunggu',
            'aspirasiDiproses',
            'aspirasiSelesai',
            'aspirasiDitolak',
            'kategoriStats',
            'aspirasiTerbaru',
            'bulanStats',
            'topSiswa',
            'hariStats',
            'todayCount',
            'todayCompleted'
        ));
    }

    public function statistik()
    {
        // Filter berdasarkan periode
        $periode = request('periode', 'bulan_ini');
        $startDate = null;
        $endDate = null;

        switch ($periode) {
            case 'minggu_ini':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'bulan_ini':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'tahun_ini':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            case 'semua':
                // Tidak ada filter tanggal
                break;
            default:
                // Custom date range
                if (request()->filled('start_date') && request()->filled('end_date')) {
                    $startDate = Carbon::parse(request('start_date'))->startOfDay();
                    $endDate = Carbon::parse(request('end_date'))->endOfDay();
                }
        }

        // Query dengan filter tanggal
        $query = Aspirasi::query();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Total aspirasi
        $totalAspirasi = $query->count();

        // Statistik per status
        $statusStats = $query->select(
            'status',
            DB::raw('COUNT(*) as total')
        )->groupBy('status')->get();

        // Statistik per kategori
        $kategoriStats = Kategori::withCount(['aspirasis' => function ($q) use ($startDate, $endDate) {
            if ($startDate && $endDate) {
                $q->whereBetween('aspirasis.created_at', [$startDate, $endDate]);
            }
        }])->get();

        // Statistik per bulan (untuk chart)
        $bulanStats = Aspirasi::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "selesai" THEN 1 ELSE 0 END) as selesai'),
            DB::raw('SUM(CASE WHEN status = "diproses" THEN 1 ELSE 0 END) as diproses'),
            DB::raw('SUM(CASE WHEN status = "menunggu" THEN 1 ELSE 0 END) as menunggu')
        )
            ->when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
                return $q->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Waktu rata-rata penyelesaian
        $avgCompletion = Aspirasi::where('status', 'selesai')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours'))
            ->first();

        // Top 10 siswa dengan aspirasi terbanyak
        $topSiswa = User::where('role', 'siswa')
            ->withCount(['aspirasis' => function ($q) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $q->whereBetween('aspirasis.created_at', [$startDate, $endDate]);
                }
            }])
            ->orderBy('aspirasis_count', 'desc')
            ->take(10)
            ->get();

        return view('admin.statistik.index', compact(
            'totalAspirasi',
            'statusStats',
            'kategoriStats',
            'bulanStats',
            'avgCompletion',
            'topSiswa',
            'periode',
            'startDate',
            'endDate'
        ));
    }

    public function exportData(Request $request)
    {
        $format = $request->format ?? 'csv';
        $type = $request->type ?? 'aspirasi';

        // Filter berdasarkan tanggal
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : null;
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : null;

        if ($type == 'aspirasi') {
            $data = Aspirasi::with(['user', 'kategori'])
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    return $query->whereBetween('created_at', [$startDate, $endDate]);
                })
                ->when($request->status, function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->when($request->kategori_id, function ($query, $kategoriId) {
                    return $query->where('kategori_id', $kategoriId);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return $this->exportAspirasi($data, $format);
        } elseif ($type == 'users') {
            $data = User::where('role', 'siswa')
                ->withCount('aspirasis')
                ->orderBy('name')
                ->get();

            return $this->exportUsers($data, $format);
        } elseif ($type == 'progress') {
            $data = DB::table('progress')
                ->join('aspirasis', 'progress.aspirasi_id', '=', 'aspirasis.id')
                ->join('users', 'progress.user_id', '=', 'users.id')
                ->select(
                    'progress.id',
                    'aspirasis.judul',
                    'users.name as admin',
                    'progress.deskripsi',
                    'progress.tipe',
                    'progress.created_at'
                )
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    return $query->whereBetween('progress.created_at', [$startDate, $endDate]);
                })
                ->orderBy('progress.created_at', 'desc')
                ->get();

            return $this->exportProgress($data, $format);
        }

        return redirect()->back()->with('error', 'Tipe ekspor tidak valid.');
    }

    private function exportAspirasi($data, $format)
    {
        $headers = [
            'ID',
            'Judul',
            'Siswa',
            'Email',
            'Kategori',
            'Status',
            'Deskripsi',
            'Lokasi',
            'Anonim',
            'Tanggal Dibuat',
            'Tanggal Diupdate'
        ];

        $rows = [];
        foreach ($data as $aspirasi) {
            $rows[] = [
                $aspirasi->id,
                $aspirasi->judul,
                $aspirasi->nama_siswa,
                $aspirasi->user->email ?? '-',
                $aspirasi->kategori->nama_kategori,
                ucfirst($aspirasi->status),
                strip_tags($aspirasi->deskripsi),
                $aspirasi->lokasi ?? '-',
                $aspirasi->is_anonim ? 'Ya' : 'Tidak',
                $aspirasi->created_at->format('Y-m-d H:i:s'),
                $aspirasi->updated_at->format('Y-m-d H:i:s')
            ];
        }

        return $this->generateExport($rows, $headers, 'aspirasi', $format);
    }

    private function exportUsers($data, $format)
    {
        $headers = ['ID', 'Nama', 'Email', 'Total Aspirasi', 'Tanggal Registrasi'];

        $rows = [];
        foreach ($data as $user) {
            $rows[] = [
                $user->id,
                $user->name,
                $user->email,
                $user->aspirasis_count,
                $user->created_at->format('Y-m-d H:i:s')
            ];
        }

        return $this->generateExport($rows, $headers, 'siswa', $format);
    }

    private function exportProgress($data, $format)
    {
        $headers = ['ID', 'Judul Aspirasi', 'Admin', 'Deskripsi Progress', 'Tipe', 'Tanggal'];

        $rows = [];
        foreach ($data as $progress) {
            $rows[] = [
                $progress->id,
                $progress->judul,
                $progress->admin,
                $progress->deskripsi,
                ucfirst($progress->tipe),
                $progress->created_at
            ];
        }

        return $this->generateExport($rows, $headers, 'progress', $format);
    }

    private function generateExport($data, $headers, $filename, $format)
    {
        if ($format == 'csv') {
            return $this->exportToCSV($data, $headers, $filename);
        } elseif ($format == 'excel') {
            return $this->exportToExcel($data, $headers, $filename);
        } elseif ($format == 'pdf') {
            return $this->exportToPDF($data, $headers, $filename);
        }

        return $this->exportToCSV($data, $headers, $filename);
    }

    private function exportToCSV($data, $headers, $filename)
    {
        $filename = $filename . '_' . date('Y-m-d_H-i-s') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, $headers);

        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }

    private function exportToExcel($data, $headers, $filename)
    {
        // Untuk Excel, kita butuh package tambahan
        // Untuk sementara, kita kembalikan CSV dengan extension .xls
        $filename = $filename . '_' . date('Y-m-d_H-i-s') . '.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        echo '<table border="1">';
        echo '<tr>';
        foreach ($headers as $header) {
            echo '<th>' . $header . '</th>';
        }
        echo '</tr>';

        foreach ($data as $row) {
            echo '<tr>';
            foreach ($row as $cell) {
                echo '<td>' . htmlspecialchars($cell) . '</td>';
            }
            echo '</tr>';
        }

        echo '</table>';
        exit;
    }

    private function exportToPDF($data, $headers, $filename)
    {
        // Untuk PDF, kita butuh package tambahan
        // Untuk sementara, kita kembalikan HTML dengan header PDF
        $filename = $filename . '_' . date('Y-m-d_H-i-s') . '.pdf';

        $html = '<html><head><style>
                body { font-family: Arial, sans-serif; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                h1 { color: #333; }
                .header { text-align: center; margin-bottom: 20px; }
            </style></head><body>';

        $html .= '<div class="header">
                    <h1>Laporan ' . ucfirst($filename) . '</h1>
                    <p>Tanggal Export: ' . date('d/m/Y H:i:s') . '</p>
                  </div>';

        $html .= '<table>';
        $html .= '<tr>';
        foreach ($headers as $header) {
            $html .= '<th>' . $header . '</th>';
        }
        $html .= '</tr>';

        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>' . htmlspecialchars($cell) . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</table>';
        $html .= '</body></html>';

        // Header untuk PDF (simulasi)
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Untuk produksi sebenarnya, gunakan package seperti DomPDF atau TCPDF
        echo $html;
        exit;
    }
}
