@extends('layouts.app')

@section('title', 'Tambah Tindakan Kunjungan')

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
                    <a href="{{ route('kunjungan-tindakan.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Kunjungan Tindakan</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Tambah Tindakan Kunjungan</span>
                </div>
            </li>
        </ol>
    </nav>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Tambah Tindakan Kunjungan</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('kunjungan-tindakan.store') }}" method="POST">
                @csrf
                
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
                                <option value="{{ $kunjungan->id }}" {{ old('kunjungan_id') == $kunjungan->id ? 'selected' : '' }}>
                                    {{ $kunjungan->pasien->nama ?? 'Unknown' }} - {{ $kunjungan->tanggal_kunjungan->format('d/m/Y H:i') }}
                                </option>
                            @endforeach
                        </select>
                        @error('kunjungan_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tindakan_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Tindakan <span class="text-red-500">*</span>
                        </label>
                        <select name="tindakan_id" id="tindakan_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tindakan_id') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Tindakan</option>
                            @foreach($tindakans as $tindakan)
                                <option value="{{ $tindakan->id }}" data-tarif="{{ $tindakan->tarif }}" {{ old('tindakan_id') == $tindakan->id ? 'selected' : '' }}>
                                    {{ $tindakan->nama }} - Rp {{ number_format($tindakan->tarif, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('tindakan_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               name="jumlah" 
                               id="jumlah"
                               value="{{ old('jumlah', 1) }}"
                               min="1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jumlah') border-red-500 @enderror"
                               required>
                        @error('jumlah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tarif" class="block text-sm font-medium text-gray-700 mb-2">
                            Tarif per Unit <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               name="tarif" 
                               id="tarif"
                               value="{{ old('tarif') }}"
                               step="0.01"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tarif') border-red-500 @enderror"
                               required>
                        @error('tarif')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="subtotal_display" class="block text-sm font-medium text-gray-700 mb-2">
                        Subtotal
                    </label>
                    <input type="text" 
                           id="subtotal_display"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100"
                           readonly
                           placeholder="Subtotal akan dihitung otomatis">
                </div>

                <div class="mt-6">
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan
                    </label>
                    <textarea name="catatan" 
                              id="catatan" 
                              rows="4"
                              placeholder="Masukkan catatan tambahan..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('kunjungan-tindakan.index') }}" 
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tindakanSelect = document.getElementById('tindakan_id');
    const tarifInput = document.getElementById('tarif');
    const jumlahInput = document.getElementById('jumlah');
    const subtotalDisplay = document.getElementById('subtotal_display');

    tindakanSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const tarif = selectedOption.getAttribute('data-tarif');
            tarifInput.value = tarif;
            calculateSubtotal();
        } else {
            tarifInput.value = '';
            subtotalDisplay.value = '';
        }
    });

    function calculateSubtotal() {
        const jumlah = parseFloat(jumlahInput.value) || 0;
        const tarif = parseFloat(tarifInput.value) || 0;
        const subtotal = jumlah * tarif;
        
        if (subtotal > 0) {
            subtotalDisplay.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
        } else {
            subtotalDisplay.value = '';
        }
    }

    jumlahInput.addEventListener('input', calculateSubtotal);
    tarifInput.addEventListener('input', calculateSubtotal);

    calculateSubtotal();
});
</script>
@endsection
