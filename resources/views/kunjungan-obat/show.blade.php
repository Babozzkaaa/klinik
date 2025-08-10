@extends('layouts.app')

@section('title', 'Detail Obat Kunjungan')

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
                    <span class="text-sm font-medium text-gray-500">Detail Kunjungan Obat</span>
                </div>
            </li>
        </ol>
    </nav>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detail Obat Kunjungan</h1>
            <div class="flex space-x-3">
                <a href="{{ route('kunjungan-obat.edit', $kunjunganObat) }}" 
                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('kunjungan-obat.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pasien</label>
                        <p class="text-gray-900">{{ $kunjunganObat->kunjungan->pasien->nama }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kunjungan</label>
                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($kunjunganObat->kunjungan->tanggal_kunjungan)->format('d/m/Y') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keluhan</label>
                        <p class="text-gray-900">{{ $kunjunganObat->kunjungan->keluhan ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Obat</label>
                        <p class="text-gray-900">{{ $kunjunganObat->obat->nama_obat }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                        <p class="text-gray-900">{{ number_format($kunjunganObat->jumlah) }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tarif</label>
                        <p class="text-gray-900">Rp {{ number_format($kunjunganObat->tarif, 0, ',', '.') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subtotal</label>
                        <p class="text-gray-900 font-semibold text-lg">Rp {{ number_format($kunjunganObat->subtotal, 0, ',', '.') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Instruksi Penggunaan</label>
                        <p class="text-gray-900">{{ $kunjunganObat->instruksi ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dibuat</label>
                        <p class="text-gray-900">{{ $kunjunganObat->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    @if($kunjunganObat->updated_at != $kunjunganObat->created_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Diperbarui</label>
                            <p class="text-gray-900">{{ $kunjunganObat->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informasi Obat -->
            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Obat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Obat</label>
                        <p class="text-gray-900">{{ $kunjunganObat->obat->nama_obat }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Obat</label>
                        <p class="text-gray-900">Rp {{ number_format($kunjunganObat->obat->harga, 0, ',', '.') }}</p>
                    </div>

                    @if($kunjunganObat->obat->satuan)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                            <p class="text-gray-900">{{ $kunjunganObat->obat->satuan }}</p>
                        </div>
                    @endif

                </div>
            </div>
    </div>
</div>
@endsection
