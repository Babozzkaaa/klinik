@extends('layouts.app')

@section('title', 'Edit User')

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
                    <span class="text-sm font-medium text-gray-500">Edit User</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Edit User</h2>
            <p class="text-gray-600">Perbarui informasi user</p>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500"
                        placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500"
                        placeholder="user@example.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password Baru 
                        @if($user->id === auth()->id())
                            <span class="text-gray-500">(kosongkan jika tidak ingin mengubah)</span>
                        @else
                            <span class="text-gray-500">(tidak dapat diubah untuk akun orang lain)</span>
                        @endif
                    </label>
                    <input type="password" name="password" id="password"
                        {{ $user->id !== auth()->id() ? 'disabled' : '' }}
                        class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 {{ $user->id !== auth()->id() ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                        placeholder="{{ $user->id === auth()->id() ? 'Minimal 8 karakter' : 'Password tidak dapat diubah' }}">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password Baru
                        @if($user->id !== auth()->id())
                            <span class="text-gray-500">(tidak dapat diubah untuk akun orang lain)</span>
                        @endif
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        {{ $user->id !== auth()->id() ? 'disabled' : '' }}
                        class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 {{ $user->id !== auth()->id() ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                        placeholder="{{ $user->id === auth()->id() ? 'Ulangi password baru' : 'Password tidak dapat diubah' }}">
                </div>

                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Role <span class="text-red-500">*</span>
                        @if($user->id === auth()->id())
                            <span class="text-sm text-gray-500">(tidak dapat diubah untuk akun sendiri)</span>
                        @endif
                    </label>
                    <select name="role_id" id="role_id" required
                        {{ $user->id === auth()->id() ? 'disabled' : '' }}
                        class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 {{ $user->id === auth()->id() ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                        <option value="">Pilih Role</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                    @if($user->id === auth()->id())
                        <input type="hidden" name="role_id" value="{{ $user->role_id }}">
                    @endif
                    @error('role_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                        @if($user->id === auth()->id())
                            <span class="text-sm text-gray-500">(tidak dapat diubah untuk akun sendiri)</span>
                        @endif
                    </label>
                    <select name="status" id="status" required
                        {{ $user->id === auth()->id() ? 'disabled' : '' }}
                        class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 {{ $user->id === auth()->id() ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                        <option value="1" {{ old('status', $user->status ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status', $user->status ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @if($user->id === auth()->id())
                        <input type="hidden" name="status" value="{{ $user->status ? '1' : '0' }}">
                    @endif
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if($user->isAdmin())
            <div class="mt-4 p-4 bg-yellow-50 border-l-4 border-yellow-400">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Perhatian:</strong> Ini adalah user Admin yang memiliki akses penuh ke semua fitur sistem.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            @if($user->id === auth()->id())
            <div class="mt-4 p-4 bg-blue-50 border-l-4 border-blue-400">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Info:</strong> Anda sedang mengedit akun sendiri. Role dan status tidak dapat diubah untuk keamanan sistem.
                        </p>
                    </div>
                </div>
            </div>
            @else
            <div class="mt-4 p-4 bg-orange-50 border-l-4 border-orange-400">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-shield-alt text-orange-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-orange-700">
                            <strong>Keamanan:</strong> Password hanya dapat diubah oleh pemilik akun masing-masing. Admin tidak dapat mengubah password user lain untuk keamanan sistem.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
                    Batal
                </a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-save mr-2"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
