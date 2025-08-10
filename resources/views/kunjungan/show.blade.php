@extends('layouts.app')

@section('title', 'Detail Kunjungan')

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
                    <span class="text-sm font-medium text-gray-500">Detail Kunjungan</span>
                </div>
            </li>
        </ol>
    </nav>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detail Kunjungan</h1>
            <div class="flex space-x-2">
                @if(auth()->user() && auth()->user()->hasPermission('kunjungan.update'))
                <a href="{{ route('kunjungan.edit', $kunjungan) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                @endif
                <a href="{{ route('kunjungan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pasien</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                                <p class="text-sm text-gray-900">{{ $kunjungan->pasien->nama ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                <p class="text-sm text-gray-900">{{ $kunjungan->pasien->pekerjaan ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <p class="text-sm text-gray-900">{{ $kunjungan->pasien->jenis_kelamin ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <p class="text-sm text-gray-900">
                                    {{ $kunjungan->pasien->tanggal_lahir ? \Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->format('d/m/Y') : '-' }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                <p class="text-sm text-gray-900">{{ $kunjungan->pasien->no_telp ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kunjungan</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Kunjungan</label>
                                <p class="text-sm text-gray-900">{{ $kunjungan->tanggal_kunjungan->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kunjungan</label>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($kunjungan->jenis_kunjungan === 'darurat') bg-red-100 text-red-800
                                    @elseif($kunjungan->jenis_kunjungan === 'rujukan') bg-yellow-100 text-yellow-800
                                    @elseif($kunjungan->jenis_kunjungan === 'kontrol') bg-blue-100 text-blue-800
                                    @elseif($kunjungan->jenis_kunjungan === 'vaksinasi') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($kunjungan->jenis_kunjungan) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dokter</label>
                                <p class="text-sm text-gray-900">{{ $kunjungan->dokter->nama ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Didaftarkan Oleh</label>
                                <p class="text-sm text-gray-900">{{ $kunjungan->pendaftar->nama ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Didaftarkan</label>
                                <p class="text-sm text-gray-900">{{ $kunjungan->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keluhan</label>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-900">{{ $kunjungan->keluhan ?: 'Tidak ada keluhan yang dicatat' }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Diagnosa</label>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-900">{{ $kunjungan->diagnosa ?: 'Belum ada diagnosa' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
@endsection
