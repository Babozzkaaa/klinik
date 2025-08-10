@extends('layouts.app')

@section('title', 'Edit Pembayaran')

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
                    <a href="{{ route('pembayaran.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Pembayaran</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Edit Pembayaran</span>
                </div>
            </li>
        </ol>
    </nav>


        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-2 sm:space-y-0">
            <h1 class="text-2xl font-bold text-gray-900">Edit Pembayaran</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('pembayaran.update', $pembayaran) }}" method="POST" id="pembayaran-form">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="no_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                            No Pembayaran
                        </label>
                        <input type="text" id="no_pembayaran" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               value="{{ $pembayaran->no_pembayaran }}" readonly>
                    </div>

                    <div>
                        <label for="kunjungan_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <select name="kunjungan_id" id="kunjungan_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kunjungan_id') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Kunjungan</option>
                            @foreach($kunjungans as $kunjungan)
                                <option value="{{ $kunjungan->id }}" {{ (old('kunjungan_id', $pembayaran->kunjungan_id) == $kunjungan->id) ? 'selected' : '' }}>
                                    {{ $kunjungan->pasien->nama ?? 'Unknown' }} - {{ $kunjungan->tanggal_kunjungan->format('d/m/Y H:i') }}
                                </option>
                            @endforeach
                        </select>
                        @error('kunjungan_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kasir_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Kasir <span class="text-red-500">*</span>
                        </label>
                        <select name="kasir_id" id="kasir_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kasir_id') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Kasir</option>
                            @foreach($kasirs as $kasir)
                                <option value="{{ $kasir->id }}" {{ (old('kasir_id', $pembayaran->kasir_id) == $kasir->id) ? 'selected' : '' }}>
                                    {{ $kasir->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kasir_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="total_tagihan" class="block text-sm font-medium text-gray-700 mb-2">
                            Total Tagihan <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="total_tagihan" id="total_tagihan" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('total_tagihan') border-red-500 @enderror"
                               placeholder="Masukkan total tagihan"
                               value="{{ old('total_tagihan', $pembayaran->total_tagihan) }}"
                               min="0" step="0.01" required>
                        @error('total_tagihan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jumlah_dibayar" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah Dibayar <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="jumlah_dibayar" id="jumlah_dibayar" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jumlah_dibayar') border-red-500 @enderror"
                               placeholder="Masukkan jumlah yang dibayar"
                               value="{{ old('jumlah_dibayar', $pembayaran->jumlah_dibayar) }}"
                               min="0" step="0.01" required>
                        @error('jumlah_dibayar')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kembalian_display" class="block text-sm font-medium text-gray-700 mb-2">
                            Kembalian
                        </label>
                        <input type="text" id="kembalian_display" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               readonly placeholder="Kembalian akan dihitung otomatis">
                    </div>

                    <div>
                        <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Metode Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <select name="metode_pembayaran" id="metode_pembayaran" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('metode_pembayaran') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Metode Pembayaran</option>
                            <option value="cash" {{ (old('metode_pembayaran', $pembayaran->metode_pembayaran) == 'cash') ? 'selected' : '' }}>Cash</option>
                            <option value="debit" {{ (old('metode_pembayaran', $pembayaran->metode_pembayaran) == 'debit') ? 'selected' : '' }}>Debit</option>
                            <option value="kredit" {{ (old('metode_pembayaran', $pembayaran->metode_pembayaran) == 'kredit') ? 'selected' : '' }}>Kredit</option>
                        </select>
                        @error('metode_pembayaran')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror"
                                required>
                            <option value="pending" {{ (old('status', $pembayaran->status) == 'pending') ? 'selected' : '' }}>Pending</option>
                            <option value="sebagian" {{ (old('status', $pembayaran->status) == 'sebagian') ? 'selected' : '' }}>Sebagian</option>
                            <option value="selesai" {{ (old('status', $pembayaran->status) == 'selesai') ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan
                        </label>
                        <textarea name="catatan" id="catatan" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('catatan') border-red-500 @enderror"
                                  placeholder="Catatan tambahan (opsional)">{{ old('catatan', $pembayaran->catatan) }}</textarea>
                        @error('catatan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('pembayaran.index') }}" 
                       class="w-full sm:w-auto bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center order-2 sm:order-1">
                        Batal
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded order-1 sm:order-2">
                        <i class="fas fa-save mr-2"></i>Update
                    </button>
                </div>
            </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalTagihanInput = document.getElementById('total_tagihan');
    const jumlahDibayarInput = document.getElementById('jumlah_dibayar');
    const kembalianDisplay = document.getElementById('kembalian_display');

    function calculateKembalian() {
        const totalTagihan = parseFloat(totalTagihanInput.value || 0);
        const jumlahDibayar = parseFloat(jumlahDibayarInput.value || 0);
        const kembalian = Math.max(0, jumlahDibayar - totalTagihan);
        
        if (kembalian > 0) {
            kembalianDisplay.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(kembalian);
        } else {
            kembalianDisplay.value = 'Rp 0';
        }
    }

    totalTagihanInput.addEventListener('input', calculateKembalian);
    jumlahDibayarInput.addEventListener('input', calculateKembalian);

    calculateKembalian();
});
</script>
@endsection
