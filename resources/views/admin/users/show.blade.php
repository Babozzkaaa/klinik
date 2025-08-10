@extends('layouts.app')

@section('title', 'Detail User')

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
                    <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">User</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Detail User</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Detail User</h2>
            <p class="text-gray-600">Informasi lengkap user sistem</p>
        </div>
        <div class="flex space-x-2">
            @if(!$user->isAdmin() || auth()->user()->isAdmin())
            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi User</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <div class="flex items-center">
                            <i class="fas fa-user text-green-600 mr-2"></i>
                            <span class="text-gray-900">{{ $user->name }}</span>
                            @if($user->isAdmin())
                                <span class="ml-2 bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded">
                                    ADMIN
                                </span>
                            @endif
                            @if($user->id === auth()->id())
                                <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                                    YOU
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-green-600 mr-2"></i>
                            <span class="text-gray-900">{{ $user->email }}</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <div class="flex items-center">
                            <i class="fas fa-user-tag text-green-600 mr-2"></i>
                            @if($user->role)
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                                    {{ $user->role->name }}
                                </span>
                            @else
                                <span class="text-gray-400 text-sm">Tidak ada role</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <div class="flex items-center">
                            <i class="fas fa-circle text-green-600 mr-2 {{ $user->isAktif() ? 'text-green-600' : 'text-red-600' }}"></i>
                            @if($user->isAktif())
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded">
                                    AKTIF
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded">
                                    TIDAK AKTIF
                                </span>
                            @endif
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div>
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-key text-green-600 mr-2"></i>
                    Permissions
                </h3>
                
                @if($user->isAdmin())
                    <div class="text-center py-4">
                        <i class="fas fa-crown text-yellow-500 text-3xl mb-2"></i>
                        <p class="text-sm text-gray-600 font-medium">AKSES PENUH</p>
                        <p class="text-xs text-gray-500">Admin memiliki semua permission</p>
                    </div>
                @else
                    @php
                        $permissions = $user->getAllPermissions();
                        $groupedPermissions = $permissions->groupBy(function($permission) {
                            return explode('.', $permission->code)[0];
                        });
                    @endphp

                    @if($permissions->count() > 0)
                        <div class="space-y-3">
                            @foreach($groupedPermissions as $section => $sectionPermissions)
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2 capitalize">
                                    {{ ucfirst($section) }}
                                </h4>
                                <div class="space-y-1">
                                    @foreach($sectionPermissions as $permission)
                                    <div class="flex items-center text-xs">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        <span class="text-gray-600">{{ $permission->name }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Tidak ada permission</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
