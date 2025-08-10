@extends('layouts.app')

@section('title', 'Detail Pasien')

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
                    <a href="{{ route('pasien.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Pasien</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Detail Pasien</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Detail Pasien</h2>
            <div class="flex space-x-2">
                @if(auth()->user() && auth()->user()->hasPermission('pasien.update'))
                <a href="{{ route('pasien.edit', $pasien) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                @endif

                <a href="{{ route('pasien.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pasien</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    {{ $pasien->nama }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    {{ $pasien->no_telp ?: '-' }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d/m/Y') }}
                    <span class="text-gray-500">({{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} tahun)</span>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    {{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Golongan Darah</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    {{ $pasien->gol_darah ?: '-' }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    {{ $pasien->pekerjaan ?: '-' }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    {{ $pasien->provinsi->nama ?? '-' }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kabupaten/Kota</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    {{ $pasien->kabupaten->nama ?? '-' }}
                </div>
            </div>
        </div>
        
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
            <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                {{ $pasien->alamat }}
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alergi</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3 min-h-[80px]">
                    {{ $pasien->alergi ?: 'Tidak ada alergi yang tercatat' }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Riwayat Penyakit</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3 min-h-[80px]">
                    {{ $pasien->riwayat_penyakit ?: 'Tidak ada riwayat penyakit yang tercatat' }}
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dibuat Pada</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    {{ $pasien->created_at->format('d/m/Y H:i') }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Terakhir Diperbarui</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    {{ $pasien->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
