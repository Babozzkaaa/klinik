@extends('layouts.app')

@section('title', 'Edit Obat')

@section('content')
<div class="container mx-auto px-4 py-6">
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('obat.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Obat</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Edit Obat</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">
            <i class="fas fa-edit mr-3 text-yellow-600"></i>Edit Obat: {{ $obat->nama_obat }}
        </h2>
        
        <form action="{{ route('obat.update', $obat->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_obat" class="block text-sm font-medium text-gray-700">Nama Obat</label>
                    <input type="text" name="nama_obat" id="nama_obat" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('nama_obat', $obat->nama_obat) }}">
                    @error('nama_obat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="kode_obat" class="block text-sm font-medium text-gray-700">Kode Obat</label>
                    <input type="text" name="kode_obat" id="kode_obat" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('kode_obat', $obat->kode_obat) }}">
                    @error('kode_obat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="jenis_obat" class="block text-sm font-medium text-gray-700">Jenis Obat</label>
                    <select name="jenis_obat" id="jenis_obat" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Jenis Obat</option>
                        <option value="Tablet" {{ (old('jenis_obat', $obat->jenis_obat) == 'Tablet') ? 'selected' : '' }}>Tablet</option>
                        <option value="Kapsul" {{ (old('jenis_obat', $obat->jenis_obat) == 'Kapsul') ? 'selected' : '' }}>Kapsul</option>
                        <option value="Sirup" {{ (old('jenis_obat', $obat->jenis_obat) == 'Sirup') ? 'selected' : '' }}>Sirup</option>
                        <option value="Salep" {{ (old('jenis_obat', $obat->jenis_obat) == 'Salep') ? 'selected' : '' }}>Salep</option>
                        <option value="Injeksi" {{ (old('jenis_obat', $obat->jenis_obat) == 'Injeksi') ? 'selected' : '' }}>Injeksi</option>
                    </select>
                    @error('jenis_obat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
                    <select name="satuan" id="satuan" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Satuan</option>
                        <option value="Tablet" {{ (old('satuan', $obat->satuan) == 'Tablet') ? 'selected' : '' }}>Tablet</option>
                        <option value="Kapsul" {{ (old('satuan', $obat->satuan) == 'Kapsul') ? 'selected' : '' }}>Kapsul</option>
                        <option value="Botol" {{ (old('satuan', $obat->satuan) == 'Botol') ? 'selected' : '' }}>Botol</option>
                        <option value="Tube" {{ (old('satuan', $obat->satuan) == 'Tube') ? 'selected' : '' }}>Tube</option>
                        <option value="Ampul" {{ (old('satuan', $obat->satuan) == 'Ampul') ? 'selected' : '' }}>Ampul</option>
                        <option value="Strip" {{ (old('satuan', $obat->satuan) == 'Strip') ? 'selected' : '' }}>Strip</option>
                    </select>
                    @error('satuan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" name="harga" id="harga" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('harga', $obat->harga) }}">
                    @error('harga')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" name="stok" id="stok" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('stok', $obat->stok) }}">
                    @error('stok')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="tanggal_kadaluarsa" class="block text-sm font-medium text-gray-700">Tanggal Kadaluarsa</label>
                    <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('tanggal_kadaluarsa', $obat->tanggal_kadaluarsa) }}">
                    @error('tanggal_kadaluarsa')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-8 flex justify-end">
                <a href="{{ route('obat.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                    Batal
                </a>
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save mr-2"></i>Update Obat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
