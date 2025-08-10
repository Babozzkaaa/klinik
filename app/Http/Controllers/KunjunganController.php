<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        $query = Kunjungan::with(['pasien', 'dokter', 'pendaftar']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('pasien', function($pasienQuery) use ($search) {
                    $pasienQuery->where('nama', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('dokter', function($dokterQuery) use ($search) {
                    $dokterQuery->where('nama', 'LIKE', "%{$search}%");
                })
                ->orWhere('keluhan', 'LIKE', "%{$search}%")
                ->orWhere('diagnosa', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('jenis_kunjungan')) {
            $query->where('jenis_kunjungan', $request->jenis_kunjungan);
        }

        if ($request->filled('dokter_id')) {
            $query->where('dokter_id', $request->dokter_id);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_kunjungan', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_kunjungan', '<=', $request->tanggal_sampai);
        }

        $sortBy = $request->get('sort_field', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $kunjungans = $query->paginate(10)->withQueryString();

        $dokters = Pegawai::orderBy('nama')->get();

        return view('kunjungan.index', compact('kunjungans', 'dokters'));
    }

    public function create()
    {
        $pasiens = Pasien::orderBy('nama')->get();
        $dokters = Pegawai::where('jabatan', 'Dokter')->get();
        
        return view('kunjungan.create', compact('pasiens', 'dokters'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:pegawais,id',
            'tanggal_kunjungan' => 'required|date',
            'jenis_kunjungan' => 'required|in:umum,rujukan,kontrol,rutin,vaksinasi,darurat',
            'keluhan' => 'nullable|string',
            'diagnosa' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $data['didaftarkan_oleh'] = auth()->id();
        Kunjungan::create($data);
        return redirect()->route('kunjungan.index')
            ->with('success', 'Kunjungan berhasil ditambahkan.');
    }

    public function show(Kunjungan $kunjungan)
    {
        $kunjungan->load(['pasien', 'dokter', 'pendaftar']);
        return view('kunjungan.show', compact('kunjungan'));
    }

    public function edit(Kunjungan $kunjungan)
    {
        $pasiens = Pasien::orderBy('nama')->get();
        $dokters = Pegawai::orderBy('nama')->get();
        
        return view('kunjungan.edit', compact('kunjungan', 'pasiens', 'dokters'));
    }

    public function update(Request $request, Kunjungan $kunjungan)
    {
        $validator = Validator::make($request->all(), [
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:pegawais,id',
            'tanggal_kunjungan' => 'required|date',
            'jenis_kunjungan' => 'required|in:umum,rujukan,kontrol,rutin,vaksinasi,darurat',
            'keluhan' => 'nullable|string',
            'diagnosa' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $kunjungan->update($validator->validated());
        return redirect()->route('kunjungan.index')
            ->with('success', 'Kunjungan berhasil diperbarui.');
    }

    public function destroy(Kunjungan $kunjungan)
    {
        $kunjungan->delete();

        return redirect()->route('kunjungan.index')
            ->with('success', 'Kunjungan berhasil dihapus.');
    }
}
