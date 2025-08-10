@extends('layouts.app')

@section('title', 'Edit Obat Kunjungan')

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
                    <a href="{{ route('kunjungan-obat.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Kunjungan Obat</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Edit Kunjungan Obat</span>
                </div>
            </li>
        </ol>
    </nav>

<div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Obat Kunjungan</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('kunjungan-obat.update', $kunjunganObat) }}" method="POST" id="kunjungan-obat-form">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kunjungan_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <select name="kunjungan_id" id="kunjungan_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kunjungan_id') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Kunjungan</option>
                            @foreach($kunjungans as $kunjungan)
                                <option value="{{ $kunjungan->id }}" {{ (old('kunjungan_id', $kunjunganObat->kunjungan_id) == $kunjungan->id) ? 'selected' : '' }}>
                                    {{ $kunjungan->pasien->nama ?? 'Unknown' }} - {{ $kunjungan->tanggal_kunjungan->format('d/m/Y H:i') }}
                                </option>
                            @endforeach
                        </select>
                        @error('kunjungan_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="obat_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Obat <span class="text-red-500">*</span>
                        </label>
                        <select name="obat_id" id="obat_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('obat_id') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Obat</option>
                            @foreach($obats as $obat)
                                <option value="{{ $obat->id }}" data-harga="{{ $obat->harga }}" {{ (old('obat_id', $kunjunganObat->obat_id) == $obat->id) ? 'selected' : '' }}>
                                    {{ $obat->nama_obat }} - Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('obat_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="jumlah" id="jumlah" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jumlah') border-red-500 @enderror"
                               placeholder="Masukkan jumlah obat"
                               value="{{ old('jumlah', $kunjunganObat->jumlah) }}"
                               min="1" step="1" required>
                        @error('jumlah')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tarif" class="block text-sm font-medium text-gray-700 mb-2">
                            Tarif <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="tarif" id="tarif" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tarif') border-red-500 @enderror"
                               placeholder="Tarif akan otomatis terisi"
                               value="{{ old('tarif', $kunjunganObat->tarif) }}"
                               min="0" step="0.01" readonly required>
                        @error('tarif')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="subtotal_display" class="block text-sm font-medium text-gray-700 mb-2">
                            Subtotal
                        </label>
                        <input type="text" id="subtotal_display" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               readonly placeholder="Subtotal akan dihitung otomatis">
                    </div>

                    <div class="md:col-span-2">
                        <label for="instruksi" class="block text-sm font-medium text-gray-700 mb-2">
                            Instruksi Penggunaan
                        </label>
                        <textarea name="instruksi" id="instruksi" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('instruksi') border-red-500 @enderror"
                                  placeholder="Contoh: 3x sehari setelah makan">{{ old('instruksi', $kunjunganObat->instruksi) }}</textarea>
                        @error('instruksi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('kunjungan-obat.index') }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-save mr-2"></i>Update
                    </button>
                </div>
            </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const obatSelect = document.getElementById('obat_id');
    const jumlahInput = document.getElementById('jumlah');
    const tarifInput = document.getElementById('tarif');
    const subtotalDisplay = document.getElementById('subtotal_display');

    function updateTarif() {
        const selectedOption = obatSelect.options[obatSelect.selectedIndex];
        if (selectedOption.value) {
            const harga = parseFloat(selectedOption.dataset.harga || 0);
            tarifInput.value = harga;
            calculateSubtotal();
        } else {
            tarifInput.value = '';
            subtotalDisplay.value = '';
        }
    }

    function calculateSubtotal() {
        const jumlah = parseFloat(jumlahInput.value || 0);
        const tarif = parseFloat(tarifInput.value || 0);
        const subtotal = jumlah * tarif;
        
        if (subtotal > 0) {
            subtotalDisplay.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
        } else {
            subtotalDisplay.value = '';
        }
    }

    obatSelect.addEventListener('change', updateTarif);
    jumlahInput.addEventListener('input', calculateSubtotal);
    tarifInput.addEventListener('input', calculateSubtotal);

    calculateSubtotal();
});
</script>
@endsection
