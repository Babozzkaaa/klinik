@extends('layouts.app')

@section('title', 'Tambah Kunjungan')

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
                    <a href="{{ route('kunjungan.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Kunjungan</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Tambah Kunjungan</span>
                </div>
            </li>
        </ol>
    </nav>
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Tambah Kunjungan</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('kunjungan.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="pasien_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pasien <span class="text-red-500">*</span>
                        </label>
                        <select name="pasien_id" id="pasien_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pasien_id') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Pasien</option>
                            @foreach($pasiens as $pasien)
                                <option value="{{ $pasien->id }}" {{ old('pasien_id') == $pasien->id ? 'selected' : '' }}>
                                    {{ $pasien->nama }} - {{ $pasien->no_telp }}
                                </option>
                            @endforeach
                        </select>
                        @error('pasien_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="dokter_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Dokter <span class="text-red-500">*</span>
                        </label>
                        <select name="dokter_id" id="dokter_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('dokter_id') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Dokter</option>
                            @foreach($dokters as $dokter)
                                <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                    {{ $dokter->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('dokter_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal & Waktu Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               name="tanggal_kunjungan" 
                               id="tanggal_kunjungan"
                               value="{{ old('tanggal_kunjungan', now()->format('Y-m-d\TH:i')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_kunjungan') border-red-500 @enderror"
                               required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jenis_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kunjungan" id="jenis_kunjungan" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_kunjungan') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Jenis Kunjungan</option>
                            <option value="umum" {{ old('jenis_kunjungan') === 'umum' ? 'selected' : '' }}>Umum</option>
                            <option value="rujukan" {{ old('jenis_kunjungan') === 'rujukan' ? 'selected' : '' }}>Rujukan</option>
                            <option value="kontrol" {{ old('jenis_kunjungan') === 'kontrol' ? 'selected' : '' }}>Kontrol</option>
                            <option value="rutin" {{ old('jenis_kunjungan') === 'rutin' ? 'selected' : '' }}>Rutin</option>
                            <option value="vaksinasi" {{ old('jenis_kunjungan') === 'vaksinasi' ? 'selected' : '' }}>Vaksinasi</option>
                            <option value="darurat" {{ old('jenis_kunjungan') === 'darurat' ? 'selected' : '' }}>Darurat</option>
                        </select>
                        @error('jenis_kunjungan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="keluhan" class="block text-sm font-medium text-gray-700 mb-2">
                        Keluhan
                    </label>
                    <textarea name="keluhan" 
                              id="keluhan" 
                              rows="4"
                              placeholder="Masukkan keluhan pasien..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('keluhan') border-red-500 @enderror">{{ old('keluhan') }}</textarea>
                    @error('keluhan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="diagnosa" class="block text-sm font-medium text-gray-700 mb-2">
                        Diagnosa
                    </label>
                    <textarea name="diagnosa" 
                              id="diagnosa" 
                              rows="4"
                              placeholder="Masukkan diagnosa..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('diagnosa') border-red-500 @enderror">{{ old('diagnosa') }}</textarea>
                    @error('diagnosa')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('kunjungan.index') }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
    </div>
</div>
@endsection
