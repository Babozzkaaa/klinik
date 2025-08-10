@extends('layouts.app')

@section('title', 'Manajemen Permission')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Manajemen Permission</h2>
            <p class="text-gray-600">Kelola permission sistem</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.roles.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-user-tag mr-2"></i> Kelola Role
            </a>
            <a href="{{ route('admin.permissions.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Permission
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
        <form method="GET" action="{{ route('admin.permissions.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Permission</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                    placeholder="Nama atau kode permission..."
                    class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500">
            </div>
                        
            <div class="flex items-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center mr-2">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                <a href="{{ route('admin.permissions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
                    <i class="fas fa-undo mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    @if(request()->hasAny(['search', 'section', 'sort_by']))
    <div class="mb-4 text-sm text-gray-600">
        <i class="fas fa-info-circle mr-1"></i>
        Menampilkan {{ $permissions->count() }} dari {{ $permissions->total() }} permission
        @if(request('search'))
            untuk pencarian "<strong>{{ request('search') }}</strong>"
        @endif
        @if(request('section'))
            di section: <strong>{{ ucfirst(request('section')) }}</strong>
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
                            <a href="#" onclick="sortTable('name')" class="flex items-center hover:text-green-600 transition-colors cursor-pointer">
                                Nama Permission
                                <i id="sort-name" class="fas fa-sort ml-1 text-gray-400"></i>
                            </a>
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <a href="#" onclick="sortTable('code')" class="flex items-center hover:text-green-600 transition-colors cursor-pointer">
                                Kode Permission
                                <i id="sort-code" class="fas fa-sort ml-1 text-gray-400"></i>
                            </a>
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <a href="#" onclick="sortTable('roles_count')" class="flex items-center hover:text-green-600 transition-colors cursor-pointer">
                                Digunakan oleh Role
                                <i id="sort-roles_count" class="fas fa-sort ml-1 text-gray-400"></i>
                            </a>
                        </th>                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody id="permissions-table-body">
                    @forelse($permissions as $permission)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ ($permissions->currentPage() - 1) * $permissions->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="flex items-center">
                                <i class="fas fa-key text-green-600 mr-2"></i>
                                <span class="font-medium">{{ $permission->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span class="bg-gray-100 text-gray-800 text-xs font-mono px-2 py-1 rounded">
                                {{ $permission->code }}
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            @if($permission->roles->count() > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach($permission->roles as $role)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                                        {{ $role->name }}
                                    </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">Tidak digunakan</span>
                            @endif
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.permissions.show', $permission->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 p-2 rounded">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 hover:bg-yellow-200 p-2 rounded">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($permission->roles->count() == 0)
                                <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permission ini?');" class="inline">
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
                                <i class="fas fa-key text-gray-400 text-4xl mb-2"></i>
                                <p class="text-gray-500">Tidak ada data permission.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($permissions->hasPages())
        <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
            {{ $permissions->links() }}
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
