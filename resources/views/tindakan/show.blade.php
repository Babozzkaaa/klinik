@extends('layouts.app')

@section('title', 'Detail Tindakan')

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
                    <a href="{{ route('tindakan.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Tindakan</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Detail Tindakan</span>
                </div>
            </li>
        </ol>
    </nav>


    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Detail Tindakan</h2>
            <div class="flex space-x-2">
                @if(auth()->user() && auth()->user()->hasPermission('tindakan.update'))
                <a href="{{ route('tindakan.edit', $tindakan) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                @endif
                <a href="{{ route('tindakan.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Tindakan</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    {{ $tindakan->nama }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tarif</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    Rp {{ number_format($tindakan->tarif, 0, ',', '.') }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dibuat Pada</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    {{ $tindakan->created_at->format('d/m/Y H:i') }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Terakhir Diperbarui</label>
                <div class="bg-gray-50 border border-gray-300 rounded-md p-3">
                    {{ $tindakan->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
