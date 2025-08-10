<?php

namespace App\Http\Controllers;

use App\Models\KunjunganTindakan;
use App\Models\Kunjungan;
use App\Models\Tindakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KunjunganTindakanController extends Controller
{
    public function index(Request $request)
    {
        $query = KunjunganTindakan::with(['kunjungan.pasien', 'tindakan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('kunjungan.pasien', function($pasienQuery) use ($search) {
                    $pasienQuery->where('nama', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('tindakan', function($tindakanQuery) use ($search) {
                    $tindakanQuery->where('nama', 'LIKE', "%{$search}%");
                })
                ->orWhere('catatan', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('kunjungan_id')) {
            $query->where('kunjungan_id', $request->kunjungan_id);
        }

        if ($request->filled('tindakan_id')) {
            $query->where('tindakan_id', $request->tindakan_id);
        }

        $sortBy = $request->get('sort_field', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $kunjunganTindakans = $query->paginate(10)->withQueryString();

        $kunjungans = Kunjungan::with('pasien')->orderBy('tanggal_kunjungan', 'desc')->limit(100)->get();
        $tindakans = Tindakan::orderBy('nama')->get();

        return view('kunjungan-tindakan.index', compact('kunjunganTindakans', 'kunjungans', 'tindakans'));
    }

    public function create()
    {
        $kunjungans = Kunjungan::with('pasien')
            ->whereDoesntHave('pembayaran', function($q) {
                $q->where('status', 'selesai');
            })
            ->orderBy('tanggal_kunjungan', 'desc')
            ->limit(100)
            ->get();
        $tindakans = Tindakan::orderBy('nama')->get();
        
        return view('kunjungan-tindakan.create', compact('kunjungans', 'tindakans'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'tindakan_id' => 'required|exists:tindakans,id',
            'jumlah' => 'required|integer|min:1',
            'tarif' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $validator->validated();
        $data['subtotal'] = $data['jumlah'] * $data['tarif'];
        KunjunganTindakan::create($data);
        return redirect()->route('kunjungan-tindakan.index')
            ->with('success', 'Tindakan kunjungan berhasil ditambahkan.');
    }

    public function show(KunjunganTindakan $kunjunganTindakan)
    {
        $kunjunganTindakan->load(['kunjungan.pasien', 'tindakan']);
        return view('kunjungan-tindakan.show', compact('kunjunganTindakan'));
    }

    public function edit(KunjunganTindakan $kunjunganTindakan)
    {
        $kunjungans = Kunjungan::with('pasien')->orderBy('tanggal_kunjungan', 'desc')->limit(100)->get();
        $tindakans = Tindakan::orderBy('nama')->get();
        
        return view('kunjungan-tindakan.edit', compact('kunjunganTindakan', 'kunjungans', 'tindakans'));
    }

    public function update(Request $request, KunjunganTindakan $kunjunganTindakan)
    {
        $validator = Validator::make($request->all(), [
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'tindakan_id' => 'required|exists:tindakans,id',
            'jumlah' => 'required|integer|min:1',
            'tarif' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $validator->validated();
        $data['subtotal'] = $data['jumlah'] * $data['tarif'];
        $kunjunganTindakan->update($data);
        return redirect()->route('kunjungan-tindakan.index')
            ->with('success', 'Tindakan kunjungan berhasil diperbarui.');
    }

    public function destroy(KunjunganTindakan $kunjunganTindakan)
    {
        $kunjunganTindakan->delete();

        return redirect()->route('kunjungan-tindakan.index')
            ->with('success', 'Tindakan kunjungan berhasil dihapus.');
    }

    public function getTindakanTarif(Tindakan $tindakan)
    {
        return response()->json([
            'tarif' => $tindakan->tarif
        ]);
    }
}
