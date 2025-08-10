@extends('layouts.app')

@section('title', 'Detail Permission')

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
                    <span class="text-gray-500">Detail: {{ $permission->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
            <div class="bg-green-600 px-6 py-4">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Permission
                </h3>
            </div>
            
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 uppercase tracking-wide">Nama Permission</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $permission->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 uppercase tracking-wide">Kode Permission</dt>
                        <dd class="mt-1">
                            <span class="bg-gray-100 text-gray-800 text-sm font-mono px-3 py-1 rounded">
                                {{ $permission->code }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 uppercase tracking-wide">Digunakan oleh Role</dt>
                        <dd class="mt-1">
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
                                {{ $permission->roles->count() }} Role
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 uppercase tracking-wide">Dibuat</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $permission->created_at->format('d F Y, H:i') }}</dd>
                    </div>
                </dl>

                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
                    <a href="{{ route('admin.permissions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-md">
                        <i class="fas fa-edit mr-2"></i>Edit Permission
                    </a>
                </div>
            </div>
        </div>

        @if($permission->roles->count() > 0)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-user-tag mr-2"></i>
                    Role yang Menggunakan Permission Ini
                </h3>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($permission->roles as $role)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-user-tag text-blue-600 mr-3"></i>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $role->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $role->users->count() }} user menggunakan role ini</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.roles.show', $role->id) }}" class="text-blue-600 hover:text-blue-800 text-xs">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6 text-center">
                <i class="fas fa-user-tag text-gray-400 text-4xl mb-3"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Permission Belum Digunakan</h3>
                <p class="text-gray-500 mb-4">Permission ini belum digunakan oleh role manapun.</p>
                <a href="{{ route('admin.roles.index') }}" class="text-blue-600 hover:text-blue-800">
                    Kelola Role untuk menambahkan permission ini
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
