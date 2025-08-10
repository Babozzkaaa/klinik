<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        try {
            $totalPasien = Pasien::count();
            $totalDokter = Pegawai::whereRaw('LOWER(jabatan) = ?', ['dokter'])->count();
            $totalObat = Obat::count();
            $kunjunganHariIni = Kunjungan::whereDate('tanggal_kunjungan', now()->toDateString())->count();

            return view('admin.dashboard', [
                'totalPasien' => $totalPasien,
                'totalDokter' => $totalDokter,
                'totalObat' => $totalObat,
                'kunjunganHariIni' => $kunjunganHariIni,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in AdminController@index: ' . $e->getMessage());
            return response('Error: ' . $e->getMessage(), 500);
        }
    }
}
