@extends('layouts.app')

@section('title', 'Detail Role')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.roles.index') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-user-tag mr-2"></i>
                    Manajemen Role
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">Detail Role: {{ $role->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-4xl mx-auto">
        <!-- Role Info Card -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
            <div class="bg-blue-600 px-6 py-4">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Role
                </h3>
            </div>
            
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 uppercase tracking-wide">Nama Role</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $role->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 uppercase tracking-wide">Jumlah Permission</dt>
                        <dd class="mt-1">
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
                                {{ $role->permissions->count() }} Permission
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 uppercase tracking-wide">Jumlah User</dt>
                        <dd class="mt-1">
                            <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
                                {{ $role->users->count() }} User
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 uppercase tracking-wide">Dibuat</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $role->created_at->format('d F Y, H:i') }}</dd>
                    </div>
                </dl>

                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
                    <a href="{{ route('admin.roles.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-md">
                        <i class="fas fa-edit mr-2"></i>Edit Role
                    </a>
                </div>
            </div>
        </div>

        <!-- Permissions Card -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
            <div class="bg-green-600 px-6 py-4">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-key mr-2"></i>
                    Permission yang Dimiliki
                </h3>
            </div>
            
            <div class="p-6">
                @if($role->permissions->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($role->permissions as $permission)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-shield-alt text-green-600 mr-3"></i>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $permission->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $permission->code }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-key text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500">Role ini belum memiliki permission.</p>
                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                            Tambah Permission
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Users Card -->
        @if($role->users->count() > 0)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-purple-600 px-6 py-4">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-users mr-2"></i>
                    User yang Menggunakan Role Ini
                </h3>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($role->users as $user)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-user text-purple-600 mr-3"></i>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">{{ $user->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
