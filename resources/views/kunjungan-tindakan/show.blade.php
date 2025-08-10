@extends('layouts.app')

@section('title', 'Detail Tindakan Kunjungan')

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
                    <span class="text-sm font-medium text-gray-500">Tambah Kunjungan Tindakan</span>
                </div>
            </li>
        </ol>
    </nav>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detail Tindakan Kunjungan</h1>
            <div class="flex space-x-2">
                @if(auth()->user() && auth()->user()->hasPermission('kunjungan-tindakan.update'))
                <a href="{{ route('kunjungan-tindakan.edit', $kunjunganTindakan) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                @endif
                <a href="{{ route('kunjungan-tindakan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kunjungan</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                                <p class="text-sm text-gray-900">{{ $kunjunganTindakan->kunjungan->pasien->nama ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                <p class="text-sm text-gray-900">{{ $kunjunganTindakan->kunjungan->pasien->pekerjaan ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Kunjungan</label>
                                <p class="text-sm text-gray-900">{{ $kunjunganTindakan->kunjungan->tanggal_kunjungan->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kunjungan</label>
                                <p class="text-sm text-gray-900">{{ ucfirst($kunjunganTindakan->kunjungan->jenis_kunjungan) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dokter</label>
                                <p class="text-sm text-gray-900">{{ $kunjunganTindakan->kunjungan->dokter->nama ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tindakan</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Tindakan</label>
                                <p class="text-sm text-gray-900">{{ $kunjunganTindakan->tindakan->nama ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                                <p class="text-sm text-gray-900">{{ $kunjunganTindakan->jumlah }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tarif per Unit</label>
                                <p class="text-sm text-gray-900">Rp {{ number_format($kunjunganTindakan->tarif, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Subtotal</label>
                                <p class="text-lg font-semibold text-green-600">Rp {{ number_format($kunjunganTindakan->subtotal, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Dibuat</label>
                                <p class="text-sm text-gray-900">{{ $kunjunganTindakan->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($kunjunganTindakan->catatan)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-900">{{ $kunjunganTindakan->catatan }}</p>
                    </div>
                </div>
                @endif

                @if($kunjunganTindakan->tindakan)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Tindakan (Master Data)</h3>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Tindakan</label>
                                <p class="text-sm text-gray-900">{{ $kunjunganTindakan->tindakan->nama }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tarif Standard</label>
                                <p class="text-sm text-gray-900">Rp {{ number_format($kunjunganTindakan->tindakan->tarif, 0, ',', '.') }}</p>
                            </div>
                            @if($kunjunganTindakan->tindakan->deskripsi)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <p class="text-sm text-gray-900">{{ $kunjunganTindakan->tindakan->deskripsi }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

</div>
@endsection
