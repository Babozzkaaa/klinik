<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Kunjungan;
use App\Models\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PembayaranController extends Controller

    
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['kunjungan.pasien', 'kasir']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_pembayaran', 'LIKE', "%{$search}%")
                ->orWhereHas('kunjungan.pasien', function($pasienQuery) use ($search) {
                    $pasienQuery->where('nama', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('kasir', function($kasirQuery) use ($search) {
                    $kasirQuery->where('nama', 'LIKE', "%{$search}%");
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_pembayaran', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_pembayaran', '<=', $request->tanggal_sampai);
        }

        $sortBy = $request->get('sort_field', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $pembayarans = $query->paginate(10)->withQueryString();

        $kunjungans = Kunjungan::with('pasien')->get();
        $kasirs = Pegawai::where('jabatan', 'like', '%kasir%')->orWhere('jabatan', 'like', '%admin%')->get();

        return view('pembayaran.index', compact('pembayarans', 'kunjungans', 'kasirs'));
    }

    public function create()
    {
        // ambil kunjungan yang belum memiliki pembayaran atau statusnya masih pending
        $kunjungans = Kunjungan::with('pasien')
            ->whereDoesntHave('pembayaran', function($query) {
                $query->where('status', 'selesai');
            })
            ->get();

        $kasirs = Pegawai::where('jabatan', 'Kasir')->get();

        return view('pembayaran.create', compact('kunjungans', 'kasirs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'kasir_id' => 'required|exists:pegawais,id',
            'total_tagihan' => 'required|numeric|min:0',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:cash,debit,kredit',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $kembalian = max(0, $validated['jumlah_dibayar'] - $validated['total_tagihan']);

        $noPembayaran = Pembayaran::generateNomorPembayaran();

        $status = 'pending';
        if ($validated['jumlah_dibayar'] >= $validated['total_tagihan']) {
            $status = 'selesai';
        } elseif ($validated['jumlah_dibayar'] > 0) {
            $status = 'sebagian';
        }

        $pembayaran = Pembayaran::create([
            'kunjungan_id' => $validated['kunjungan_id'],
            'kasir_id' => $validated['kasir_id'],
            'no_pembayaran' => $noPembayaran,
            'total_tagihan' => $validated['total_tagihan'],
            'jumlah_dibayar' => $validated['jumlah_dibayar'],
            'kembalian' => $kembalian,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'catatan' => $validated['catatan'],
            'status' => $status,
            'tanggal_pembayaran' => now(),
        ]);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['kunjungan.pasien', 'kunjungan.pegawai', 'kasir']);
        return view('pembayaran.show', compact('pembayaran'));
    }

    public function edit(Pembayaran $pembayaran)
    {
        $kunjungans = Kunjungan::with('pasien')->get();
        $kasirs = Pegawai::where('jabatan', 'like', '%kasir%')->orWhere('jabatan', 'like', '%admin%')->get();

        return view('pembayaran.edit', compact('pembayaran', 'kunjungans', 'kasirs'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'kasir_id' => 'required|exists:pegawais,id',
            'total_tagihan' => 'required|numeric|min:0',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:cash,debit,kredit',
            'status' => 'required|in:pending,sebagian,selesai',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $kembalian = max(0, $validated['jumlah_dibayar'] - $validated['total_tagihan']);

        $pembayaran->update([
            'kunjungan_id' => $validated['kunjungan_id'],
            'kasir_id' => $validated['kasir_id'],
            'total_tagihan' => $validated['total_tagihan'],
            'jumlah_dibayar' => $validated['jumlah_dibayar'],
            'kembalian' => $kembalian,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'catatan' => $validated['catatan'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus.');
    }

    public function getKunjunganDetail(Request $request)
    {
        try {
            $request->validate([
                'kunjungan_id' => 'required|exists:kunjungans,id'
            ]);

            $kunjungan = Kunjungan::with(['kunjunganTindakan.tindakan', 'kunjunganObat.obat'])
                ->findOrFail($request->kunjungan_id);

            $totalTindakan = $kunjungan->kunjunganTindakan->sum('subtotal');
            $detailTindakan = $kunjungan->kunjunganTindakan->map(function($kt) {
                return [
                    'tindakan' => $kt->tindakan,
                    'jumlah' => $kt->jumlah,
                    'subtotal' => $kt->subtotal
                ];
            });

            $totalObat = $kunjungan->kunjunganObat->sum('subtotal');
            $detailObat = $kunjungan->kunjunganObat->map(function($ko) {
                return [
                    'obat' => $ko->obat,
                    'jumlah' => $ko->jumlah,
                    'subtotal' => $ko->subtotal
                ];
            });

            $totalTagihan = $totalTindakan + $totalObat;

            return response()->json([
                'total_tindakan' => $totalTindakan,
                'total_obat' => $totalObat,
                'total_tagihan' => $totalTagihan,
                'detail_tindakan' => $detailTindakan,
                'detail_obat' => $detailObat,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal memuat detail kunjungan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportPdf(Pembayaran $pembayaran)
    {
        $pembayaran->load(['kunjungan.pasien', 'kunjungan.kunjunganTindakan.tindakan', 'kunjungan.kunjunganObat.obat', 'kasir']);
        $pdf = Pdf::loadView('pembayaran.pdf', compact('pembayaran'));
        $filename = 'Pembayaran_' . $pembayaran->no_pembayaran . '.pdf';
        return $pdf->download($filename);
    }

    public function exportAllPdf(Request $request)
    {
        $query = Pembayaran::with(['kunjungan.pasien', 'kasir']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_pembayaran', 'LIKE', "%{$search}%")
                ->orWhereHas('kunjungan.pasien', function($pasienQuery) use ($search) {
                    $pasienQuery->where('nama', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('kasir', function($kasirQuery) use ($search) {
                    $kasirQuery->where('nama', 'LIKE', "%{$search}%");
                });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_pembayaran', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_pembayaran', '<=', $request->tanggal_sampai);
        }

        $pembayarans = $query->orderBy('tanggal_pembayaran', 'desc')->get();

    $pdf = Pdf::loadView('pembayaran.pdf_all', compact('pembayarans'));
        $filename = 'Daftar_Pembayaran_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }

}
