<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvinsiController extends Controller
{
    public function index(Request $request)
    {
        $query = Provinsi::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('kode', 'LIKE', "%{$search}%");
            });
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $provinsis = $query->paginate(10)->appends($request->query());
        
        return view('provinsi.index', compact('provinsis'));
    }

    public function create()
    {
        return view('provinsi.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|unique:provinsis|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Provinsi::create($validator->validated());

        return redirect()->route('provinsi.index')
            ->with('success', 'Provinsi berhasil ditambahkan');
    }

    public function show(Provinsi $provinsi)
    {
        return view('provinsi.show', compact('provinsi'));
    }

    public function edit(Provinsi $provinsi)
    {
        return view('provinsi.edit', compact('provinsi'));
    }

    public function update(Request $request, Provinsi $provinsi)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:10|unique:provinsis,kode,' . $provinsi->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $provinsi->update($validator->validated());

        return redirect()->route('provinsi.index')
            ->with('success', 'Provinsi berhasil diperbarui');
    }

    public function destroy(Provinsi $provinsi)
    {
        $provinsi->delete();

        return redirect()->route('provinsi.index')
            ->with('success', 'Provinsi berhasil dihapus');
    }
}
