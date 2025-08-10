@extends('layouts.app')

@section('title', 'Tambah Pembayaran')

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
                    <span class="text-sm font-medium text-gray-500">Tambah Pembayaran</span>
                </div>
            </li>
        </ol>
    </nav>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-2 sm:space-y-0">
            <h1 class="text-2xl font-bold text-gray-900">Tambah Pembayaran</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('pembayaran.store') }}" method="POST" id="pembayaran-form">
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
                                <option value="{{ $kasir->id }}" {{ old('kasir_id') == $kasir->id ? 'selected' : '' }}>
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
                               placeholder="Total tagihan akan otomatis terisi"
                               value="{{ old('total_tagihan') }}"
                               min="0" step="0.01" readonly required>
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
                               value="{{ old('jumlah_dibayar') }}"
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
                            <option value="cash" {{ old('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="debit" {{ old('metode_pembayaran') == 'debit' ? 'selected' : '' }}>Debit</option>
                            <option value="kredit" {{ old('metode_pembayaran') == 'kredit' ? 'selected' : '' }}>Kredit</option>
                        </select>
                        @error('metode_pembayaran')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan
                        </label>
                        <textarea name="catatan" id="catatan" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('catatan') border-red-500 @enderror"
                                  placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div id="detail-tagihan" class="mt-8 border-t pt-6" style="display: none;">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Tagihan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Tindakan</h4>
                            <div id="detail-tindakan" class="space-y-1 text-sm text-gray-600">
                            </div>
                            <div class="mt-2 pt-2 border-t">
                                <span class="font-medium">Total Tindakan: </span>
                                <span id="total-tindakan" class="font-semibold">Rp 0</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Obat</h4>
                            <div id="detail-obat" class="space-y-1 text-sm text-gray-600">
                            </div>
                            <div class="mt-2 pt-2 border-t">
                                <span class="font-medium">Total Obat: </span>
                                <span id="total-obat" class="font-semibold">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('pembayaran.index') }}" 
                       class="w-full sm:w-auto bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center order-2 sm:order-1">
                        Batal
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded order-1 sm:order-2">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kunjunganSelect = document.getElementById('kunjungan_id');
    const totalTagihanInput = document.getElementById('total_tagihan');
    const jumlahDibayarInput = document.getElementById('jumlah_dibayar');
    const kembalianDisplay = document.getElementById('kembalian_display');
    const detailTagihan = document.getElementById('detail-tagihan');

    function loadKunjunganDetail() {
        const kunjunganId = kunjunganSelect.value;
        if (!kunjunganId) {
            totalTagihanInput.value = '';
            detailTagihan.style.display = 'none';
            calculateKembalian();
            return;
        }

        fetch(`/pembayaran/kunjungan-detail?kunjungan_id=${kunjunganId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }
                
                totalTagihanInput.value = data.total_tagihan;
                
                const detailTindakanDiv = document.getElementById('detail-tindakan');
                detailTindakanDiv.innerHTML = '';
                data.detail_tindakan.forEach(item => {
                    const div = document.createElement('div');
                    div.innerHTML = `${item.tindakan.nama} (${item.jumlah}x) - Rp ${new Intl.NumberFormat('id-ID').format(item.subtotal)}`;
                    detailTindakanDiv.appendChild(div);
                });
                document.getElementById('total-tindakan').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(data.total_tindakan)}`;

                const detailObatDiv = document.getElementById('detail-obat');
                detailObatDiv.innerHTML = '';
                data.detail_obat.forEach(item => {
                    const div = document.createElement('div');
                    div.innerHTML = `${item.obat.nama_obat} (${item.jumlah}x) - Rp ${new Intl.NumberFormat('id-ID').format(item.subtotal)}`;
                    detailObatDiv.appendChild(div);
                });
                document.getElementById('total-obat').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(data.total_obat)}`;

                detailTagihan.style.display = 'block';
                calculateKembalian();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat detail kunjungan: ' + error.message);
                totalTagihanInput.value = '';
                detailTagihan.style.display = 'none';
            });
    }

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

    kunjunganSelect.addEventListener('change', loadKunjunganDetail);
    jumlahDibayarInput.addEventListener('input', calculateKembalian);
});
</script>
@endsection
