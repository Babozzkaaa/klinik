<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KabupatenController extends Controller
{
    public function index(Request $request)
    {
        $query = Kabupaten::with('provinsi');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('kode', 'LIKE', "%{$search}%")
                  ->orWhereHas('provinsi', function($provinsiQuery) use ($search) {
                      $provinsiQuery->where('nama', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($request->filled('provinsi_id')) {
            $query->where('provinsi_id', $request->provinsi_id);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $kabupatens = $query->paginate(10)->appends($request->query());
        $provinsis = Provinsi::orderBy('nama')->get();
        
        return view('kabupaten.index', compact('kabupatens', 'provinsis'));
    }

    public function create()
    {
        $provinsis = Provinsi::orderBy('nama')->get();
        return view('kabupaten.create', compact('provinsis'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|unique:kabupatens|max:10',
            'provinsi_id' => 'required|exists:provinsis,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Kabupaten::create($validator->validated());

        return redirect()->route('kabupaten.index')
            ->with('success', 'Kabupaten berhasil ditambahkan');
    }

    public function show(Kabupaten $kabupaten)
    {
        $kabupaten->load('provinsi');
        return view('kabupaten.show', compact('kabupaten'));
    }

    public function edit(Kabupaten $kabupaten)
    {
        $provinsis = Provinsi::orderBy('nama')->get();
        return view('kabupaten.edit', compact('kabupaten', 'provinsis'));
    }

    public function update(Request $request, Kabupaten $kabupaten)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:10|unique:kabupatens,kode,' . $kabupaten->id,
            'provinsi_id' => 'required|exists:provinsis,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kabupaten->update($validator->validated());

        return redirect()->route('kabupaten.index')
            ->with('success', 'Kabupaten berhasil diperbarui');
    }

    public function destroy(Kabupaten $kabupaten)
    {
        $kabupaten->delete();

        return redirect()->route('kabupaten.index')
            ->with('success', 'Kabupaten berhasil dihapus');
    }
}
