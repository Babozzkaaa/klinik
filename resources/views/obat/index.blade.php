@extends('layouts.app')

@section('title', 'Daftar Obat')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Obat</h2>
        @if(auth()->user() && auth()->user()->hasPermission('obat.create'))
        <a href="{{ route('obat.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Obat
        </a>
        @endif
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('obat.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Obat</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                    placeholder="Nama atau kode obat..."
                    class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="jenis_obat" class="block text-sm font-medium text-gray-700 mb-1">Jenis Obat</label>
                <select name="jenis_obat" id="jenis_obat" 
                    class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Jenis</option>
                    <option value="Tablet" {{ request('jenis_obat') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="Kapsul" {{ request('jenis_obat') == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                    <option value="Sirup" {{ request('jenis_obat') == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                    <option value="Salep" {{ request('jenis_obat') == 'Salep' ? 'selected' : '' }}>Salep</option>
                    <option value="Injeksi" {{ request('jenis_obat') == 'Injeksi' ? 'selected' : '' }}>Injeksi</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center mr-2">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('obat.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
                    <i class="fas fa-undo mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    @if(request()->hasAny(['search', 'jenis_obat', 'sort_by']))
    <div class="mb-4 text-sm text-gray-600">
        <i class="fas fa-info-circle mr-1"></i>
        Menampilkan {{ $obats->count() }} dari {{ $obats->total() }} obat
        @if(request('search'))
            untuk pencarian "<strong>{{ request('search') }}</strong>"
        @endif
        @if(request('jenis_obat'))
            dengan jenis: <strong>{{ request('jenis_obat') }}</strong>
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
                            <a href="#" onclick="sortTable('kode_obat')" class="flex items-center hover:text-blue-600 transition-colors cursor-pointer">
                                Kode Obat
                                <i id="sort-kode_obat" class="fas fa-sort ml-1 text-gray-400"></i>
                            </a>
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <a href="#" onclick="sortTable('nama_obat')" class="flex items-center hover:text-blue-600 transition-colors cursor-pointer">
                                Nama Obat
                                <i id="sort-nama_obat" class="fas fa-sort ml-1 text-gray-400"></i>
                            </a>
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <a href="#" onclick="sortTable('jenis_obat')" class="flex items-center hover:text-blue-600 transition-colors cursor-pointer">
                                Jenis
                                <i id="sort-jenis_obat" class="fas fa-sort ml-1 text-gray-400"></i>
                            </a>
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <a href="#" onclick="sortTable('stok')" class="flex items-center hover:text-blue-600 transition-colors cursor-pointer">
                                Stok
                                <i id="sort-stok" class="fas fa-sort ml-1 text-gray-400"></i>
                            </a>
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <a href="#" onclick="sortTable('harga')" class="flex items-center hover:text-blue-600 transition-colors cursor-pointer">
                                Harga
                                <i id="sort-harga" class="fas fa-sort ml-1 text-gray-400"></i>
                            </a>
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody id="obat-table-body">
                    @forelse($obats as $obat)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ ($obats->currentPage() - 1) * $obats->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $obat->kode_obat }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $obat->nama_obat }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $obat->jenis_obat }}
                        </td>
                        @if($obat->stok > 0)
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $obat->stok }} {{ $obat->satuan }}
                            </td>
                        @else
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-red-700">
                                Stok Habis
                            </td>
                        @endif
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            Rp {{ number_format($obat->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="flex space-x-2 gap-3">
                                @if(auth()->user() && auth()->user()->hasPermission('obat.read'))
                                <a href="{{ route('obat.show', $obat->id) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif
                                @if(auth()->user() && auth()->user()->hasPermission('obat.update'))
                                <a href="{{ route('obat.edit', $obat->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                                @if(auth()->user() && auth()->user()->hasPermission('obat.delete'))
                                <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus obat ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                            Tidak ada data obat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($obats->hasPages())
        <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
            {{ $obats->links() }}
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