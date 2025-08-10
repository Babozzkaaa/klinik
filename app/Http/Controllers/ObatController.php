<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObatController extends Controller
{
public function index(Request $request)
    {
        $query = Obat::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_obat', 'LIKE', "%{$search}%")
                  ->orWhere('kode_obat', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('jenis_obat')) {
            $query->where('jenis_obat', $request->jenis_obat);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $obats = $query->paginate(10)->appends($request->query());
        
        return view('obat.index', compact('obats'));
    }

    public function create()
    {
        return view('obat.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            'kode_obat' => 'required|string|unique:obats',
            'jenis_obat' => 'required|string',
            'satuan' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'tanggal_kadaluarsa' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Obat::create($validator->validated());

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    public function show(Obat $obat)
    {
        return view('obat.show', compact('obat'));
    }

    public function edit(Obat $obat)
    {
        return view('obat.edit', compact('obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            'kode_obat' => 'required|string|unique:obats,kode_obat,' . $obat->id,
            'jenis_obat' => 'required|string',
            'satuan' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'tanggal_kadaluarsa' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $obat->update($validator->validated());

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil diperbarui');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil dihapus');
    }
}
