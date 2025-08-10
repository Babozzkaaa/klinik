<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $query = Pasien::with(['provinsi', 'kabupaten']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('no_telp', 'LIKE', "%{$search}%")
                  ->orWhere('pekerjaan', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('gol_darah')) {
            $query->where('gol_darah', $request->gol_darah);
        }

        if ($request->filled('provinsi_id')) {
            $query->where('provinsi_id', $request->provinsi_id);
        }

        $sortBy = $request->get('sort_field', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $pasiens = $query->paginate(10)->appends($request->query());
        $provinsis = Provinsi::orderBy('nama')->get();
        
        return view('pasien.index', compact('pasiens', 'provinsis'));
    }

    public function create()
    {
        $provinsis = Provinsi::orderBy('nama')->get();
        $kabupatens = Kabupaten::orderBy('nama')->get();
        return view('pasien.create', compact('provinsis', 'kabupatens'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'provinsi_id' => 'required|exists:provinsis,id',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'no_telp' => 'nullable|string|max:20',
            'alergi' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'gol_darah' => 'nullable|string|max:3',
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Pasien::create($validator->validated());

        return redirect()->route('pasien.index')
            ->with('success', 'Pasien berhasil ditambahkan');
    }

    public function show(Pasien $pasien)
    {
        $pasien->load(['provinsi', 'kabupaten']);
        return view('pasien.show', compact('pasien'));
    }

    public function edit(Pasien $pasien)
    {
        $provinsis = Provinsi::orderBy('nama')->get();
        $kabupatens = Kabupaten::where('provinsi_id', $pasien->provinsi_id)->orderBy('nama')->get();
        return view('pasien.edit', compact('pasien', 'provinsis', 'kabupatens'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'provinsi_id' => 'required|exists:provinsis,id',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'no_telp' => 'nullable|string|max:20',
            'alergi' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'gol_darah' => 'nullable|string|max:3',
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pasien->update($validator->validated());

        return redirect()->route('pasien.index')
            ->with('success', 'Pasien berhasil diperbarui');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        return redirect()->route('pasien.index')
            ->with('success', 'Pasien berhasil dihapus');
    }
}
