<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::with(['provinsi', 'kabupaten', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nip', 'LIKE', "%{$search}%")
                  ->orWhere('jabatan', 'LIKE', "%{$search}%")
                  ->orWhere('spesialisasi', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('jabatan')) {
            $query->where('jabatan', $request->jabatan);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
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

        $pegawais = $query->paginate(10)->appends($request->query());
        $provinsis = Provinsi::orderBy('nama')->get();
        
        return view('pegawai.index', compact('pegawais', 'provinsis'));
    }

    public function create()
    {
        $provinsis = Provinsi::orderBy('nama')->get();
        $kabupatens = Kabupaten::orderBy('nama')->get();
        $users = User::whereDoesntHave('pegawai')->orderBy('name')->get();
        return view('pegawai.create', compact('provinsis', 'kabupatens', 'users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:pegawais|max:18',
            'jabatan' => 'required|string|max:100',
            'spesialisasi' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'provinsi_id' => 'required|exists:provinsis,id',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'user_id' => 'required|exists:users,id|unique:pegawais',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->jabatan ==='Dokter') {
            $validator->after(function ($validator) use ($request) {
                if (empty($request->spesialisasi)) {
                    $validator->errors()->add('spesialisasi', 'Spesialisasi wajib diisi untuk dokter.');
                }
            });
        }

        Pegawai::create($validator->validated());

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function show(Pegawai $pegawai)
    {
        $pegawai->load(['provinsi', 'kabupaten', 'user']);
        return view('pegawai.show', compact('pegawai'));
    }

    public function edit(Pegawai $pegawai)
    {
        $provinsis = Provinsi::orderBy('nama')->get();
        $kabupatens = Kabupaten::where('provinsi_id', $pegawai->provinsi_id)->orderBy('nama')->get();
        $users = User::whereDoesntHave('pegawai')
                    ->orWhere('id', $pegawai->user_id)
                    ->orderBy('name')->get();
        return view('pegawai.edit', compact('pegawai', 'provinsis', 'kabupatens', 'users'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:18|unique:pegawais,nip,' . $pegawai->id,
            'jabatan' => 'required|string|max:100',
            'spesialisasi' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'provinsi_id' => 'required|exists:provinsis,id',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'user_id' => 'required|exists:users,id|unique:pegawais,user_id,' . $pegawai->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pegawai->update($validator->validated());

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil diperbarui');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus');
    }

}