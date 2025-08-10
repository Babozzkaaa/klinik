@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
<div class="container mx-auto px-4 py-6">
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.permissions.index') }}" class="text-green-600 hover:text-green-800">
                    <i class="fas fa-key mr-2"></i>
                    Manajemen Permission
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">Edit: {{ $permission->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-yellow-600 px-6 py-4">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Permission: {{ $permission->name }}
                </h3>
            </div>
            
            <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Permission</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500"
                            value="{{ old('name', $permission->name) }}" placeholder="Contoh: Dashboard Admin, Kelola Produk">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Kode Permission</label>
                        <input type="text" name="code" id="code" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500"
                            value="{{ old('code', $permission->code) }}" placeholder="Contoh: admin_dashboard, manage_produk">
                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Kode unik untuk identifikasi permission dalam sistem (gunakan underscore, lowercase)</p>
                    </div>
                </div>

                @if($permission->roles->count() > 0)
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
                    <h4 class="text-sm font-medium text-blue-800 mb-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Role yang menggunakan permission ini:
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($permission->roles as $role)
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                            {{ $role->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
                    <a href="{{ route('admin.permissions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-md">
                        <i class="fas fa-save mr-2"></i>Update Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
