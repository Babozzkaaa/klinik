@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    @if(session('status'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline">{{ session('status') }}</span>
    </div>
    @endif

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-tachometer-alt mr-3 text-blue-600"></i>Dashboard Admin
        </h1>
        <p class="text-gray-600">Selamat datang di Sistem Manajemen Klinik</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-users text-3xl text-blue-500"></i>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Total Pasien</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $totalPasien }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-user-md text-3xl text-green-500"></i>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Total Dokter</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $totalDokter }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-pills text-3xl text-yellow-500"></i>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Total Obat</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $totalObat }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-calendar-day text-3xl text-red-500"></i>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Kunjungan Hari Ini</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $kunjunganHariIni }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1  gap-6">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-bolt mr-2 text-blue-600"></i>Menu Cepat
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    @if(auth()->user() && auth()->user()->hasPermission('obat.read'))
                    <a href="{{ route('obat.index') }}" class="bg-blue-50 hover:bg-blue-100 p-4 rounded-lg text-center transition duration-150">
                        <i class="fas fa-pills text-2xl text-blue-600 mb-2"></i>
                        <p class="text-sm font-medium text-gray-800">Kelola Obat</p>
                    </a>
                    @endif
                    @if(auth()->user() && auth()->user()->hasPermission('pasien.read'))
                    <a href="{{ route('pasien.index') }}" class="bg-green-50 hover:bg-green-100 p-4 rounded-lg text-center transition duration-150">
                        <i class="fas fa-user-injured text-2xl text-green-600 mb-2"></i>
                        <p class="text-sm font-medium text-gray-800">Daftar Pasien</p>
                    </a>
                    @endif
                    @if(auth()->user() && auth()->user()->hasPermission('kunjungan.read'))
                    <a href="{{ route('kunjungan.index') }}" class="bg-yellow-50 hover:bg-yellow-100 p-4 rounded-lg text-center transition duration-150">
                        <i class="fas fa-user-md text-2xl text-yellow-600 mb-2"></i>
                        <p class="text-sm font-medium text-gray-800">Kunjungan</p>
                    </a>
                    @endif
                    @if(auth()->user() && auth()->user()->hasPermission('laporan.read'))
                    <a href="{{ route('laporan.index') }}" class="bg-red-50 hover:bg-red-100 p-4 rounded-lg text-center transition duration-150">
                        <i class="fas fa-chart-bar text-2xl text-red-600 mb-2"></i>
                        <p class="text-sm font-medium text-gray-800">Laporan</p>
                    </a>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
