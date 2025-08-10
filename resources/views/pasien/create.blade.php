@extends('layouts.app')

@section('title', 'Tambah Pasien Baru')

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
                    <a href="{{ route('pasien.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Pasien</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Tambah Pasien</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Tambah Pasien Baru</h2>
        
        <form action="{{ route('pasien.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="no_telp" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                    <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('no_telp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('tanggal_lahir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="gol_darah" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                    <select name="gol_darah" id="gol_darah"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Golongan Darah</option>
                        <option value="A" {{ old('gol_darah') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('gol_darah') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('gol_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('gol_darah') == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                    @error('gol_darah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('pekerjaan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="provinsi_id" class="block text-sm font-medium text-gray-700">Provinsi</label>
                    <select name="provinsi_id" id="provinsi_id" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Provinsi</option>
                        @foreach($provinsis as $provinsi)
                            <option value="{{ $provinsi->id }}" {{ old('provinsi_id') == $provinsi->id ? 'selected' : '' }}>
                                {{ $provinsi->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('provinsi_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="kabupaten_id" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                    <select name="kabupaten_id" id="kabupaten_id" required disabled
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100">
                        <option value="">Pilih Provinsi dahulu</option>
                        @foreach($kabupatens as $kabupaten)
                            <option value="{{ $kabupaten->id }}" data-provinsi="{{ $kabupaten->provinsi_id }}" {{ old('kabupaten_id') == $kabupaten->id ? 'selected' : '' }} style="display: none;">
                                {{ $kabupaten->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kabupaten_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-6">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" rows="3" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="alergi" class="block text-sm font-medium text-gray-700">Alergi</label>
                    <textarea name="alergi" id="alergi" rows="3"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Daftar alergi yang dimiliki pasien (opsional)">{{ old('alergi') }}</textarea>
                    @error('alergi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="riwayat_penyakit" class="block text-sm font-medium text-gray-700">Riwayat Penyakit</label>
                    <textarea name="riwayat_penyakit" id="riwayat_penyakit" rows="3"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Riwayat penyakit yang pernah dialami (opsional)">{{ old('riwayat_penyakit') }}</textarea>
                    @error('riwayat_penyakit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-8 flex justify-end">
                <a href="{{ route('pasien.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save"></i> Simpan Pasien
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinsiSelect = document.getElementById('provinsi_id');
    const kabupatenSelect = document.getElementById('kabupaten_id');
    
    const allKabupatenOptions = [];
    const originalOptions = kabupatenSelect.querySelectorAll('option[data-provinsi]');
    originalOptions.forEach(option => {
        allKabupatenOptions.push({
            value: option.value,
            text: option.textContent,
            provinsiId: option.getAttribute('data-provinsi'),
            selected: option.selected
        });
    });
    
    function updateKabupatenOptions() {
        const selectedProvinsiId = provinsiSelect.value;
        
        kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
        
        if (selectedProvinsiId) {
            kabupatenSelect.disabled = false;
            
            const matchingKabupatens = allKabupatenOptions.filter(kabupaten => 
                String(kabupaten.provinsiId) === String(selectedProvinsiId)
            );
            
            if (matchingKabupatens.length > 0) {
                matchingKabupatens.forEach(kabupaten => {
                    const option = document.createElement('option');
                    option.value = kabupaten.value;
                    option.textContent = kabupaten.text;
                    if ('{{ old("kabupaten_id") }}' === kabupaten.value) {
                        option.selected = true;
                    }
                    kabupatenSelect.appendChild(option);
                });
            } else {
                kabupatenSelect.innerHTML = '<option value="">Tidak ada kabupaten tersedia</option>';
            }
        } else {
            kabupatenSelect.disabled = true;
            kabupatenSelect.innerHTML = '<option value="">Pilih Provinsi dahulu</option>';
        }
    }
    
    provinsiSelect.addEventListener('change', updateKabupatenOptions);
    
    if (provinsiSelect.value) {
        updateKabupatenOptions();
    }
});
</script>
@endsection
