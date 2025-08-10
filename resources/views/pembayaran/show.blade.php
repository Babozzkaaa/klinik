@extends('layouts.app')

@section('title', 'Detail Pembayaran')

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
                    <span class="text-sm font-medium text-gray-500">Detail Pembayaran</span>
                </div>
            </li>
        </ol>
    </nav>


        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-2 sm:space-y-0">
            <h1 class="text-2xl font-bold text-gray-900">Detail Pembayaran</h1>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                <a href="{{ route('pembayaran.edit', $pembayaran) }}" 
                   class="w-full sm:w-auto bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-center">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('pembayaran.index') }}" 
                   class="w-full sm:w-auto bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            <a href="{{ route('pembayaran.export-pdf', $pembayaran) }}" target="_blank" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-file-pdf mr-2"></i> Export PDF
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No Pembayaran</label>
                    <p class="text-gray-900 font-semibold">{{ $pembayaran->no_pembayaran }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembayaran</label>
                    <p class="text-gray-900">{{ $pembayaran->tanggal_pembayaran->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $pembayaran->status == 'selesai' ? 'bg-green-100 text-green-800' : 
                           ($pembayaran->status == 'sebagian' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($pembayaran->status) }}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $pembayaran->metode_pembayaran == 'cash' ? 'bg-green-100 text-green-800' : 
                           ($pembayaran->metode_pembayaran == 'debit' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                        {{ ucfirst($pembayaran->metode_pembayaran) }}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kasir</label>
                    <p class="text-gray-900">{{ $pembayaran->kasir->nama }}</p>
                </div>
            </div>

            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kunjungan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pasien</label>
                        <p class="text-gray-900">{{ $pembayaran->kunjungan->pasien->nama }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kunjungan</label>
                        <p class="text-gray-900">{{ $pembayaran->kunjungan->tanggal_kunjungan->format('d/m/Y H:i') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dokter</label>
                        <p class="text-gray-900">{{ $pembayaran->kunjungan->pegawai->nama ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keluhan</label>
                        <p class="text-gray-900">{{ $pembayaran->kunjungan->keluhan ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Rincian Pembayaran</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Total Tagihan</p>
                            <p class="text-xl font-bold text-gray-900">Rp {{ number_format($pembayaran->total_tagihan, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Jumlah Dibayar</p>
                            <p class="text-xl font-bold text-blue-600">Rp {{ number_format($pembayaran->jumlah_dibayar, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Kembalian</p>
                            <p class="text-xl font-bold {{ $pembayaran->kembalian > 0 ? 'text-green-600' : 'text-gray-900' }}">
                                Rp {{ number_format($pembayaran->kembalian, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($pembayaran->kunjungan->kunjunganTindakan->count() > 0 || $pembayaran->kunjungan->kunjunganObat->count() > 0)
            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Tagihan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($pembayaran->kunjungan->kunjunganTindakan->count() > 0)
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Tindakan</h4>
                        <div class="space-y-2">
                            @foreach($pembayaran->kunjungan->kunjunganTindakan as $kunjunganTindakan)
                            <div class="flex justify-between items-center text-sm border-b pb-1">
                                <span>{{ $kunjunganTindakan->tindakan->nama_tindakan }} ({{ $kunjunganTindakan->jumlah }}x)</span>
                                <span class="font-medium">Rp {{ number_format($kunjunganTindakan->subtotal, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-2 pt-2 border-t">
                            <div class="flex justify-between items-center font-semibold">
                                <span>Total Tindakan:</span>
                                <span>Rp {{ number_format($pembayaran->kunjungan->kunjunganTindakan->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($pembayaran->kunjungan->kunjunganObat->count() > 0)
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Obat</h4>
                        <div class="space-y-2">
                            @foreach($pembayaran->kunjungan->kunjunganObat as $kunjunganObat)
                            <div class="flex justify-between items-center text-sm border-b pb-1">
                                <span>{{ $kunjunganObat->obat->nama_obat }} ({{ $kunjunganObat->jumlah }}x)</span>
                                <span class="font-medium">Rp {{ number_format($kunjunganObat->subtotal, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-2 pt-2 border-t">
                            <div class="flex justify-between items-center font-semibold">
                                <span>Total Obat:</span>
                                <span>Rp {{ number_format($pembayaran->kunjungan->kunjunganObat->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if($pembayaran->catatan)
            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700">{{ $pembayaran->catatan }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
