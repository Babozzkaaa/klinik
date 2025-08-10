@extends('layouts.app')

@section('title', 'Detail Pegawai')

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
                    <a href="{{ route('pegawai.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Pegawai</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Detail Pegawai</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Detail Pegawai</h2>
            <div class="flex space-x-2">
                @if(auth()->user() && auth()->user()->hasPermission('pegawai.update'))
                <a href="{{ route('pegawai.edit', $pegawai) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                @endif
                <a href="{{ route('pegawai.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Informasi Personal</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $pegawai->nama }}</span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $pegawai->nip }}
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $pegawai->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                            {{ $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Informasi Pekerjaan</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $pegawai->jabatan == 'Dokter' ? 'bg-green-100 text-green-800' : 
                               ($pegawai->jabatan == 'Perawat' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ $pegawai->jabatan }}
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Spesialisasi</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $pegawai->spesialisasi ?? 'Tidak ada spesialisasi' }}</span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Informasi Lokasi</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ $pegawai->provinsi->nama }}
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $pegawai->kabupaten->nama }}
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $pegawai->alamat }}</span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">User Account</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama User</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $pegawai->user->name }}</span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $pegawai->user->email }}</span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Akun</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $pegawai->isAktif() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $pegawai->isAktif() ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Informasi Waktu</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dibuat</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $pegawai->created_at->format('d M Y H:i:s') }}</span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diupdate</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $pegawai->updated_at->format('d M Y H:i:s') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
