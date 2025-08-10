<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TindakanController extends Controller
{
    public function index(Request $request)
    {
        $query = Tindakan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%");
            });
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $tindakans = $query->paginate(10)->appends($request->query());
        
        return view('tindakan.index', compact('tindakans'));
    }

    public function create()
    {
        return view('tindakan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tarif' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Tindakan::create($validator->validated());

        return redirect()->route('tindakan.index')
            ->with('success', 'Tindakan berhasil ditambahkan');
    }

    public function show(Tindakan $tindakan)
    {
        return view('tindakan.show', compact('tindakan'));
    }

    public function edit(Tindakan $tindakan)
    {
        return view('tindakan.edit', compact('tindakan'));
    }

    public function update(Request $request, Tindakan $tindakan)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tarif' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tindakan->update($validator->validated());

        return redirect()->route('tindakan.index')
            ->with('success', 'Tindakan berhasil diperbarui');
    }

    public function destroy(Tindakan $tindakan)
    {
        $tindakan->delete();

        return redirect()->route('tindakan.index')
            ->with('success', 'Tindakan berhasil dihapus');
    }
}
