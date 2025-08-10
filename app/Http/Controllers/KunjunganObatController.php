<?php

namespace App\Http\Controllers;

use App\Models\KunjunganObat;
use App\Models\Kunjungan;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KunjunganObatController extends Controller
{
    public function index(Request $request)
    {
        $query = KunjunganObat::with(['kunjungan.pasien', 'obat']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('kunjungan.pasien', function($pasienQuery) use ($search) {
                    $pasienQuery->where('nama', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('obat', function($obatQuery) use ($search) {
                    $obatQuery->where('nama_obat', 'LIKE', "%{$search}%");
                })
                ->orWhere('instruksi', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('kunjungan_id')) {
            $query->where('kunjungan_id', $request->kunjungan_id);
        }

        if ($request->filled('obat_id')) {
            $query->where('obat_id', $request->obat_id);
        }

        $sortBy = $request->get('sort_field', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $kunjunganObats = $query->paginate(10)->withQueryString();

        $kunjungans = Kunjungan::with('pasien')->orderBy('tanggal_kunjungan', 'desc')->limit(100)->get();
        $obats = Obat::orderBy('nama_obat')->get();

        return view('kunjungan-obat.index', compact('kunjunganObats', 'kunjungans', 'obats'));
    }

    public function create()
    {
        $kunjungans = Kunjungan::with('pasien')->orderBy('tanggal_kunjungan', 'desc')->limit(100)->get();
        $obats = Obat::orderBy('nama_obat')->get();
        
        return view('kunjungan-obat.create', compact('kunjungans', 'obats'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'obat_id' => 'required|exists:obats,id',
            'jumlah' => 'required|integer|min:1',
            'tarif' => 'required|numeric|min:0',
            'instruksi' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $validator->validated();
        $obat = Obat::findOrFail($data['obat_id']);
        if ($data['jumlah'] > $obat->stok) {
            return back()->withInput()->withErrors(['jumlah' => 'Stok tidak cukup. Stok tersedia: ' . $obat->stok]);
        }
        $data['subtotal'] = $data['jumlah'] * $data['tarif'];
        $obat->stok -= $data['jumlah'];
        $obat->save();
        KunjunganObat::create($data);
        return redirect()->route('kunjungan-obat.index')
            ->with('success', 'Obat kunjungan berhasil ditambahkan.');
    }

    public function show(KunjunganObat $kunjunganObat)
    {
        $kunjunganObat->load(['kunjungan.pasien', 'obat']);
        return view('kunjungan-obat.show', compact('kunjunganObat'));
    }

    public function edit(KunjunganObat $kunjunganObat)
    {
        $kunjungans = Kunjungan::with('pasien')->orderBy('tanggal_kunjungan', 'desc')->limit(100)->get();
        $obats = Obat::orderBy('nama_obat')->get();
        
        return view('kunjungan-obat.edit', compact('kunjunganObat', 'kunjungans', 'obats'));
    }

    public function update(Request $request, KunjunganObat $kunjunganObat)
    {
        $validator = Validator::make($request->all(), [
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'obat_id' => 'required|exists:obats,id',
            'jumlah' => 'required|integer|min:1',
            'tarif' => 'required|numeric|min:0',
            'instruksi' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $validator->validated();
        $data['subtotal'] = $data['jumlah'] * $data['tarif'];
        $kunjunganObat->update($data);
        return redirect()->route('kunjungan-obat.index')
            ->with('success', 'Obat kunjungan berhasil diperbarui.');
    }

    public function destroy(KunjunganObat $kunjunganObat)
    {
        $kunjunganObat->delete();

        return redirect()->route('kunjungan-obat.index')
            ->with('success', 'Obat kunjungan berhasil dihapus.');
    }

    public function getObatTarif(Obat $obat)
    {
        return response()->json([
            'tarif' => $obat->harga
        ]);
    }
}
