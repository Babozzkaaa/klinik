@extends('layouts.app')

@section('title', 'Detail Obat')

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
                    <a href="{{ route('obat.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Obat</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Detail Obat</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Detail Obat</h2>
            <div class="flex space-x-2">
                @if(auth()->user() && auth()->user()->hasPermission('obat.update'))
                <a href="{{ route('obat.edit', $obat) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                @endif
                <a href="{{ route('obat.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Obat</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $obat->kode_obat }}</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Obat</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $obat->nama_obat }}</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Obat</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $obat->jenis_obat }}</span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok Tersedia</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $obat->stok }} {{ $obat->satuan }}</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">Rp {{ number_format($obat->harga, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kadaluarsa</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</div>
@endsection