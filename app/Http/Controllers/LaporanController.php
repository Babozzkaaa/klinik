<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\KunjunganTindakan;
use App\Models\KunjunganObat;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kunjunganPerHari = Kunjungan::selectRaw('DATE(tanggal_kunjungan) as tanggal, COUNT(*) as jumlah')
            ->where('tanggal_kunjungan', '>=', now()->subDays(30))
            ->groupBy(DB::raw('DATE(tanggal_kunjungan)'))
            ->orderBy('tanggal', 'asc')
            ->get();

        $kunjunganPerBulan = Kunjungan::selectRaw("TO_CHAR(tanggal_kunjungan, 'YYYY-MM') as bulan, COUNT(*) as jumlah")
            ->where('tanggal_kunjungan', '>=', now()->subMonths(12))
            ->groupBy(DB::raw("TO_CHAR(tanggal_kunjungan, 'YYYY-MM')"))
            ->orderBy('bulan', 'asc')
            ->get();

        $tindakanTerbanyak = KunjunganTindakan::select('tindakan_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('tindakan_id')
            ->orderByDesc('total')
            ->with('tindakan')
            ->limit(10)
            ->get();

        $obatTerbanyak = KunjunganObat::select('obat_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('obat_id')
            ->orderByDesc('total')
            ->with('obat')
            ->limit(10)
            ->get();

        return view('laporan.index', compact('kunjunganPerHari', 'kunjunganPerBulan', 'tindakanTerbanyak', 'obatTerbanyak'));
    }
}
