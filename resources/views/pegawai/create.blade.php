@extends('layouts.app')

@section('title', 'Tambah Pegawai Baru')

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
                    <a href="{{ route('pegawai.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Pegawai</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Tambah Pegawai</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Tambah Pegawai Baru</h2>
        
        <form action="{{ route('pegawai.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">User Account <span class="text-red-500">*</span></label>
                    <select name="user_id" id="user_id" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" data-name="{{ $user->name }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" readonly
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-50 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                    <input type="text" name="nip" id="nip" value="{{ old('nip') }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('nip')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Nomor Induk Pegawai </p>
                </div>
                
                <div>
                    <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                    <select name="jabatan" id="jabatan" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Jabatan</option>
                        <option value="Dokter" {{ old('jabatan') == 'Dokter' ? 'selected' : '' }}>Dokter</option>
                        <option value="Petugas" {{ old('jabatan') == 'Petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="Admin" {{ old('jabatan') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Kasir" {{ old('jabatan') == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                    </select>
                    @error('jabatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div id="spesialisasi-field" style="display: {{ old('jabatan') === 'Dokter' ? 'block' : 'none' }};">
                    <label for="spesialisasi" class="block text-sm font-medium text-gray-700">Spesialisasi</label>
                    <input type="text" name="spesialisasi" id="spesialisasi" value="{{ old('spesialisasi') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('spesialisasi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Opsional, khusus untuk dokter</p>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const jabatanSelect = document.getElementById('jabatan');
                    const spesialisasiField = document.getElementById('spesialisasi-field');
                    const userSelect = document.getElementById('user_id');
                    const namaInput = document.getElementById('nama');

                    function toggleSpesialisasi() {
                        if (jabatanSelect.value === 'Dokter') {
                            spesialisasiField.style.display = 'block';
                        } else {
                            spesialisasiField.style.display = 'none';
                        }
                    }

                    function autoFillNama() {
                        const selectedOption = userSelect.options[userSelect.selectedIndex];
                        if (selectedOption.value) {
                            const userName = selectedOption.getAttribute('data-name');
                            namaInput.value = userName || '';
                        } else {
                            namaInput.value = '';
                        }
                    }

                    jabatanSelect.addEventListener('change', toggleSpesialisasi);
                    userSelect.addEventListener('change', autoFillNama);
                    
                    toggleSpesialisasi();
                    autoFillNama();
                });
                </script>
                
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
                        <option value="">Pilih Kabupaten/Kota</option>
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
                
                <div class="md:col-span-2">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                    <textarea name="alamat" id="alamat" rows="3" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-8 flex justify-end">
                <a href="{{ route('pegawai.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save mr-2"></i> Simpan Pegawai
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
