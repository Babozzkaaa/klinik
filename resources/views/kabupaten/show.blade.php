@extends('layouts.app')

@section('title', 'Detail Kabupaten/Kota')

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
                    <a href="{{ route('kabupaten.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Kabupaten/Kota</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Detail Kabupaten/Kota</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Detail Kabupaten/Kota</h2>
            <div class="flex space-x-2">
                @if(auth()->user() && auth()->user()->hasPermission('kabupaten.update'))
                <a href="{{ route('kabupaten.edit', $kabupaten) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                @endif
                <a href="{{ route('kabupaten.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kabupaten/Kota</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $kabupaten->nama }}</span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Kabupaten/Kota</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $kabupaten->kode }}
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ $kabupaten->provinsi->nama }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dibuat</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $kabupaten->created_at->format('d M Y H:i:s') }}</span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diupdate</label>
                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span class="text-gray-900">{{ $kabupaten->updated_at->format('d M Y H:i:s') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
