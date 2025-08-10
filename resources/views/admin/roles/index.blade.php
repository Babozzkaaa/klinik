@extends('layouts.app')

@section('title', 'Manajemen Role')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Manajemen Role</h2>
            <p class="text-gray-600">Kelola role dan permission sistem</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.permissions.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-key mr-2"></i> Kelola Permission
            </a>
            <a href="{{ route('admin.roles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Role
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('admin.roles.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Role</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                    placeholder="Nama role..."
                    class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
                        
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center mr-2">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.roles.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
                    <i class="fas fa-undo mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    @if(request()->hasAny(['search', 'permission_count', 'sort_by']))
    <div class="mb-4 text-sm text-gray-600">
        <i class="fas fa-info-circle mr-1"></i>
        Menampilkan {{ $roles->count() }} dari {{ $roles->total() }} role
        @if(request('search'))
            untuk pencarian "<strong>{{ request('search') }}</strong>"
        @endif
        @if(request('permission_count'))
            dengan filter permission: <strong>{{ request('permission_count') }}</strong>
        @endif
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            No
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <a href="#" onclick="sortTable('name')" class="flex items-center hover:text-blue-600 transition-colors cursor-pointer">
                                Nama Role
                                <i id="sort-name" class="fas fa-sort ml-1 text-gray-400"></i>
                            </a>
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <a href="#" onclick="sortTable('permissions_count')" class="flex items-center hover:text-blue-600 transition-colors cursor-pointer">
                                Jumlah Permission
                                <i id="sort-permissions_count" class="fas fa-sort ml-1 text-gray-400"></i>
                            </a>
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <a href="#" onclick="sortTable('users_count')" class="flex items-center hover:text-blue-600 transition-colors cursor-pointer">
                                Jumlah User
                                <i id="sort-users_count" class="fas fa-sort ml-1 text-gray-400"></i>
                            </a>
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <a href="#" onclick="sortTable('created_at')" class="flex items-center hover:text-blue-600 transition-colors cursor-pointer">
                                Dibuat
                                <i id="sort-created_at" class="fas fa-sort ml-1 text-gray-400"></i>
                            </a>
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody id="roles-table-body">
                    @forelse($roles as $role)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="flex items-center">
                                <i class="fas fa-user-tag text-blue-600 mr-2"></i>
                                <span class="font-medium">{{ $role->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $role->permissions->count() }} Permission
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $role->users->count() }} User
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $role->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.roles.show', $role->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 p-2 rounded">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 hover:bg-yellow-200 p-2 rounded">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($role->users->count() == 0)
                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus role ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 p-2 rounded">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <span class="text-gray-400 bg-gray-100 p-2 rounded cursor-not-allowed" title="Tidak dapat dihapus karena masih digunakan">
                                    <i class="fas fa-trash"></i>
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                            <div class="flex flex-col items-center justify-center py-4">
                                <i class="fas fa-user-tag text-gray-400 text-4xl mb-2"></i>
                                <p class="text-gray-500">Tidak ada data role.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($roles->hasPages())
        <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
            {{ $roles->links() }}
        </div>
        @endif
    </div>
</div>

<script>
let currentSort = '{{ request('sort_by', '') }}';
let currentDirection = '{{ request('sort_direction', 'asc') }}';

document.addEventListener('DOMContentLoaded', function() {
    updateSortIcons();
});

function sortTable(column) {
    let direction = 'asc';
    if (currentSort === column && currentDirection === 'asc') {
        direction = 'desc';
    }
    
    currentSort = column;
    currentDirection = direction;
    
    const url = new URL(window.location);
    url.searchParams.set('sort_by', column);
    url.searchParams.set('sort_direction', direction);
    
    window.location.href = url.toString();
}

function updateSortIcons() {
    document.querySelectorAll('[id^="sort-"]').forEach(icon => {
        icon.className = 'fas fa-sort ml-1 text-gray-400';
    });
    
    if (currentSort) {
        const icon = document.getElementById('sort-' + currentSort);
        if (icon) {
            if (currentDirection === 'desc') {
                icon.className = 'fas fa-sort-down ml-1';
            } else {
                icon.className = 'fas fa-sort-up ml-1';
            }
        }
    }
}
</script>
@endsection
